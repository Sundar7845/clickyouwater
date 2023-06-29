<?php

namespace App\Http\Controllers\Admin\CustomerManagement;

use App\Http\Controllers\Controller;
use App\Models\Surrender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Common;
use App\Enums\MenuPermissionType;
use App\Enums\StatusTypes;
use App\Enums\WalletTransactionTypes;
use App\Models\CustomerStock;
use App\Models\CustomerStockHistory;
use App\Models\State;
use App\Models\Status;
use App\Models\SurrenderDet;
use App\Models\User;
use App\Models\UserDepositRefundHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SurrenderCanController extends Controller
{
    use common;
    public function SurrenderRequests()
    {
        try {
            $state = $this->getStates();
            return view('admin.customer_management.surrender_requests', compact('state'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getSurrenderRequests(Request $request)
    {
        try {
            $surrenderdata = "";
            $query = Surrender::select('surrenders.*', 'users.user_name', 'hubs.hub_name', 'reasons.reason', 'statuses.status', 'statuses.status_color_css', 'users.id as user_id')
                ->selectRaw('SUM(surrender_dets.qty) as total_qty')
                ->join('users', 'users.id', 'surrenders.user_id')
                ->join('hubs', 'hubs.id', 'surrenders.hub_id')
                ->join('reasons', 'reasons.id', 'surrenders.reason_id')
                ->join('statuses', 'statuses.id', 'surrenders.status_id')
                ->join('surrender_dets', 'surrender_dets.surrender_id', 'surrenders.id')
                ->groupBy('surrenders.id', 'users.user_name', 'hubs.hub_name', 'reasons.reason', 'statuses.status', 'statuses.status_color_css')
                ->orderBy('surrenders.id', 'DESC');

            if ($request->state_id > 0) {
                $query = $query->where('hubs.state_id', $request->state_id);
            }
            if ($request->city_id > 0) {
                $query = $query->where('hubs.city_id', $request->city_id);
            }
            if ($request->hub_id > 0) {
                $query = $query->where('surrenders.hub_id', $request->hub_id);
            }

            $surrenderdata = $query->get();

            return datatables()->of($surrenderdata)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($row->status_id == StatusTypes::SurrenderCanCollected && $row->refund_to == 'bank') {
                        $html .= '<button onclick = processRefund(' . $row->id . '); id="btnRefund" class="btn btn-xs btn-' . ($row->is_refund_processed == 0 ? 'warning' : 'success') . ' my-1">Refund Processed</button>';
                    }
                    if ($row->status_id == StatusTypes::SurrenderRequested) {
                        $html .= '<button onclick = doApprove(' . $row->id . '); id="btnapprove" class="btn btn-xs btn-success my-1">Approve</button>';
                        $html .= '<button type="button" class="btn btn-xs btn-danger my-1" data-bs-toggle="modal" data-bs-target="#surrender_request_popup" onclick="rejectrequest(' . $row['id'] . ')">Reject</button>';
                    }
                    $html .= '<a href="/surrenderdetails/' . $row->id . '" class="btn btn-xs btn-primary">View</a>';
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getSurrenderBankInfo($id)
    {
        $user_bank_info = User::where('id', $id)->first();

        return response()->json([
            'bankInfo' => $user_bank_info
        ]);
    }
    public function SurrenderRequestDetails($id)
    {
        try {
            $customeraddress = Surrender::select(
                'surrenders.*',
                'users.user_name',
                'customer_addresses.*',
                'states.state_name',
                'cities.city_name',
                DB::raw("DATE_FORMAT(surrenders.created_at, '%d/%m/%Y %H:%i:%s %p') as surrender_date"),
                'reasons.reason',
                'statuses.status',
                'statuses.status_color_css'
            )
                ->join('users', 'users.id', 'surrenders.user_id')
                ->join('customer_addresses', 'customer_addresses.id', 'surrenders.address_id')
                ->join('states', 'states.id', 'customer_addresses.state_id')
                ->join('cities', 'cities.id', 'customer_addresses.city_id')
                ->join('statuses', 'statuses.id', 'surrenders.status_id')
                ->join('reasons', 'reasons.id', 'surrenders.reason_id')
                ->where('surrenders.id', $id)
                ->first();
            $surrenderdetails = Surrender::select('surrender_dets.*', 'surrenders.*', 'products.*')
                ->join('surrender_dets', 'surrender_dets.surrender_id', 'surrenders.id')
                ->join('products', 'products.id', 'surrender_dets.product_id')
                ->where('surrenders.id', $id)
                ->get();
            return view('admin.customer_management.surrender_request_details', compact('customeraddress', 'surrenderdetails'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function SurrenderRequestApprove($id)
    {
        DB::beginTransaction();
        try {
            $surrender = Surrender::find($id);
            if ($surrender->status_id == StatusTypes::SurrenderRequested) {
                $surrender->status_id = StatusTypes::SurrenderApproved;
                $surrender->save();
                
                DB::commit();

                // Send notification
                $this->sendSurrenderNotification($id, StatusTypes::SurrenderApproved, $surrender->user_id);
                $this->sendHubNotification($id, StatusTypes::SurrenderApproved, $surrender->hub_id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'This surrender request approved successfully!.',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This surrender request maybe cancelled by customer',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function SurrenderRequestReject(Request $request)
    {
        DB::beginTransaction();
        try {
            $reject =  Surrender::findorFail($request->hdrejectId)->update([
                'status_id' => StatusTypes::SurrenderRejected,
                'reject_reason_note' => $request->txtreason
            ]);

            $surrender = Surrender::where('id', $request->hdrejectId)->first();
            $surrenderDet = SurrenderDet::where('surrender_id', $request->hdrejectId)->get();

            foreach ($surrenderDet as $key => $surrenderdet) {
                //Reduce customer stock 
                $cus_stock = CustomerStock::where('address_id', $surrender->address_id)
                    ->where('product_id', $surrenderdet->product_id)->first();
                if ($cus_stock) {
                    $cus_stock->empty_qty += $surrenderdet->qty;
                    $cus_stock->save();
                }

                CustomerStockHistory::create([
                    'user_id' => $surrender->user_id,
                    'product_type_id' => $surrenderdet->products->productType->id,
                    'brand_id' => $surrenderdet->products->brand->id,
                    'category_id' => $surrenderdet->products->category->id,
                    'product_id' => $surrenderdet->product_id,
                    'outward_return_qty' => $surrenderdet->qty
                ]);
            }

            DB::commit();
            // Send notification
            $this->sendSurrenderNotification($request->hdrejectId, StatusTypes::SurrenderRejected, $surrender->user_id);

            $notification = array(
                'message' => 'Rejected Successfully',
                'alert' => 'success'
            );
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = array(
                'message' => 'Not Rejected',
                'alert' => 'error'
            );
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //Process Refund
    public function processRefund($id)
    {
        DB::beginTransaction();
        try {
            $surrender = Surrender::find($id);
            if ($surrender->is_refund_processed == 0) {
                $surrenderDet = SurrenderDet::where('surrender_id', $id)->get();
                if ($surrenderDet) {
                    foreach ($surrenderDet as $key => $surrenderdet) {
                        if (strtolower($surrender->refund_to) == 'bank') {
                            UserDepositRefundHistory::create([
                                'user_id' => $surrender->user_id,
                                'product_id' => $surrenderdet->product_id,
                                'delivery_address_id' => $surrender->address_id,
                                'qty' => $surrenderdet->qty,
                                'deposit_amount' => $surrenderdet->deposit_amount,
                                'refund_to' => 'bank',
                                'refund_amount' => ($surrenderdet->qty * $surrenderdet->deposit_amount),
                                'refund_date' => Carbon::now()
                            ]);
                        }
                        Surrender::where('id', $id)->update([
                            'is_refund_processed' => 1
                        ]);
                    }
                    DB::commit();
                    return response()->json([
                        'status' => 'success',
                        'message' => 'This refund has successfully processed.',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This refund is alreay processed.',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
