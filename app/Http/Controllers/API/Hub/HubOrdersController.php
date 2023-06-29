<?php

namespace App\Http\Controllers\API\Hub;

use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\HubOrderResource;
use App\Models\DeliveryPersonStock;
use App\Models\DeliveryPersonStockHistory;
use App\Models\HubStock;
use App\Models\HubStockHistory;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\Products;
use App\Models\Surrender;
use App\Models\SurrenderHistory;
use App\Models\SurrenderPickup;
use App\Models\UserOrderHistory;
use App\Traits\Common;
use App\Traits\ResponseAPI;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HubOrdersController extends Controller
{
    //
    use ResponseAPI;
    use Common;

    public function getHubOrders(Request $request)
    {
        try {

            $orders = $this->getOrders($request->status_id);
            // dd($orders->get());

            $delivered_count = 0;
            $cancelled_count = 0;
            if (!is_null($request->from_date) && !is_null($request->to_date)) {
                // dd($request->from_date);
                $fromDate = Carbon::createFromFormat('d-m-Y', $request->from_date)->startOfDay();
                $toDate = Carbon::createFromFormat('d-m-Y', $request->to_date)->endOfDay();
                if (!is_null($request->status_id)) {
                    $status_ids = explode(',', $request->status_id);
                    foreach ($status_ids as $key => $status) {
                        if ($status == StatusTypes::Cancelled) {
                            $cancelled_count = $this->getOrders(StatusTypes::Cancelled)
                                ->whereBetween('created_at', [$fromDate, $toDate])->count();
                        } else if ($status == StatusTypes::OrderDelivered) {
                            $delivered_count = $this->getOrders(StatusTypes::OrderDelivered)
                                ->whereBetween('created_at', [$fromDate, $toDate])->count();
                        }
                    }
                }
                $orders = $orders->whereBetween('created_at', [$fromDate, $toDate]);
            }



            $userOrders = $orders->paginate($this->recordsperpage);

            $response = array(
                'message' => "Success",
                'data' => HubOrderResource::collection($userOrders),
                'delivered_count' => $delivered_count,
                'cancelled_count' => $cancelled_count,
                'pagination' => [
                    'total' => $userOrders->total(),
                    'per_page' => $userOrders->perPage(),
                    'current_page' => $userOrders->currentPage(),
                    'last_page' => $userOrders->lastPage(),
                    'next_page_url' => $userOrders->nextPageUrl(),
                    'prev_page_url' => $userOrders->previousPageUrl(),
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
    public function searchHubOrders($order_no)
    {
        try {

            $orders = $this->getOrders(
                implode(
                    ',',
                    [
                        StatusTypes::OrderPlaced,
                        StatusTypes::OrderShipped,
                        StatusTypes::AssignedToDelivery,
                        StatusTypes::OrderDelivered
                    ]
                )
            );

            $orders = $orders->where('order_no', 'LIKE', '%' . $order_no . '%');

            $userOrders = $orders->paginate($this->recordsperpage);

            $response = array(
                'message' => "Success",
                'data' => HubOrderResource::collection($userOrders),
                'pagination' => [
                    'total' => $userOrders->total(),
                    'per_page' => $userOrders->perPage(),
                    'current_page' => $userOrders->currentPage(),
                    'last_page' => $userOrders->lastPage(),
                    'next_page_url' => $userOrders->nextPageUrl(),
                    'prev_page_url' => $userOrders->previousPageUrl(),
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
    public function assignOrder(Request $request)
    {

        $validator = $request->validate([
            'order_id' => 'required',
            'delivery_user_id' => 'required',

        ]);
        DB::beginTransaction();
        try {

            $cancel_order_count = Order::where('id', $request->order_id)
                ->where('status_id', StatusTypes::Cancelled)
                ->where('is_cancel', 1)
                ->count();
            if ($cancel_order_count == 0) {
                $order_delivery = OrderDelivery::where('order_id', $request->order_id)
                    ->where('is_notdelivered', 0)
                    ->whereNull('delivered_on')
                    ->first();
                if ($order_delivery) {
                    $order_delivery->delivery_user_id = $request->delivery_user_id;
                    $order_delivery->save();
                } else {
                    OrderDelivery::create([
                        'order_id' => $request->order_id,
                        'delivery_user_id' => $request->delivery_user_id,
                    ]);
                }

                //Update order status
                $this->saveOrderStatus($request->order_id, StatusTypes::AssignedToDelivery);

                //Add order status history to assigned to delivery
                $this->addOrderStatusHistory($request->order_id, StatusTypes::AssignedToDelivery);
            }
            $response = array(
                'message' => ($cancel_order_count == 0 ? "Success" : "This order is cancelled by customer"),
                'data' => [],
                'status' => ($cancel_order_count == 0 ? true : false),
            );
            DB::commit(); // Commit the transaction

            $this->sendDPNotification($request->order_id, StatusTypes::AssignedToDelivery, $request->delivery_user_id);

            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    public function unassignOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $unassignOrder = OrderDelivery::where('order_id', $request->order_id)
                ->where('delivery_user_id', $request->delivery_user_id)
                ->where('is_notdelivered', 0)
                ->whereNull('delivered_on')
                ->first();
            if ($unassignOrder) {
                $this->unassignOrderDelivery($unassignOrder->id);
            }

            $response = array(
                'message' => "Success",
                'data' => [],
                'status' => true,
            );
            DB::commit(); // Commit the transaction
            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    public function unassignAllOrders($delivery_user_id)
    {

        DB::beginTransaction();
        try {
            $unassignOrder = OrderDelivery::where('delivery_user_id', $delivery_user_id)
                ->where('is_notdelivered', 0)
                ->whereNull('delivered_on')
                ->get();
            foreach ($unassignOrder as $key => $value) {
                $this->unassignOrderDelivery($value->id);
            }
            $response = array(
                'message' => "Success",
                'data' => [],
                'status' => true,
            );
            DB::commit(); // Commit the transaction
            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }

    public function unassignOrderDelivery($order_delivered_id)
    {
        $unassignOrder = OrderDelivery::where('id', $order_delivered_id)->first();
        if ($unassignOrder) {
            $this->addOrderStatusHistory($unassignOrder->order_id, StatusTypes::OrderPlaced);
            $unassignOrder->delete();
        }
        //Update order status
        $this->saveOrderStatus($unassignOrder->order_id, StatusTypes::OrderPlaced);
    }
    public function getHubOrderDetails($order_id)
    {
        try {
            $orderdetails = $this->getOrderDetail($order_id);

            $response = array(
                'message' => "Success",
                'data' => $orderdetails,
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

    public function getOrderStatusHistory($order_id)
    {
        try {
            $status_history = UserOrderHistory::where('order_id', $order_id)->get();
            $order_history = [];
            foreach ($status_history as $key => $status) {
                $order_history[] = [
                    'status_id' => $status->status_id,
                    'status_name' => $status->status->status,
                    'status_msg' => $status->status->status_msg,
                    'date' => DateTime::createFromFormat('Y-m-d H:i:s', $status->updated_at)->format('d M,y, h:i A'),
                ];
            }
            $response = array(
                'message' => "Success",
                'data' => $order_history,
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
    public function assignSurrenderPickup(Request $request)
    {
        $validator = $request->validate([
            'surrender_id' => 'required',
            'delivery_user_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $cancel_surrender_count = Surrender::where('id', $request->surrender_id)
                ->where('status_id', StatusTypes::SurrenderRequestCancelled)
                ->count();
            if ($cancel_surrender_count == 0) {
                $surrender_pickup = SurrenderPickup::where('surrender_id', $request->surrender_id)->first();
                if ($surrender_pickup) {
                    $surrender_pickup->delivery_user_id = $request->delivery_user_id;
                    $surrender_pickup->save();
                } else {
                    SurrenderPickup::create([
                        'surrender_id' => $request->surrender_id,
                        'delivery_user_id' => $request->delivery_user_id,
                    ]);
                }

                //Update surrender order status
                $surrender = Surrender::find($request->surrender_id);
                $surrender->status_id = StatusTypes::AssignedForPickup;
                $surrender->save();

                //Add surrender order status history
                $this->addSurrenderHistory($request->surrender_id, StatusTypes::AssignedForPickup);
            }
            $response = array(
                'message' => ($cancel_surrender_count == 0 ? "Success" : "This surrender is cancelled by customer"),
                'data' => [],
                'status' => ($cancel_surrender_count == 0 ? true : false),
            );
            DB::commit(); // Commit the transaction
            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }

    public function getDPOrdersSummary(Request $request)
    {
        try {

            $orders = $this->getOrders(StatusTypes::OrderShipped, $request->delivery_user_id)->get();
            // dd($orders);
            $watercan_list = [];
            $others_list = [];
            if ($orders) {
                foreach ($orders as $key => $order) {
                    // dd($order->orderDets);
                    foreach ($order->orderDets as $key => $orderdet) {
                        $item = [
                            'product_id' => $orderdet->product_id,
                            'product_name' => $orderdet->products->product_name,
                            'qty' => $orderdet->qty,
                        ];

                        if ($orderdet->products->category->is_watercan) {
                            $watercan_list[] = $item;
                        } else {
                            $others_list[] = $item;
                        }
                    }
                }
            }

            $grouped_watercan_list = collect($watercan_list)->groupBy('product_id');
            $grouped_others_list = collect($others_list)->groupBy('product_id');

            //Water cans list
            $product_watercan_list = $grouped_watercan_list->map(function ($list) {
                $total_qty = $list->sum('qty');
                $firstItem = $list->first();

                return [
                    'product_id' => $firstItem['product_id'],
                    'product_name' => $firstItem['product_name'],
                    'qty' => $total_qty,
                ];
            })->values()->all();

            //Other products list
            $product_others_list = $grouped_others_list->map(function ($list) {
                $total_qty = $list->sum('qty');
                $firstItem = $list->first();

                return [
                    'product_id' => $firstItem['product_id'],
                    'product_name' => $firstItem['product_name'],
                    'qty' => $total_qty,
                ];
            })->values()->all();

            $items_list = [
                'watercans' => $product_watercan_list,
                'otheritems' => $product_others_list
            ];

            $response = array(
                'message' => "Success",
                'data' => $items_list,
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
    public function getDPLostItems(Request $request)
    {
        try {

            $damage_list = [];
            $damage_stocks = DeliveryPersonStock::where('delivery_user_id', $request->delivery_user_id)
                ->where('lost_qty', '>', 0)
                ->get();

            foreach ($damage_stocks as $key => $damage_stock) {
                $product = Products::where('id', $damage_stock->product_id)->first();
                $damage_list[] = [
                    'product_id' => $damage_stock->product_id,
                    'product_name' => $product->product_name,
                    'qty' => $damage_stock->lost_qty,
                ];
            }

            $response = array(
                'message' => "Success",
                'data' => $damage_list,
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

    public function getDPReturnCans(Request $request)
    {
        try {

            $collect_return_list = [];
            $empty_list = [];
            $filled_list = [];
            $extra_list = [];

            //Get empty list
            $stocks = DeliveryPersonStock::where('delivery_user_id', $request->delivery_user_id)
                ->where('return_empty_qty', '>', 0)
                ->get();

            foreach ($stocks as $key => $stock) {
                $product = Products::where('id', $stock->product_id)->first();
                $empty_list[] = [
                    'product_id' => $stock->product_id,
                    'product_name' => $product->product_name,
                    'return_empty_qty' => $stock->return_empty_qty,
                    'collected_empty_qty' => $stock->collected_empty_qty,
                    'return_damaged_qty' => $stock->return_damaged_qty,
                ];
            }

            //Get filled list
            $stocks = DeliveryPersonStock::where('delivery_user_id', $request->delivery_user_id)
                ->where('qty', '>', 0)
                ->get();

            foreach ($stocks as $key => $stock) {
                $product = Products::where('id', $stock->product_id)->first();
                $filled_list[] = [
                    'product_id' => $stock->product_id,
                    'product_name' => $product->product_name,
                    'qty' => $stock->qty,
                ];
            }

            //Get extra list
            $stocks = DeliveryPersonStock::where('delivery_user_id', $request->delivery_user_id)
                ->where('extra_qty', '>', 0)
                ->get();

            foreach ($stocks as $key => $stock) {
                $product = Products::where('id', $stock->product_id)->first();
                $extra_list[] = [
                    'product_id' => $stock->product_id,
                    'product_name' => $product->product_name,
                    'extra_qty' => $stock->extra_qty,
                ];
            }
            $collect_return_list = array(
                'empty_list' => $empty_list,
                'filled_list' => $filled_list,
                'extra_list' => $extra_list
            );

            $response = array(
                'message' => "Success",
                'data' => $collect_return_list,
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

    public function collectDPReturnCans(Request $request)
    {
        DB::beginTransaction();
        try {

            $hub_id = $this->getRefId(Auth::user()->id, RoleTypes::Hub);
            $delivery_user_id = $request->delivery_user_id;
            $empty_list = $request->empty_list;
            $filled_list = $request->filled_list;
            $extra_list = $request->extra_list;
            $damaged_list = $request->damaged_list;

            //Empty stock updation
            foreach ($empty_list as $value) {
                HubStock::where('hub_id', $hub_id)
                    ->where('product_id', $value['product_id'])->update([
                        'empty_qty' => DB::raw('empty_qty + ' . ($value['collected_empty_qty'] - $value['damaged_qty']))
                    ]);
                $product = Products::find($value['product_id']);
                HubStockHistory::Create([
                    'hub_id' => $hub_id,
                    'product_type_id' => $product->product_type_id,
                    'brand_id' => $product->brand_id,
                    'category_id' => $product->category_id,
                    'product_id' => $product->id,
                    'inward_from_delivery_qty' => ($value['collected_empty_qty'] - $value['damaged_qty'])
                ]);

                DeliveryPersonStock::where('hub_id', $hub_id)
                    ->where('delivery_user_id', $delivery_user_id)
                    ->where('product_id', $value['product_id'])->update([
                        'return_empty_qty' => DB::raw('return_empty_qty - ' . ($value['collected_empty_qty'] + $value['return_damaged_qty'])),
                        'collected_empty_qty' => DB::raw('collected_empty_qty - ' . $value['collected_empty_qty']),
                        'return_damaged_qty' => DB::raw('return_damaged_qty - ' . $value['return_damaged_qty']),
                        'lost_qty' => DB::raw('lost_qty + ' . $value['damaged_qty'])
                    ]);

                DeliveryPersonStockHistory::create([
                    'hub_id' => $hub_id,
                    'delivery_user_id' => $delivery_user_id,
                    'product_type_id' => $product->product_type_id,
                    'brand_id' => $product->brand_id,
                    'category_id' => $product->category_id,
                    'product_id' => $product->id,
                    'outward_to_hub_qty' => $value['return_empty_qty'],
                    'inward_return_qty' => $value['damaged_qty']
                ]);
            }

            //Filled stock updation
            foreach ($filled_list as $value) {
                HubStock::where('hub_id', $hub_id)
                    ->where('product_id', $value['product_id'])->update([
                        'filled_qty' => DB::raw('filled_qty + ' . ($value['qty'] - $value['damaged_qty']))
                    ]);
                $product = Products::find($value['product_id']);
                HubStockHistory::Create([
                    'hub_id' => $hub_id,
                    'product_type_id' => $product->product_type_id,
                    'brand_id' => $product->brand_id,
                    'category_id' => $product->category_id,
                    'product_id' => $product->id,
                    'inward_return_qty' => ($value['qty'] - $value['damaged_qty'])
                ]);

                DeliveryPersonStock::where('hub_id', $hub_id)
                    ->where('delivery_user_id', $delivery_user_id)
                    ->where('product_id', $value['product_id'])->update([
                        'qty' => DB::raw('qty - ' . $value['qty']),
                        'lost_qty' => DB::raw('lost_qty + ' . $value['damaged_qty'])
                    ]);

                DeliveryPersonStockHistory::create([
                    'hub_id' => $hub_id,
                    'delivery_user_id' => $delivery_user_id,
                    'product_type_id' => $product->product_type_id,
                    'brand_id' => $product->brand_id,
                    'category_id' => $product->category_id,
                    'product_id' => $product->id,
                    'outward_return_qty' => $value['qty'],
                    'inward_return_qty' => $value['damaged_qty']
                ]);
            }

            //Extra stock updation
            foreach ($extra_list as $value) {
                HubStock::where('hub_id', $hub_id)
                    ->where('product_id', $value['product_id'])->update([
                        'filled_qty' => DB::raw('filled_qty + ' .  ($value['qty'] - $value['damaged_qty']))
                    ]);
                $product = Products::find($value['product_id']);
                HubStockHistory::Create([
                    'hub_id' => $hub_id,
                    'product_type_id' => $product->product_type_id,
                    'brand_id' => $product->brand_id,
                    'category_id' => $product->category_id,
                    'product_id' => $product->id,
                    'inward_return_qty' => ($value['qty'] - $value['damaged_qty'])
                ]);

                DeliveryPersonStock::where('hub_id', $hub_id)
                    ->where('delivery_user_id', $delivery_user_id)
                    ->where('product_id', $value['product_id'])->update([
                        'extra_qty' => DB::raw('extra_qty - ' . $value['qty']),
                        'lost_qty' => DB::raw('lost_qty + ' . $value['damaged_qty'])
                    ]);

                DeliveryPersonStockHistory::create([
                    'hub_id' => $hub_id,
                    'delivery_user_id' => $delivery_user_id,
                    'product_type_id' => $product->product_type_id,
                    'brand_id' => $product->brand_id,
                    'category_id' => $product->category_id,
                    'product_id' => $product->id,
                    'outward_return_qty' => $value['qty'],
                    'inward_return_qty' => $value['damaged_qty']
                ]);
            }

            //Damage stock updation
            // foreach ($damaged_list as $value) {
            //     DeliveryPersonStock::where('hub_id', $hub_id)
            //         ->where('delivery_user_id', $delivery_user_id)
            //         ->where('product_id', $value['product_id'])->update([
            //             'lost_qty' => DB::raw('lost_qty + ' . $value['qty'])
            //         ]);
            // }

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
