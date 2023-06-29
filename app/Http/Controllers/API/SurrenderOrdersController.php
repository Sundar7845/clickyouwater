<?php

// app/Http/Controllers/API/OrdersController.php

namespace App\Http\Controllers\API;

use App\Enums\DocumentModulesType;
use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SurrenderOrderResource;
use App\Http\Resources\UserAddressResource;
use App\Models\Cart;
use App\Models\CustomerStock;
use App\Models\CustomerStockHistory;
use App\Models\DeliveryPerson;
use App\Models\Products;
use App\Models\Status;
use App\Models\Surrender;
use App\Models\SurrenderDet;
use App\Models\SurrenderHistory;
use App\Models\User;
use App\Traits\Common;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;

class SurrenderOrdersController extends Controller
{
    use ResponseAPI;
    use Common;


    public function placeSurrenderOrder(Request $request)
    {
        $validator = $request->validate([
            'reason_id' => 'required',
            'hub_id' => 'required',
            'total_qty' => 'required',
            'address_id' => 'required',
            'pickup_address' => 'required',
            'refund_amount' => 'required',
            'refund_to' => 'required',
            'product_details' => 'required|array',
            'product_details.*.product_id' => 'required',
            'product_details.*.qty' => 'required',
        ]);
        // dd($request->all());
        DB::beginTransaction();

        try {
            $surrender_order_no = $this->getAutoGeneratedCode(DocumentModulesType::Surrender);
            // dd($surrender_order_no);
            $this->updateLiveCount(DocumentModulesType::Surrender, 1);

            $surrender_orders = Surrender::create([
                'surrender_order_no' => $surrender_order_no,
                'reason_id' => $request->reason_id,
                'user_id' => Auth::user()->id,
                'hub_id' => $request->hub_id,
                'total_qty' => $request->total_qty,
                'address_id' => $request->address_id,
                'pickup_address' => $request->pickup_address,
                'status_id' => StatusTypes::SurrenderRequested,
                'refund_amount' => $request->refund_amount,
                'refund_to' => strtolower($request->refund_to),
            ]);
            $product_details = $request->product_details;
            foreach ($product_details as $value) {
                SurrenderDet::create([
                    'surrender_id' => $surrender_orders->id,
                    'product_id' => $value['product_id'],
                    'qty' => $value['qty'],
                    'deposit_amount' => $value['deposit_amount']
                ]);

                //Delete the user cart product matched the surrender request product 
                Cart::where('user_id', Auth::user()->id)->where('product_id', $value['product_id'])->delete();

                //Reduce customer stock 
                $cus_stock = CustomerStock::where('address_id', $request->address_id)
                    ->where('product_id', $value['product_id'])->first();
                if ($cus_stock) {
                    $cus_stock->empty_qty -= $value['qty'];
                    $cus_stock->save();
                }

                $product = Products::find($value['product_id']);
                CustomerStockHistory::create([
                    'user_id' => Auth::user()->id,
                    'product_type_id' => $product->productType->id,
                    'brand_id' => $product->brand->id,
                    'category_id' => $product->category->id,
                    'product_id' => $value['product_id'],
                    'outward_empty_to_delivery_qty' => $value['qty']
                ]);
            }

            //Add surrender order status history
            $this->addSurrenderHistory($surrender_orders->id, StatusTypes::SurrenderRequested);

            $response = [
                'status' => true,
                'data' => ['surrender_id' => $surrender_orders->id, 'surrender_order_no' => $surrender_order_no],
                'message' => "Surrender request send to admin for approval"
            ];
            DB::commit(); // Commit the transaction

            // Send notification
            $this->sendSurrenderNotification($surrender_orders->id, StatusTypes::SurrenderRequested);

            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollback(); // Roll back the transaction if an error occurs

            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }

    public function getSurrenderOrderHistory()
    {
        try {

            if (Auth::user()->role_id == RoleTypes::Customer) {
                $surrender_orders = Surrender::where('user_id', Auth::user()->id)->orderBy('id', 'desc');
            } else if (Auth::user()->role_id == RoleTypes::Hub) {
                $surrender_orders = Surrender::whereIn('status_id', [StatusTypes::SurrenderApproved, StatusTypes::AssignedForPickup])
                    ->where('hub_id', Auth::user()->ref_id)->orderBy('id', 'desc');
            }
            $surrender_orders = $surrender_orders->paginate($this->recordsperpage);

            $response = array(
                'message' => "Success",
                'data' => SurrenderOrderResource::collection($surrender_orders),
                'pagination' => [
                    'total' => $surrender_orders->total(),
                    'per_page' => $surrender_orders->perPage(),
                    'current_page' => $surrender_orders->currentPage(),
                    'last_page' => $surrender_orders->lastPage(),
                    'next_page_url' => $surrender_orders->nextPageUrl(),
                    'prev_page_url' => $surrender_orders->previousPageUrl(),
                ],
                'status' => true,
            );
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    public function getSurrenderOrderDetails($id)
    {
        try {
            $surrenderdetails = Surrender::where('id', $id)->with('products.surrenderDets')->get();

            foreach ($surrenderdetails as $surrenderdetail) {

                $surrenderdetails = [
                    'surrender_id' => $surrenderdetail->id,
                    'surrender_order_no' => $surrenderdetail->surrender_order_no,
                    'reason_id' => $surrenderdetail->reason_id,
                    'reason' => $surrenderdetail->reason->reason,
                    'hub_id' => $surrenderdetail->hub_id,
                    'status_id' => $surrenderdetail->status_id,
                    'status_name' => $surrenderdetail->status->status,
                    'status_msg' => $surrenderdetail->status->status_msg,
                    'status_color_css' => $surrenderdetail->status->status_color_css,
                    'address_id' => $surrenderdetail->address_id,
                    'address' => UserAddressResource::collection($this->getCustomerAddress_details($surrenderdetail->address_id, $surrenderdetail->user_id))->values(),
                    'refund_amount' => $surrenderdetail->refund_amount,
                    'refund_to' => $surrenderdetail->refund_to,
                    'reject_reason_note' => $surrenderdetail->reject_reason_note,
                    'created_at' => DateTime::createFromFormat('Y-m-d H:i:s', $surrenderdetail->created_at)->format('d M,y'),
                    'surrender_details' => $surrenderdetail->surrenderDets->map(function ($surrenderdet) {
                        if ($surrenderdet->products) {
                            return [
                                'product_id' => $surrenderdet->product_id,
                                'product_name' => $surrenderdet->products->product_name,
                                'quantity' => $surrenderdet->qty,
                                'deposit_amount' => $surrenderdet->deposit_amount,
                                'collected_can_qty' => $surrenderdet->collected_can_qty,
                                'damaged_can_qty' => $surrenderdet->damaged_can_qty,
                            ];
                        }
                        return null; // Return null or handle the case when 'products' is null
                    })->filter(),
                    'surrender_tracking_history' => $surrenderdetail->surrenderHistory->sortBy('created_at')->map(function ($surrenderHistory) use ($surrenderdetail) {
                        return [
                            'status_name' => $surrenderHistory->status->status,
                            'status_msg' => $surrenderHistory->status->status_msg,
                            'current_status' => ($surrenderHistory->status_id == $surrenderdetail->status_id) ? true : false,
                            'date' => DateTime::createFromFormat('Y-m-d H:i:s', $surrenderHistory->created_at)->format('d M,y, h:i A'),
                        ];
                    }),
                    'pickup_details' => $surrenderdetail->surrenderPickups->map(function ($pickup) {
                        return [
                            'delivery_id' => $pickup->id,
                            'delivery_user_id' => $pickup->delivery_user_id,
                            'delivery_person_name' => $this->getPickupPersonName($pickup->delivery_user_id),
                            'notes' => $pickup->notes,
                            'picked_on' => DateTime::createFromFormat('Y-m-d H:i:s', $pickup->created_at)->format('d M,y H:i A'),
                        ];
                    })->values(),
                ];
            }

            $response = array(
                'message' => "Success",
                'data' => $surrenderdetails,
                'status' => true,
            );
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }

    public function cancelSurrenderRequest($id)
    {
        DB::beginTransaction();

        try {
            //Update surrender status
            $surrender = Surrender::find($id);
            $surrender->status_id = StatusTypes::SurrenderRequestCancelled;
            $surrender->save();

            //Add surrender order status history
            $this->addSurrenderHistory($id, StatusTypes::SurrenderRequestCancelled);

            foreach ($surrender->surrenderDets as $key => $surrenderdet) {
                //Reduce customer stock 
                $cus_stock = CustomerStock::where('address_id', $surrender->address_id)
                    ->where('product_id', $surrenderdet->product_id)->first();
                if ($cus_stock) {
                    $cus_stock->empty_qty += $surrenderdet->qty;
                    $cus_stock->save();
                }

                CustomerStockHistory::create([
                    'user_id' => Auth::user()->id,
                    'product_type_id' => $surrenderdet->products->productType->id,
                    'brand_id' => $surrenderdet->products->brand->id,
                    'category_id' => $surrenderdet->products->category->id,
                    'product_id' => $surrenderdet->product_id,
                    'outward_return_qty' => $surrenderdet->qty
                ]);
            }
            DB::commit();

            // Send notification
            $this->sendSurrenderNotification($id, StatusTypes::SurrenderRequestCancelled);
            $response = array(
                'message' => "Updated Successfully",
                'data' => [],
                'status' => true,
            );
            return response($response, 200);
        } catch (\Exception $e) {

            DB::rollback(); // Roll back the transaction if an error occurs
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }

    public function getSurrenderTrackingStatus(Request $request)
    {
        try {

            $status_ids = explode(',', $request->status_ids);
            $status = Status::whereIn('id', $status_ids)->get();

            $response = [
                'status' => true,
                'data' => $status
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
}