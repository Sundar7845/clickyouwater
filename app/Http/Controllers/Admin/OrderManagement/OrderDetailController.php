<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\AdminSettings;
use App\Models\CustomerAddress;
use App\Models\CustomerType;
use App\Models\Order;
use App\Models\OrderDet;
use Illuminate\Http\Request;
use App\Traits\Common;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderDetailController extends Controller
{
    use Common;
    public function orderDetail($id)
    {
        try {
            $order = Order::find($id);
            $customeraddress = $this->getOrderDetail($id);
            $company_address = AdminSettings::first();
            $orderdetails = Order::select('products.*', 'order_dets.*')
                ->join('order_dets', 'order_dets.order_id', 'orders.id')
                ->join('products', 'products.id', 'order_dets.product_id')
                ->where('orders.id', $id)->get();
            return view('admin.order_management.order_detail.orders_view', compact('customeraddress', 'company_address', 'orderdetails', 'order'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
