<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrdersController extends Controller
{
  use Common;
  public function customerOrders(Request $request)
  {
    try {

      $state = $this->getStates();
      $order = $this->getAllOrders()->get();
      //To load list based type(All,Today,ThisMonth)
      $type = $request->input('type');
      return view('admin.order_management.customer_orders', compact('type', 'order', 'state'));
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function customerOrderData(Request $request)
  {
    try {

      $customerOrder = "";
      $query = $this->getAllOrders()
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

      // Apply type filters based on the 'type' parameter
      if ($request->type === 'today') {
        $query->whereDate('orders.transaction_date', today());
      } elseif ($request->type === 'thismonth') {
        $query->whereMonth('orders.transaction_date', now()->month);
      } elseif ($request->type === 'all') {
        $query = $this->getAllOrders()
          ->whereRaw("DATE(orders.transaction_date) BETWEEN '{$request->startdate}' AND '{$request->enddate}'");
      }

      // Apply type filters based on the 'Eaarnings' parameter
      if ($request->type === 'todayearnings') {
        $query->whereDate('orders.transaction_date', today())->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::OrderShipped, StatusTypes::OrderDelivered]);
      } elseif ($request->type === 'thismonthearnings') {
        $query->whereMonth('orders.transaction_date', now()->month)->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::OrderShipped, StatusTypes::OrderDelivered]);
      } elseif ($request->type === 'totalearnings') {
        $query = $this->getAllOrders()->whereIn('status_id', [StatusTypes::OrderPlaced, StatusTypes::OrderShipped, StatusTypes::OrderDelivered]);
      }

      $customerOrder = $query->get();
      return datatables()->of($customerOrder)
        ->addColumn('action', function ($row) {
          $html = '<a href="/orderdetail/' . $row->id . '" class="btn btn-xs btn-primary">View</a>';
          return $html;
        })
        ->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function getHubByCity(Request $request)
  {
    try {
      $hub_name = "";
      $query = Hub::where('is_active', 1)
        ->whereNull('deleted_at')
        ->orderBy('hub_name', 'asc')
        ->select('hub_name', 'id', 'is_active');
      if ($request->state_id > 0) {
        $query = $query->where('hubs.state_id', $request->state_id);
      }
      if ($request->city_id > 0) {
        $query = $query->where('hubs.city_id', $request->city_id);
      }
      $hub_name = $query->get();

      return response()->json([
        'hub_name' => $hub_name
      ]);
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }
}
