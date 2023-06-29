<?php

namespace App\Http\Controllers\API\Delivery;

use App\Enums\StatusTypes;
use App\Enums\WalletTransactionTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\DPPickupOrderResource;
use App\Models\DeliveryPersonStock;
use App\Models\DeliveryPersonStockHistory;
use App\Models\HubStock;
use App\Models\HubStockHistory;
use App\Models\Surrender;
use App\Models\SurrenderDet;
use App\Models\UserDepositRefundHistory;
use App\Traits\Common;
use App\Traits\ResponseAPI;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DPSurrenderOrdersController extends Controller
{
    //
    use ResponseAPI;
    use Common;
    public function getDPPickupOrders(Request $request)
    {
        try {

            $user_id = ($request->user_id ? $request->user_id : Auth::user()->id);
            // dd($user_id);
            $surrenders = Surrender::join('surrender_pickups', 'surrender_pickups.surrender_id', 'surrenders.id')
                ->where('surrender_pickups.delivery_user_id', $user_id)
                ->whereIn('status_id', [StatusTypes::SurrenderApproved, StatusTypes::AssignedForPickup])
                ->select('surrenders.*');

            // dd($surrenders->get());

            $surrenders = $surrenders->paginate($this->recordsperpage);

            $response = array(
                'message' => "Success",
                'data' => DPPickupOrderResource::collection($surrenders),
                'pagination' => [
                    'total' => $surrenders->total(),
                    'per_page' => $surrenders->perPage(),
                    'current_page' => $surrenders->currentPage(),
                    'last_page' => $surrenders->lastPage(),
                    'next_page_url' => $surrenders->nextPageUrl(),
                    'prev_page_url' => $surrenders->previousPageUrl(),
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

    public function getDPPickupOrderDetails($id)
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
                    'pickup_address' => $surrenderdetail->pickup_address,
                    'created_at' => DateTime::createFromFormat('Y-m-d H:i:s', $surrenderdetail->created_at)->format('d M,y'),
                    'surrender_details' => $surrenderdetail->surrenderDets->map(function ($surrenderdet) {
                        if ($surrenderdet->products) {
                            return [
                                'product_id' => $surrenderdet->product_id,
                                'product_name' => $surrenderdet->products->product_name,
                                'quantity' => $surrenderdet->qty
                            ];
                        }
                        return null; // Return null or handle the case when 'products' is null
                    })->filter()
                        ->values(),
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

    public function confirmPickup(Request $request)
    {
        DB::beginTransaction();
        try {

            $surrender = Surrender::find($request->surrender_id);
            $surrender->status_id = StatusTypes::SurrenderCanCollected;
            $surrender->save();

            $surrenderDet = SurrenderDet::where('surrender_id', $request->surrender_id)->get();
            if ($surrenderDet) {
                foreach ($surrenderDet as $key => $surrenderdet) {
                    SurrenderDet::where('surrender_id', $request->surrender_id)
                        ->where('product_id', $surrenderdet->product_id)->update([
                            'collected_can_qty' => $surrenderdet->qty
                        ]);

                    if (strtolower($surrender->refund_to) == 'wallet') {
                        UserDepositRefundHistory::create([
                            'user_id' => $surrender->user_id,
                            'product_id' => $surrenderdet->product_id,
                            'delivery_address_id' => $surrender->address_id,
                            'qty' => $surrenderdet->qty,
                            'deposit_amount' => $surrenderdet->deposit_amount,
                            'refund_to' => 'wallet',
                            'refund_amount' => ($surrenderdet->qty * $surrenderdet->deposit_amount),
                            'refund_date' => Carbon::now()
                        ]);
                    }
                    //Store Order Data in HubStock
                    HubStock::updateOrCreate([
                        'product_id' => $surrenderdet->product_id,
                        'hub_id' => $surrender->hub_id,
                    ], [
                        'hub_id' => $surrender->hub_id,
                        'product_id' => $surrenderdet->product_id,
                        'empty_qty' => DB::raw('empty_qty + ' . $surrenderdet->qty)
                    ]);

                    HubStockHistory::create([
                        'hub_id' => $surrender->hub_id,
                        'user_id' => Auth::user()->id,
                        'product_type_id' => $surrenderdet->products->productType->id,
                        'brand_id' => $surrenderdet->products->brand->id,
                        'category_id' => $surrenderdet->products->category->id,
                        'product_id' => $surrenderdet->product_id,
                        'inward_from_delivery_qty' => $surrenderdet->qty
                    ]);

                    //Store Order Data in Delivery Person Stock
                    DeliveryPersonStock::updateOrCreate([
                        'product_id' => $surrenderdet->product_id,
                        'hub_id' => $surrender->hub_id,
                        'delivery_user_id' => Auth::user()->id,
                    ], [
                        'hub_id' => $surrender->hub_id,
                        'delivery_user_id' => Auth::user()->id,
                        'product_id' => $surrenderdet->product_id,
                        'collected_empty_qty' => DB::raw('collected_empty_qty + ' . $surrenderdet->qty)
                    ]);

                    DeliveryPersonStockHistory::create([
                        'hub_id' => $surrender->hub_id,
                        'delivery_user_id' => Auth::user()->id,
                        'product_type_id' => $surrenderdet->products->productType->id,
                        'brand_id' => $surrenderdet->products->brand->id,
                        'category_id' => $surrenderdet->products->category->id,
                        'product_id' => $surrenderdet->product_id,
                        'inward_from_customer_qty' => $surrenderdet->qty,
                        'outward_to_hub_qty' => $surrenderdet->qty
                    ]);
                }
            }

            if (strtolower($surrender->refund_to == 'wallet')) {
                $this->addWallet($surrender->user_id, $surrender->refund_amount, WalletTransactionTypes::SurrenderRefund);
            }

            //Add surrender order status history
            $this->addSurrenderHistory($request->surrender_id, StatusTypes::SurrenderCanCollected);

            // Send notification
            $this->sendSurrenderNotification($request->surrender_id, StatusTypes::SurrenderCanCollected, $surrender->user_id, $surrender->refund_to);

            $response = array(
                'message' => "Success",
                'data' => [],
                'status' => true,
            );
            DB::commit();
            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollBack();
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
