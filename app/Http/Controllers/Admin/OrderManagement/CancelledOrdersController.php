<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Common;
use Illuminate\Support\Facades\Auth;


class CancelledOrdersController extends Controller
{
  use Common;
  public function cancelledOrders(Request $request)
  {
    try {
      $state = $this->getStates();
      $order = $this->getAllOrders()->get();
      //To load list based type(All,Today,ThisMonth)
      $type = $request->input('type');
      return view('admin.order_management.cancelled_orders',compact('state','order','type'));

    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function cancelledOrdersData(Request $request)
  {
    try {
      $cancelledOrders = "";
      $query = $this->getCancelledOrders()
        ->whereRaw("DATE(orders.transaction_date) BETWEEN '{$request->startdate}' AND '{$request->enddate}'");

      if ($request->state_id > 0) {
        $query = $query->where('customer_addresses.state_id', $request->state_id);
      }
      if ($request->city_id > 0) {
        $query = $query->where('customer_addresses.city_id', $request->city_id);
      }
      if ($request->hub_id > 0) {
        $query = $query->where('hubs.id', $request->hub_id);
      }

      $cancelledOrders = $query->get();
      return datatables()->of($cancelledOrders)
        ->addColumn('action', function ($row) {
          $html = '<a href="/orderdetail/' . $row->id . '" class="btn btn-xs btn-primary">View</a>';
          return $html;
        })
        ->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function cancelledOrdersView()
  {
    try {

    return view('admin.order_management.cancelled_orders.cancelorder_view');

    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }
}
