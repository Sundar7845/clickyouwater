<?php

namespace App\Http\Controllers\API\Logistics;

use App\Enums\DocumentModulesType;
use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\HubCollectReturnCans;
use App\Models\HubReturnItems;
use App\Models\HubReturnItemsDet;
use App\Models\HubStock;
use App\Models\LogisticBooking;
use App\Models\LogisticBookingDet;
use App\Models\LogisticDriverInfo;
use App\Models\LogisticStock;
use App\Models\LogisticTrip;
use App\Models\LogisticVehicleInfo;
use App\Models\Manufacturer;
use App\Models\ManufactureStock;
use App\Models\Products;
use App\Traits\Common;
use App\Traits\ResponseAPI;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Trunc;

use function PHPUnit\Framework\isEmpty;

class LogisticsController extends Controller
{
    //
    use ResponseAPI;
    use Common;

    public function getLPUserInfo()
    {
        try {

            // $logistic_vehicle_id = LogisticDriverInfo::where('id', Auth::user()->ref_id)->pluck('logistic_vehicle_id')->first();
            $logisticVehicleInfoData = LogisticDriverInfo::select('logistic_driver_infos.*', 'logistic_partners.logistic_partner_name', 'logistic_vehicle_infos.reg_no', 'fuel_types.fuel_type', 'vehicle_types.vehicle_type', 'vehicle_brands.brand_name')
                ->join('logistic_vehicle_infos', 'logistic_vehicle_infos.id', 'logistic_driver_infos.logistic_vehicle_id')
                ->join('logistic_partners', 'logistic_partners.id', 'logistic_vehicle_infos.logistic_partner_id')
                ->join('fuel_types', 'fuel_types.id', 'logistic_vehicle_infos.fuel_type_id')
                ->join('vehicle_types', 'vehicle_types.id', 'logistic_vehicle_infos.vehicle_type_id')
                ->join('vehicle_brands', 'vehicle_brands.id', 'logistic_vehicle_infos.vehicle_brand_id')
                ->where('logistic_driver_infos.id', Auth::user()->ref_id)
                ->whereNull('logistic_vehicle_infos.deleted_at')
                ->whereNull('logistic_partners.deleted_at')
                ->whereNull('vehicle_brands.deleted_at')
                ->first();

            $todays_trip = LogisticTrip::where('driver_id', Auth::user()->ref_id)
                ->where('is_active', 0)
                ->whereDate('created_at', Carbon::now()->toDateString())
                ->count();

            $active_trip = LogisticTrip::where('driver_id', Auth::user()->ref_id)
                ->where('is_active', 1)->count();

            $trip_checked_in = LogisticTrip::where('driver_id', Auth::user()->ref_id)
                ->where('is_active', 1)->pluck('trip_start_on')->first();

            $booked_count = LogisticBooking::where('trip_id', $this->getActiveTripId(Auth::user()->ref_id))
                ->whereNotIn('status_id', [StatusTypes::LogisticReceivedfromManufacture, StatusTypes::LogisticBookingCancelled])->count();

            $allow_booking = LogisticBooking::where('trip_id', $this->getActiveTripId(Auth::user()->ref_id))
                ->whereIn('status_id', [StatusTypes::ManufactureDelivered, StatusTypes::LogisticReceivedfromManufacture, StatusTypes::HubCollected])->count();

            $delivery_to_factory = LogisticStock::where('driver_id', Auth::user()->ref_id)->sum('empty_qty');

            //Get delivery to hubs data after logistic received from manufacture
            $hub_ids = LogisticDriverInfo::where('id', Auth::user()->ref_id)->pluck('hub_id')->first();
            $hub_ids = explode(',', $hub_ids);
            $delivery_to_hubs = [];
            foreach ($hub_ids as $key => $hub_id) {
                $watercan_stock = 0;
                $others_stock = 0;
                $log_booking_id = LogisticBooking::join('logistic_booking_dets', 'logistic_booking_dets.logistic_booking_id', 'logistic_bookings.id')
                    ->where('trip_id', $this->getActiveTripId(Auth::user()->ref_id))
                    ->where('logistic_booking_dets.hub_id', $hub_id)
                    ->where('status_id', StatusTypes::LogisticReceivedfromManufacture)
                    ->pluck('logistic_bookings.id')
                    ->first();
                // dd($log_booking_id);
                if ($log_booking_id) {
                    $bookingDets = LogisticBookingDet::where('logistic_booking_id', $log_booking_id)->get();
                    foreach ($bookingDets as $key => $bookingdet) {
                        if ($bookingdet->hub_id == $hub_id) {
                            if ($bookingdet->products->category->is_watercan == 1) {
                                $watercan_stock += $bookingdet->qty;
                            } else {
                                $others_stock += $bookingdet->qty;
                            }
                        }
                    }
                }
                $delivery_to_hubs[] = [
                    'booking_id' => ($log_booking_id ? $log_booking_id : 0),
                    'hub_id' => $hub_id,
                    'hub_name' => $this->getHubName($hub_id),
                    'cans_qty' => (int)$watercan_stock,
                    'others_qty' => (int)$others_stock
                ];
            }

            $collect_return_items = [];
            $return_items = HubReturnItems::select('hub_return_items.*', DB::raw('SUM(qty) as qty'))
                ->join('hub_return_items_dets', 'hub_return_items_dets.hub_return_items_id', 'hub_return_items.id')
                ->where('driver_id', Auth::user()->ref_id)
                ->where('status_id', StatusTypes::Approved)
                ->groupBy('hub_id')
                ->get();
            // dd($return_items);
            foreach ($return_items as $key => $return_item) {
                $collect_return_items[] = [
                    'hub_id' => $return_item->hub_id,
                    'hub_name' => $this->getHubName($return_item->hub_id),
                    'qty' => (int)$return_item->qty
                ];
            }
            $lp_user_info = array(
                'driver_name' => $logisticVehicleInfoData->driver_name,
                'vehicle_no' => strtoupper($logisticVehicleInfoData->reg_no),
                'vehicle_brand_name' => $logisticVehicleInfoData->brand_name,
                'trips_today' => $todays_trip,
                'trip_active' => ($active_trip > 0 ? true : false),
                'active_trip_id' => $this->getActiveTripId(Auth::user()->ref_id),
                'trip_checked_in' => ($trip_checked_in ? DateTime::createFromFormat('Y-m-d H:i:s', $trip_checked_in)->format('d M, Y H:i A') : null),
                'is_booked' => ($booked_count > 0 ? true : false),
                'allow_booking' => ($allow_booking > 0 ? false : true),
                'delivery_to_factory' => (int)$delivery_to_factory,
                'delivery_to_hubs' => $delivery_to_hubs,
                'collect_return_items' => $collect_return_items
            );

            $response = array(
                'message' => "Success",
                'data' => $lp_user_info,
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

    public function startTrip(Request $request)
    {
        try {
            $manufacture_id = $this->getManufactureId(Auth::user()->ref_id);

            if ($manufacture_id != $request->manufacture_id) {
                $response = array(
                    'message' => "Oops! You are not authorised to scan here.",
                    'data' => [],
                    'is_active_trip' => false,
                    'status' => false,
                );
                return response($response, 200);
            }
            $active_trip = LogisticTrip::where('manufacture_id', $manufacture_id)
                ->where('driver_id', Auth::user()->ref_id)
                ->where('is_active', 1)->count();
            if ($active_trip == 0) {
                LogisticTrip::create([
                    'manufacture_id' => $manufacture_id,
                    'driver_id' => Auth::user()->ref_id,
                    'is_active' => 1,
                    'trip_start_on' => Carbon::now(),
                ]);

                $response = array(
                    'message' => "Success",
                    'data' => [],
                    'is_active_trip' => true,
                    'status' => true,
                );
            } else {
                $response = array(
                    'message' => "You have active trip. Please complete the trip before start new trip.",
                    'data' => [],
                    'is_active_trip' => true,
                    'status' => false,
                );
            }
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

    public function endTrip()
    {
        try {
            LogisticTrip::where('driver_id', Auth::user()->ref_id)
                ->where('is_active', 1)->update([
                    'is_active' => 0,
                    'trip_end_on' => Carbon::now()
                ]);

            $response = array(
                'message' => "Success",
                'data' => [],
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

    public function getHubOrdersInfo()
    {
        try {

            $hub_ids = LogisticDriverInfo::where('id', Auth::user()->ref_id)->pluck('hub_id')->first();
            $hub_ids = explode(',', $hub_ids);
            $hub_orders_info = [];
            foreach ($hub_ids as $key => $hub_id) {
                // dd($hub_id);

                $stocks = HubStock::where('hub_id', $hub_id)->get();
                $watercan_stock = 0;
                $others_stock = 0;
                if ($stocks) {
                    foreach ($stocks as $key => $stock) {
                        // dd($stock->products->category);
                        // if ($stock->products->is_emptycan_return == 1 && $stock->products->category->is_watercan == 1) {
                        if ($stock->products->category->is_watercan == 1) {
                            $watercan_stock += $stock->order_qty;
                        } else {
                            $others_stock += $stock->order_qty;
                        }
                    }
                }
                // dd($watercan_stock);
                $log_booking_id = LogisticBooking::join('logistic_booking_dets', 'logistic_booking_dets.logistic_booking_id', 'logistic_bookings.id')
                    ->where('hub_id', $hub_id)
                    ->where('is_hub_confirmed', 0)
                    ->where('trip_id', $this->getActiveTripId(Auth::user()->ref_id))
                    ->where('status_id', StatusTypes::LogisticBooked)
                    ->pluck('logistic_bookings.id')
                    ->first();
                $delivered_on = LogisticBookingDet::where('hub_id', $hub_id)
                    ->orderBy('delivered_on', 'desc')
                    ->pluck('delivered_on')->first();
                // dd(is_null($delivered_on));
                if (!is_null($delivered_on)) {
                    $delivered_on =  Carbon::parse($delivered_on ? $delivered_on : Carbon::now());
                    $current_date = Carbon::parse(Carbon::now());

                    $last_del_days = $current_date->diffInDays($delivered_on);

                    $last_delivery = ($last_del_days == 0 ? "Today" : 'Last Delivered ' . $last_del_days . ' days ago (' . DateTime::createFromFormat('Y-m-d H:i:s', $delivered_on)->format('d M') . ')');
                    $highlight_in_red = ($last_del_days > 2 ? true : false);
                } else {
                    $last_delivery = "";
                    $highlight_in_red = false;
                }
                $hub_orders_info[] = [
                    'booking_id' => ($log_booking_id ? $log_booking_id : 0),
                    'hub_id' => $hub_id,
                    'hub_name' => $this->getHubName($hub_id),
                    'cans_qty' => (int)$watercan_stock,
                    'others_qty' => (int)$others_stock,
                    'last_delivery' => $last_delivery,
                    'highlight_in_red' => $highlight_in_red
                ];
            }
            $response = array(
                'message' => "Success",
                'data' => $hub_orders_info,
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

    public function getDeliveryToFactory()
    {
        try {
            $manufacture_id = $this->getManufactureId(Auth::user()->ref_id);
            $manufacture = Manufacturer::where('id', $manufacture_id)->first();
            $tot_delivery_to_factory = LogisticStock::where('driver_id', Auth::user()->ref_id)->sum('empty_qty');

            $returm_items = [];
            $log_returns = LogisticStock::where('driver_id', Auth::user()->ref_id)->where('empty_qty', '>', 0)->get();
            foreach ($log_returns as $key => $log_return) {
                // dd($log_return);
                $returm_items[] = array(
                    'product_id' => $log_return->product_id,
                    'product_name' => $log_return->products->product_name,
                    'product_type_id' => $log_return->products->product_type_id,
                    'product_type_name' => $log_return->products->productType->product_type_name,
                    'brand_id' => $log_return->products->brand_id,
                    'brand_name' => $log_return->products->brand->brand_name,
                    'category_id' => $log_return->products->category_id,
                    'category_name' => $log_return->products->category->category_name,
                    'empty_qty' => $log_return->empty_qty,
                );
            }

            $factory_info = array(
                'manufacture_id' => $manufacture_id,
                'manufacture_name' => $manufacture->manufacturer_name,
                'mobile' => $manufacture->mobile,
                'address' => $manufacture->address . $manufacture->area->area_name . $manufacture->city->city_name . $manufacture->state->state_name . $manufacture->pincode,
                'total_qty' => $tot_delivery_to_factory,
                'return_items' => $returm_items
            );

            $response = array(
                'message' => "Success",
                'data' => $factory_info,
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

    public function getDeliveryToHub(Request $request)
    {
        try {
            $hub = Hub::where('id', $request->hub_id)->first();

            $delivery_items = [];
            $log_booking_dets = LogisticBookingDet::where('hub_id', $request->hub_id)
                ->where('logistic_booking_id', $request->booking_id)
                ->where('is_hub_confirmed', 0)
                ->get();

            foreach ($log_booking_dets as $key => $log_booking_det) {
                // dd($log_return);
                $delivery_items[] = array(
                    'product_id' => $log_booking_det->product_id,
                    'product_name' => $log_booking_det->products->product_name,
                    'product_type_id' => $log_booking_det->products->product_type_id,
                    'product_type_name' => $log_booking_det->products->productType->product_type_name,
                    'brand_id' => $log_booking_det->products->brand_id,
                    'brand_name' => $log_booking_det->products->brand->brand_name,
                    'category_id' => $log_booking_det->products->category_id,
                    'category_name' => $log_booking_det->products->category->category_name,
                    'qty' => $log_booking_det->qty,
                );
            }

            $hub_info = array(
                'hub_id' => $request->hub_id,
                'hub_name' => $hub->hub_name,
                'mobile' => $hub->mobile,
                'address' => $hub->address . $hub->area->area_name . $hub->city->city_name . $hub->state->state_name . $hub->pincode,
                'delivery_items' => $delivery_items
            );

            $response = array(
                'message' => "Success",
                'data' => $hub_info,
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

    public function getHubStocks(Request $request)
    {
        try {
            $manufacture_id = $this->getManufactureId(Auth::user()->ref_id);

            $hub_stocks = [];

            $stocks = HubStock::where('hub_id', $request->hub_id)->get();
            if ($stocks) {
                foreach ($stocks as $key => $stock) {
                    $hub_stocks[] = [
                        'product_id' => $stock->product_id,
                        'product_name' => $stock->products->product_name,
                        'product_type_id' => $stock->products->product_type_id,
                        'product_type_name' => $stock->products->productType->product_type_name,
                        'brand_id' => $stock->products->brand_id,
                        'brand_name' => $stock->products->brand->brand_name,
                        'category_id' => $stock->products->category_id,
                        'category_name' => $stock->products->category->category_name,
                        'order_qty' => (int)$stock->order_qty,
                        'avail_qty' => (int)$this->getManufactureInStock($stock->product_id, $manufacture_id),
                        'booked_qty' => (int)$this->getBookedStock($stock->product_id, $request->hub_id, $request->booking_id),
                        'is_watercan' => $stock->products->category->is_watercan
                    ];
                }
            }

            $response = array(
                'message' => "Success",
                'data' => $hub_stocks,
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

    public function bookItems(Request $request)
    {
        DB::beginTransaction();
        try {

            $booking_id = ($request->booking_id ? $request->booking_id : null);

            if ($booking_id > 0) {
                $booking_status = LogisticBooking::where('id', $booking_id)->where('status_id', StatusTypes::LogisticBooked)->count();
                if ($booking_status > 0) {
                    $product_details = $request->product_details;
                    foreach ($product_details as $value) {
                        LogisticBookingDet::updateOrCreate(
                            [
                                'logistic_booking_id' => $booking_id,
                                'hub_id' => $request->hub_id,
                                'product_id' => $value['product_id'],
                            ],
                            [
                                'logistic_booking_id' => $booking_id,
                                'hub_id' => $request->hub_id,
                                'product_id' => $value['product_id'],
                                'qty' => $value['qty'],
                            ]
                        );
                    }
                } else {
                    $response = array(
                        'message' => "Oops! You can't able to edit this booking.",
                        'data' => [],
                        'status' => false,
                    );
                    return response($response, 200);
                }
            } else {
                $booking_no = $this->getAutoGeneratedCode(DocumentModulesType::LogisticBooking);
                $this->updateLiveCount(DocumentModulesType::LogisticBooking, 1);

                $booking = LogisticBooking::create([
                    'trip_id' => $request->active_trip_id,
                    'booking_no' => $booking_no,
                    'manufacture_id' => $this->getManufactureId(Auth::user()->ref_id),
                    'driver_id' => Auth::user()->ref_id,
                    'status_id' => StatusTypes::LogisticBooked
                ]);

                $product_details = $request->product_details;
                foreach ($product_details as $value) {
                    # code...
                    LogisticBookingDet::create([
                        'logistic_booking_id' => $booking->id,
                        'hub_id' => $request->hub_id,
                        'product_id' => $value['product_id'],
                        'qty' => $value['qty'],
                    ]);
                }
            }

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

    public function getBookedItems()
    {
        try {
            $booked_items = [];
            $is_manufacture_delivered = false;
            $active_trip_id = $this->getActiveTripId(Auth::user()->ref_id);
            $log_bookings = LogisticBooking::where('trip_id', $active_trip_id)
                ->where('status_id', StatusTypes::LogisticBooked)
                ->get();
            // dd($log_bookings);
            if ($log_bookings->count() == 0) {
                $log_bookings = LogisticBooking::where('trip_id', $active_trip_id)
                    ->where('status_id', StatusTypes::ManufactureDelivered)
                    ->get();
                $is_manufacture_delivered = ($log_bookings->count() > 0 ? true : false);
            }
            foreach ($log_bookings as $key => $booking) {
                foreach ($booking->bookingDets as $key => $bookingdet) {
                    $product = Products::find($bookingdet->product_id);

                    // Check if the product already exists in $booked_items array
                    if (isset($booked_items[$product->id])) {
                        // If it exists, increment the booked_qty
                        $booked_items[$product->id]['booked_qty'] += $bookingdet->qty;
                    } else {
                        // If it doesn't exist, add a new entry to $booked_items array
                        $booked_items[$product->id] = [
                            'product_id' => $product->id,
                            'product_name' => $product->product_name,
                            'is_watercan' => $product->category->is_watercan,
                            'booked_qty' => (int)$bookingdet->qty
                        ];
                    }
                }
            }

            // Convert associative array to sequential array if needed
            $booked_items = array_values($booked_items);
            $response = array(
                'message' => "Success",
                'data' => $booked_items,
                'is_manufacture_delivered' => $is_manufacture_delivered,
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

    public function confirmBooking()
    {
        try {

            $active_trip_id = $this->getActiveTripId(Auth::user()->ref_id);

            LogisticBooking::where('trip_id', $active_trip_id)
                ->where('status_id', StatusTypes::ManufactureDelivered)
                ->update([
                    'status_id' => StatusTypes::LogisticReceivedfromManufacture
                ]);

            $response = array(
                'message' => "Success",
                'data' => [],
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

    public function cancelAllBookings()
    {
        try {
            LogisticBooking::where('trip_id', $this->getActiveTripId(Auth::user()->ref_id))
                ->where('status_id', StatusTypes::LogisticBooked)
                ->update([
                    'status_id' => StatusTypes::LogisticBookingCancelled,
                    'is_cancelled' => 1,
                    'cancelled_on' => Carbon::now()
                ]);

            $response = array(
                'message' => "Success",
                'data' => [],
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

    public function getHubReturnItems(Request $request)
    {
        try {

            $hub_stocks = [];

            $stocks = HubReturnItems::join('hub_return_items_dets', 'hub_return_items_dets.hub_return_items_id', 'hub_return_items.id')
                ->where('driver_id', Auth::user()->ref_id)
                ->where('status_id', StatusTypes::Approved)
                ->where('hub_id', $request->hub_id)
                ->get();
            // dd($stocks);
            if ($stocks) {
                foreach ($stocks as $key => $stock) {
                    $product = Products::where('id', $stock->product_id)->first();
                    $hub_stocks[] = [
                        'product_id' => $stock->product_id,
                        'product_name' => $product->product_name,
                        'product_type_id' => $product->product_type_id,
                        'product_type_name' => $product->productType->product_type_name,
                        'brand_id' => $product->brand_id,
                        'brand_name' => $product->brand->brand_name,
                        'category_id' => $product->category_id,
                        'category_name' => $product->category->category_name,
                        'qty' => (int)$stock->qty,
                    ];
                }
            }

            $response = array(
                'message' => "Success",
                'data' => $hub_stocks,
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
    public function confirmReturnItems(Request $request)
    {
        try {
            $hub_id = $request->hub_id;
            $driver_id = Auth::user()->ref_id;
            $hub_returns = HubReturnItems::where('hub_id', $hub_id)
                ->where('driver_id', $driver_id)
                ->where('status_id', StatusTypes::Approved)->get();
            foreach ($hub_returns as $key => $hub_return) {
                foreach ($hub_return->hubReturnItemsDets as $key => $hubReturnItemsDet) {
                    HubReturnItemsDet::where('hub_return_items_id', $hub_return->id)
                        ->where('product_id', $hubReturnItemsDet->product_id)->update([
                            'received_qty' => DB::raw('qty')
                        ]);
                }
                HubReturnItems::where('hub_id', $hub_id)
                    ->where('driver_id', $driver_id)
                    ->where('status_id', StatusTypes::Approved)->update([
                        'status_id' => StatusTypes::LogisticReceivedfromHub
                    ]);
            }
            $response = array(
                'message' => "Success",
                'data' => [],
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

    public function getDeliveryHistory()
    {
        try {
            $delivery_history = [];
            $log_bookings = LogisticBooking::join('logistic_booking_dets', 'logistic_booking_dets.logistic_booking_id', 'logistic_bookings.id')
                ->where('driver_id', Auth::user()->ref_id)
                ->where('logistic_booking_dets.is_hub_confirmed', 1)
                ->groupBy('logistic_bookings.id')
                ->paginate($this->recordsperpage);
            foreach ($log_bookings as $key => $log_booking) {
                $delivery_history[] = [
                    'hub_id' => $log_booking->hub_id,
                    'hub_name' => $this->getHubName($log_booking->hub_id),
                    'delivered_on' => ($log_booking->delivered_on ? DateTime::createFromFormat('Y-m-d H:i:s', $log_booking->delivered_on)->format('d M, Y H:i A') : "")
                ];
            }
            $response = array(
                'message' => "Success",
                'data' => $delivery_history,
                'pagination' => [
                    'total' => $log_bookings->total(),
                    'per_page' => $log_bookings->perPage(),
                    'current_page' => $log_bookings->currentPage(),
                    'last_page' => $log_bookings->lastPage(),
                    'next_page_url' => $log_bookings->nextPageUrl(),
                    'prev_page_url' => $log_bookings->previousPageUrl(),
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
    public function getBookedStock($product_id, $hub_id, $booking_id)
    {
        $in_stock = LogisticBookingDet::where('hub_id', $hub_id)
            ->where('product_id', $product_id)
            ->where('logistic_booking_id', $booking_id)
            ->where('is_hub_confirmed', 0)
            ->sum('qty');
        return $in_stock;
    }

    public function getManufactureId($driver_id)
    {
        $manufacture_id =  LogisticDriverInfo::join('logistics_manufacture_configs', 'logistics_manufacture_configs.logistic_partner_id', 'logistic_driver_infos.logistic_partner_id')
            ->where('logistic_driver_infos.id', $driver_id)
            ->pluck('logistics_manufacture_configs.manufacture_id')->first();
        return $manufacture_id;
    }
}
