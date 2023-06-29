<?php

namespace App\Http\Controllers\API;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Models\CustomerAddress;
use App\Models\Offer;
use App\Models\Reasons;
use App\Models\ReasonType;
use App\Models\Status;
use App\Models\User;
use App\Traits\Common;
use App\Traits\Maps;
use App\Traits\ResponseAPI;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{

    use Common;
    use Maps;
    use ResponseAPI;
    public function getAdminSettings()
    {
        try {

            $admin_settings = $this->getAdminSetting();

            $admin_settings->company_logo = $this->getBaseUrl() . '/' . $admin_settings->company_logo;
            $admin_settings->app_logo = $this->getBaseUrl() . '/' . $admin_settings->app_logo;

            $response = [
                'status' => true,
                'data' => $admin_settings
            ];
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
    public function getReasons($id)
    {
        try {
            $reasons = Reasons::where('reason_type_id', $id)->get();
            $response = [
                'status' => true,
                'data' => $reasons
            ];
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
    public function getReasonsTypes()
    {
        try {
            $reasons = ReasonType::all();
            $response = [
                'status' => true,
                'data' => $reasons
            ];
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

    public function getBanners()
    {
        try {

            // $customer_id = User::where('id', Auth::id())->value('ref_id');
            $customer_id = $this->getRefId(Auth::user()->id, RoleTypes::Customer);
            $customer_address = CustomerAddress::where('customer_id', $customer_id)
                ->where('is_default', 1)
                ->select('state_id', 'city_id', 'latitude', 'longitude')
                ->first();

            $hub_id = $this->getServiceAvailable($customer_address->latitude, $customer_address->longitude, $customer_address->state_id, $customer_address->city_id);
            // dd($hub_id);

            //Get offers against hub
            $offer_hubs = DB::table('offers as o')
                ->select('o.id', 'offer_image_path as img')
                ->join('offer_hub_allocations as oha', 'oha.offer_id', '=', 'o.id')
                ->where('o.start_date', '<=', Carbon::now())
                ->where('o.end_date', '>=', Carbon::now())
                ->where('oha.hub_id', '=', $hub_id)
                ->whereNotIn('o.offer_type_id', [2])
                ->whereNull('oha.deleted_at')
                ->whereNull('o.deleted_at')
                ->where('o.is_active', 1)
                ->get();

            // dd($offer_hubs);
            //Get offers against state
            $offer_states = DB::table('offers as o')
                ->select('o.id', 'offer_image_path as img')
                ->join('offer_allocations as oa', 'oa.offer_id', '=', 'o.id')
                ->where('o.start_date', '<=', Carbon::now())
                ->where('o.end_date', '>=', Carbon::now())
                ->whereRaw("FIND_IN_SET($customer_address->state_id, oa.state_id)")
                ->whereIn('o.offer_type_id', [2])
                ->whereNull('oa.deleted_at')
                ->whereNull('o.deleted_at')
                ->where('o.is_active', 1)
                ->get();

            //Merge hub and state offers
            $offers = array_merge($offer_hubs->toArray(), $offer_states->toArray());

            // Append base URL to offer field
            foreach ($offers as $offer) {
                $offer->img = $this->getBaseUrl() . '/' . $offer->img;
            }

            $banners = Banners::select('id', 'banner_img as img')
                ->where('is_active', 1)
                ->where('start_date', '<=', Carbon::now())
                ->Where('end_date', '>=', Carbon::now())
                ->get();

            // Append base URL to banner field
            foreach ($banners as $banner) {
                $banner->img = $this->getBaseUrl() . '/' . $banner->img;
            }

            //Merge hub and state offers
            $banners = array_merge($offers, $banners->toArray());

            $response = [
                'status' => true,
                'banners' => $banners
            ];
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
    public function getTrackingStatus(Request $request)
    {
        try {

            $status_ids = explode(',', $request->status_ids);
            $tracking_status = Status::whereIn('id', $status_ids)->get();

            // Custom order of IDs
            $customOrder = [15, 19, 16, 17];

            // Sort the results based on the custom order
            $results = collect($tracking_status)->sortBy(function ($item) use ($customOrder) {
                return array_search($item['id'], $customOrder);
            })->values()->all();

            $response = [
                'status' => true,
                'data' => $results
            ];
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
