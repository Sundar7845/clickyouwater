<?php

namespace App\Http\Controllers\Admin\CustomerManagement;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Enums\MenuPermissionType;
use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Enums\WalletTransactionTypes;
use App\Models\CustomerAddress;
use App\Models\CustomerNearestHub;
use App\Models\CustomerStock;
use App\Models\CustomerType;
use App\Models\Hub;
use App\Models\HubStock;
use App\Models\HubStockHistory;
use App\Models\Order;
use App\Models\Products;
use App\Models\User;
use App\Models\UserDepositHistory;
use App\Models\UserDepositRefundHistory;
use App\Models\UserFeedback;
use App\Models\UserReferralHistory;
use App\Models\UserWallet;
use App\Models\WalletTransactionType;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    use Common;
    public function customers(Request $request)
    {
        try {
            $customer_types = CustomerType::get();
            $states = $this->getStates();
            // $hubs = Hub::where('is_active', 1)->get();
            $type = $request->input('type');
            return view('admin.customer_management.customers', compact('type', 'customer_types', 'states'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }


    public function customersData(Request $request)
    {
        try {
            $query = Customer::join('users', 'users.ref_id', 'customers.id')
                ->join('customer_types', 'customer_types.id', 'customers.customertype_id')
                ->join('customer_addresses', 'customer_addresses.customer_id', 'customers.id')
                // ->leftJoin('customer_nearest_hubs', 'customer_nearest_hubs.customer_address_id', 'customer_addresses.id')
                ->select('users.*', 'customers.*', 'customer_types.*', 'customers.email', 'customer_addresses.*', 'customers.id', DB::raw("DATE_FORMAT(customers.created_at, '%d/%m/%Y') as formatted_reg_date"))
                ->where('users.role_id', RoleTypes::Customer)
                ->where('customer_addresses.is_default', 1);

            if ($request->customer_type_id > 0) {
                $query = $query->where('customers.customertype_id', $request->customer_type_id);
            } else {
                $query = $query->where('customers.customertype_id', 1);
            }

            if ($request->status_id != null) {
                $query = $query->where('users.is_active', $request->status_id);
            } else {
                $query = $query->where('users.is_active', 1);
            }

            if ($request->state_id > 0) {
                $query = $query->where('customer_addresses.state_id', $request->state_id);
            }

            if ($request->district_id > 0) {
                $query = $query->where('customer_addresses.city_id', $request->district_id);
            }

            // if ($request->hub_id > 0) {
            //     $query = $query->where('customer_nearest_hubs.hub_id', $request->hub_id);
            // }

            // Apply type filters based on the 'type' parameter
            if ($request->type === 'today') {
                $query = $query->whereDate('customers.created_at', today());
            } elseif ($request->type === 'thismonth') {
                $query = $query->whereMonth('customers.created_at', now()->month);
            }

            $customerData = $query->get();

            return datatables()->of($customerData)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            return $this->error($e->getMessage(), 200);
        }
    }

    public function customersPerformance()
    {
        try {
            return view('admin.customer_management.customer_performance');
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function customersSummary($id)
    {
        try {
            $userid = $id;
            $customers_details = Customer::select('customer_types.*', 'customers.*')
                ->join('customer_types', 'customer_types.id', 'customers.customertype_id')
                ->where('customers.id', $id)
                ->first();

            $customer_address = CustomerAddress::select('customers.*', 'customer_addresses.*', 'cities.city_name', 'states.state_name')
                ->join('customers', 'customers.id', 'customer_addresses.customer_id')
                ->join('cities', 'cities.id', 'customer_addresses.city_id')
                ->join('states', 'states.id', 'customer_addresses.state_id')
                ->where('customers.id', $id)
                ->get();

            $ordersCount = Order::join('users', 'users.id', 'orders.user_id')
                ->join('customers', 'users.ref_id', 'customers.id')
                ->where('users.ref_id', $id)
                ->count('orders.user_id');

            $orderValue = Order::join('users', 'users.id', 'orders.user_id')
                ->join('customers', 'users.ref_id', 'customers.id')
                ->where('users.ref_id', $id)
                ->whereIn('orders.status_id', [StatusTypes::OrderPlaced, StatusTypes::OrderShipped, StatusTypes::AssignedToDelivery, StatusTypes::OrderDelivered])
                ->sum('orders.grand_total');

            $rechargePoints = WalletTransactionType::join('user_wallets', 'user_wallets.wallet_transaction_type_id', 'wallet_transaction_types.id')
                ->join('users', 'users.id', 'user_wallets.user_id')
                ->join('customers', 'users.ref_id', 'customers.id')
                ->where('users.ref_id', $id)
                ->where('wallet_transaction_types.id', WalletTransactionTypes::WalletSuccess)
                ->sum('user_wallets.amount');

            //Not Used / Referred
            $usedPoints = WalletTransactionType::join('user_wallets', 'user_wallets.wallet_transaction_type_id', 'wallet_transaction_types.id')
                ->join('users', 'users.id', 'user_wallets.user_id')
                ->join('customers', 'users.ref_id', 'customers.id')
                ->where('users.ref_id', $id)
                ->where('wallet_transaction_types.id', WalletTransactionTypes::Used)
                ->sum('user_wallets.amount');

            $earnedPoints = WalletTransactionType::join('user_wallets', 'user_wallets.wallet_transaction_type_id', 'wallet_transaction_types.id')
                ->join('users', 'users.id', 'user_wallets.user_id')
                ->join('customers', 'users.ref_id', 'customers.id')
                ->where('users.ref_id', $id)
                ->whereIn('wallet_transaction_types.id', [WalletTransactionTypes::Referral, WalletTransactionTypes::Offers])
                ->sum('user_wallets.amount');

            $cancelOrder = Order::join('users', 'users.id', 'orders.user_id')
                ->join('customers', 'users.ref_id', 'customers.id')
                ->where('users.ref_id', $id)
                ->where('orders.status_id', StatusTypes::Cancelled)
                ->count('orders.user_id');

            $balancepoints = User::join('customers', 'customers.id', 'users.ref_id')
                ->where('customers.id', $id)
                ->where('users.ref_id', $id)
                ->value('wallet_points');

            $user_id = $this->getUserId($id, RoleTypes::Customer);
            $total_deposit_amount = UserDepositHistory::select(DB::raw('sum(qty * deposit_amount) as total_deposit_amount'))
                ->where('user_id', $user_id)->value('total_deposit_amount');
            $total_refund_amount = UserDepositRefundHistory::select(DB::raw('sum(refund_amount) as total_refund_amount'))
                ->where('user_id', $user_id)->value('total_refund_amount');

            $refundableDeposit = ($total_deposit_amount - $total_refund_amount);

            $cansInHand = CustomerStock::where('user_id', $this->getUserId($id, RoleTypes::Customer))->sum('empty_qty');

            $damagedCans = CustomerStock::where('user_id', $this->getUserId($id, RoleTypes::Customer))->sum('damaged_qty');

            return view('admin.customer_management.summary', compact('customers_details', 'ordersCount', 'rechargePoints', 'earnedPoints', 'cancelOrder', 'balancepoints', 'usedPoints', 'userid', 'customer_address', 'cansInHand', 'orderValue', 'refundableDeposit', 'total_deposit_amount', 'total_refund_amount', 'damagedCans'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function depositHistoryData(Request $request)
    {
        try {
            $cus_id = $request->customer_id;

            $query = UserDepositHistory::select('user_deposit_histories.id', 'user_deposit_histories.qty', 'user_deposit_histories.deposit_amount', 'user_deposit_histories.created_at', 'products.product_name')
                ->join('users', 'users.id', 'user_deposit_histories.user_id')
                ->join('customers', 'customers.id', 'users.ref_id')
                ->where('users.ref_id', $cus_id)
                ->where('customers.id', $cus_id)
                ->join('products', 'products.id', 'user_deposit_histories.product_id');

            $userDepositHisoryData = $query->get();

            return datatables()->of($userDepositHisoryData)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function depostiHistory($id)
    {
        try {
            $customer_id = $id;
            $customer_name = Customer::where('id', $customer_id)->pluck('customer_name')->first();
            $refundInfo = UserDepositHistory::select('user_deposit_histories.*', 'products.product_name')
                ->join('users', 'users.id', 'user_deposit_histories.user_id')
                ->join('customers', 'customers.id', 'users.ref_id')
                ->where('users.ref_id', $customer_id)
                ->where('customers.id', $customer_id)
                ->join('products', 'products.id', 'user_deposit_histories.product_id')
                ->get();
            return view('admin.customer_management.deposit_history', compact('customer_id', 'refundInfo', 'customer_name'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getRefundDetails($id)
    {
        try {
            $user_id = $this->getUserId($id, RoleTypes::Customer);
            $getRefundDetails = UserDepositRefundHistory::select('user_deposit_refund_histories.*', 'products.product_name')
                ->join('products', 'products.id', 'user_deposit_refund_histories.product_id')
                ->join('users', 'users.id', 'user_deposit_refund_histories.user_id')
                ->join('customers', 'customers.id', 'users.ref_id')
                ->where('users.ref_id', $id)
                ->where('customers.id', $id)->where('user_deposit_refund_histories.user_id', $user_id)->get();

            return datatables()->of($getRefundDetails)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function activeStatus($id, $status)
    {
        try {
            User::join('customers', 'customers.id', 'users.ref_id')
                ->where('customers.id', $id)
                ->where('users.ref_id', $id)
                ->update([
                    'users.is_active' => $status,
                    'users.updated_by' => Auth::user()->id
                ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    //common function need
    public function getRecentOrdersdata(Request $request)
    {
        try {
            $cus_id = $request->customer_id;
            $totalorders = $this->getAllOrders('Customer', $cus_id)->get();
            return datatables()->of($totalorders)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function customerFeedback()
    {
        try {
            return view('admin.customer_management.customer_feedback');
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function customerFeedbackData()
    {
        try {
            $customerfeedback = UserFeedback::select('user_feedback.*', 'users.user_name')
                ->join('users', 'users.id', 'user_feedback.user_id')
                ->orderBy('user_feedback.created_at', 'desc')
                ->get();
            return datatables()->of($customerfeedback)->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function customerOutstandingList(Request $request)
    {
        try {
            $states = $this->getStates();
            return view('admin.customer_management.customers_outstanding', compact('states'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function outstandingData(Request $request)
    {
        try {
            $query = User::select('users.*', 'customer_stocks.extra_qty', 'customers.customer_name', 'products.product_name', 'customer_addresses.building_no', 'customer_addresses.street', 'customer_addresses.area', 'products.id as product_id', 'customer_stocks.address_id as customer_address_id', DB::raw("(product_types.newcan_deposit_amt * customer_stocks.extra_qty) as outstanding_amount"))
                ->join('customer_stocks', 'customer_stocks.user_id', 'users.id')
                ->join('products', 'products.id', 'customer_stocks.product_id')
                ->join('product_types', 'product_types.id', 'products.product_type_id')
                ->join('customers', 'customers.id', 'users.ref_id')
                ->join('customer_addresses', 'customer_addresses.id', 'customer_stocks.address_id')
                ->leftJoin('customer_nearest_hubs', 'customer_nearest_hubs.customer_address_id', 'customer_addresses.id')
                ->where('users.role_id', RoleTypes::Customer)
                ->where('users.closing_balance', '>', 0)
                ->where('customer_stocks.extra_qty', '>', 0);
            // ->where('customer_addresses.is_default', 1);


            if ($request->state_id > 0) {
                $query = $query->where('customer_addresses.state_id', $request->state_id);
            }

            if ($request->district_id > 0) {
                $query = $query->where('customer_addresses.city_id', $request->district_id);
            }

            if ($request->hub_id > 0) {
                $query = $query->where('customer_nearest_hubs.hub_id', $request->hub_id);
            }

            $outstandingData = $query->get();

            return datatables()->of($outstandingData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Approval)) {
                        $html .= '<button onclick="doSettled(' . $row->id . ', ' . $row->product_id . ',' . $row->extra_qty . ',' . $row->outstanding_amount . ',' . $row->customer_address_id . ');" id="btnSettled" class="btn btn-xs btn-success my-2">Amount Received</button>';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Approval)) {
                        $html .= '<button onclick ="doCollected(' . $row->id . ', ' . $row->product_id . ',' . $row->extra_qty . ',' . $row->outstanding_amount . ',' . $row->customer_address_id . ');" id="btnCollected" class="btn btn-xs btn-warning my-2">Can Collected</button>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            return $this->error($e->getMessage(), 200);
        }
    }

    public function doSettledOutstanding(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = User::where('id', $request->user_id)->first();
            $user->closing_balance -= $request->outstanding_amount;
            $user->save();

            $customerStock = CustomerStock::where('user_id', $request->user_id)
                ->where('address_id', $request->customer_address_id)
                ->where('product_id', $request->product_id)->first();

            $customerStock->empty_qty += $request->extra_qty;
            $customerStock->extra_qty -= $request->extra_qty;
            $customerStock->save();

            UserDepositHistory::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'delivery_address_id' => $request->customer_address_id,
                'qty' => $request->extra_qty,
                'deposit_amount' => $this->getCanDepositFromHistory($request->customer_address_id, $request->product_id, $request->user_id),
            ]);

            DB::commit();
            if ($user && $customerStock) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Settlement is success!',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to settle Outstanding amount.',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function doCollectedOutstanding(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $request->user_id)->first();
            $user->closing_balance -= $request->outstanding_amount;
            $user->save();

            $customerStock = CustomerStock::where('user_id', $request->user_id)
                ->where('address_id', $request->customer_address_id)
                ->where('product_id', $request->product_id)->first();

            $customerStock->extra_qty -= $request->extra_qty;
            $customerStock->save();

            $hub_id = CustomerNearestHub::where('customer_address_id', $request->customer_address_id)->pluck('hub_id')->first();
            HubStock::where('product_id', $request->product_id)->where('hub_id', $hub_id)->update([
                'empty_qty' => DB::raw('empty_qty +' . $request->extra_qty)
            ]);

            $product = Products::where('id', $request->product_id)->first();

            HubStockHistory::create([
                'hub_id' => $hub_id,
                'product_type_id' => $product->productType->id,
                'brand_id' => $product->brand->id,
                'category_id' => $product->category->id,
                'product_id' => $request->product_id,
                'inward_from_delivery_qty' => $request->extra_qty
            ]);

            DB::commit();
            if ($user && $customerStock) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Outstanding amount collected successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to collected Outstanding amount.',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
