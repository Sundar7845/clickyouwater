<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendingOrdersController extends Controller
{
  use Common;
  public function pendingOrders(Request $request)
  {
    $state = $this->getStates();
    $order = $this->getAllOrders()->get();
    //To load list based type(All,Today,ThisMonth)
    $type = $request->input('type');
    return view('admin.order_management.pending_orders', compact('state','order','type'));
  }

  public function pendingOrdersData(Request $request)
  {
    try {
      $pendingOrders = "";
      $query = $this->getPendingOrders()
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

      $pendingOrders = $query->get();
      return datatables()->of($pendingOrders)
        ->addColumn('action', function ($row) {
          $html = '<a href="/orderdetail/' . $row->id . '" class="btn btn-xs btn-primary">View</a>';
          return $html;
        })
        ->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function pendingOrdersView()
  {
    return view('admin.order_management.pending_orders.pending_orders_view');
  }
}
