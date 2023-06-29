<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Models\DeliveryPerson;
use App\Models\Hub;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\User;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HubOrdersController extends Controller
{
  use Common;
  public function hubOrders()
  {
    $states = $this->getStates();
    return view('admin.order_management.hub_orders.hub_orders', compact('states'));
  }

  public function getHubs(Request $request)
  {
    try {
      $hubs = Hub::where('city_id', $request->city_id)->where('is_active', 1)->get();
      return response()->json([
        'hubs' => $hubs
      ]);
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function hubOrderData(Request $request)
  {
    try {

      $hubOrder = "";

      $query = Hub::select('hubs.*', 'states.state_name', 'cities.city_name')
        ->join('states', 'states.id', 'hubs.state_id')
        ->join('cities', 'cities.id', 'hubs.city_id')
        ->where('hubs.is_active', 1);

      if ($request->state_id > 0) {
        $query = $query->where('state_id', $request->state_id);
      }
      if ($request->city_id > 0) {
        $query = $query->where('city_id', $request->city_id);
      }
      if ($request->hub_id > 0) {
        $query = $query->where('id', $request->hub_id);
      }

      $hubOrder = $query->get();
      return datatables()->of($hubOrder)
        ->addColumn('action', function ($row) {
          $html = '<a href="/huborderlist/' . $row->id . '" class="btn btn-xs btn-primary">View</a>';
          return $html;
        })
        ->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function hubOrderList($id = null)
  {
    try {
      if (Auth::user()->role_id == RoleTypes::Hub) {
        $hub_id = $this->getRefId(Auth::user()->id, RoleTypes::Hub);
      }
      $id = ($id ? $id : $hub_id);
      $hubOrderDetail = Hub::where('id', $id)->where('is_active', 1)->first();

      //Assigned Delivery Persons
      $assigned_delivery_persons = OrderDelivery::where('is_notdelivered', 0)->whereNull('delivered_on')->pluck('delivery_user_id')->toArray();

      //List Delivery Persons to Assign Orders
      $deliveryPerson = DeliveryPerson::select('delivery_people.*')
        ->join('users', 'users.ref_id', 'delivery_people.id')
        ->where('delivery_people.hub_id', $id)
        ->where('delivery_people.is_active', 1)
        ->where('delivery_people.is_online', 1)
        ->where('users.role_id', RoleTypes::DeliveryPerson)
        ->whereNull('delivery_people.deleted_at')
        ->whereNotIn('users.id', $assigned_delivery_persons)
        ->groupBy('delivery_people.id')
        ->get();

      return view('admin.order_management.hub_orders.huborder_detail', compact('hubOrderDetail', 'deliveryPerson'));
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function hubOrderDetail(Request $request)
  {
    try {
      $hubAllOrder = "";

      $query = $this->getAllOrders("Hub", 0, $request->hub_id);

      $hubAllOrder = $query->get();
      return datatables()->of($hubAllOrder)
        ->addColumn('action', function ($row) {
          $html = "";
          if ($row->status_id == StatusTypes::OrderPlaced || $row->status_id == StatusTypes::AssignedToDelivery || $row->status_id == StatusTypes::OrderNotDelivered && Auth::user()->role_id == RoleTypes::Hub) {
            $html = (Auth::user()->role_id == RoleTypes::Hub
              ? '<button type="button" class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#deliveryPersonPopup" onclick="assignOrder(' . $row['id'] . ')">Assign</button>'
              : '<a href="/orderdetail/' . $row['id'] . '" class="btn btn-xs btn-primary">View</a>');
          } elseif (Auth::user()->role_id != RoleTypes::Hub) {
            $html = '<a href="/orderdetail/' . $row['id'] . '" class="btn btn-xs btn-primary">View</a>';
          }
          return $html;
        })
        ->toJson();
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }


  public function assignDeliveryPerson(Request $request)
  {
    $request->validate([
      'ddlDeliveryPerson' => 'required'
    ]);
    DB::beginTransaction();
    try {
      $delivery_user_id = $this->getUserId($request->ddlDeliveryPerson, RoleTypes::DeliveryPerson);
      OrderDelivery::create([
        'order_id' => $request->hdOrderId,
        'delivery_user_id' => $delivery_user_id
      ]);

      $this->saveOrderStatus($request->hdOrderId, StatusTypes::AssignedToDelivery);

      $this->addOrderStatusHistory($request->hdOrderId, StatusTypes::AssignedToDelivery);
      DB::commit();
      $this->sendDPNotification($request->hdOrderId, StatusTypes::AssignedToDelivery, $delivery_user_id);

      $notification = array(
        'message' => 'Delivery Person Assigned Successfully!',
        'alert-type' => 'success'
      );
      return redirect()->back()->with($notification);
    } catch (\Exception $e) {
      DB::rollback();
      $notification = array(
        'message' => 'Something Went Wrong!',
        'alert-type' => 'error'
      );
      $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
      return redirect()->back()->with($notification);
    }
  }
}