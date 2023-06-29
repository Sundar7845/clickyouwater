<?php

namespace App\Http\Controllers\API\Delivery;

use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryPersonOrderResource;
use App\Models\DeliveryPersonStock;
use App\Models\Products;
use App\Traits\Common;
use App\Traits\ResponseAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryPersonOrdersController extends Controller
{
    //
    use ResponseAPI;
    use Common;
    public function getDPOrders(Request $request)
    {
        try {

            $user_id = ($request->user_id ? $request->user_id : Auth::user()->id);
            $orders = $this->getOrders($request->status_id, $user_id, $request->is_notdelivered);
            // dd($orders->get());

            $userOrders = $orders->paginate($this->recordsperpage);

            $response = array(
                'message' => "Success",
                'data' => DeliveryPersonOrderResource::collection($userOrders),
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

    public function getDPOrderDetails($id)
    {
        try {
            $orderdetails = $this->getOrderDetail($id);

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

    public function getEmptyCansToCollectList()
    {
        try {

            $orders = $this->getOrders(StatusTypes::OrderShipped)->get();
            // dd($orders);
            $list = [];
            if ($orders) {
                foreach ($orders as $key => $order) {
                    // dd($order->orderDets);
                    foreach ($order->orderDets as $key => $orderdet) {
                        if ($orderdet->return_empty_cans_qty > 0) {
                            $list[] = [
                                'product_id' => $orderdet->product_id,
                                'product_name' => $orderdet->products->product_name,
                                'return_empty_cans_qty' => $orderdet->return_empty_cans_qty,
                            ];
                        }
                    }
                }
            }

            $grouped_product_list = collect($list)->groupBy('product_id');

            $product_list = [];

            foreach ($grouped_product_list as $key => $list) {
                $tot_empty_cans = $list->sum('return_empty_cans_qty');
                $firstItem = $list->first();

                $product_list[] = [
                    'product_id' => $firstItem['product_id'],
                    'product_name' => $firstItem['product_name'],
                    'return_empty_cans_qty' => $tot_empty_cans,
                ];
            }

            $response = array(
                'message' => "Success",
                'data' => $product_list,
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

    public function getDPItemsList()
    {
        try {

            $orders = $this->getOrders(StatusTypes::OrderShipped)->get();
            // dd($orders);
            $watercan_list = [];
            $others_list = [];
            $extra_list = [];
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

            $extra_list = $this->getDPExtraItems(Auth::user()->id);
            // dd($extra_stocks);

            $items_list = [
                'watercans' => $product_watercan_list,
                'otheritems' => $product_others_list,
                'extracans' => $extra_list,
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
}
