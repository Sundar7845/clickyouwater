<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\HubManufactureConfig;
use App\Models\Offer;
use App\Models\OfferHubAllocation;
use App\Models\State;
use Illuminate\Http\Request;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OffersAllocateController extends Controller
{
    use common;
    public function offersAllocate()
    {
        try {
            $offernames = Offer::where('offer_type_id', '!=', 3)->where('is_active', 1)->get();
            $states = $this->getStates();
            return view('admin.offer.offers_allocate', compact('offernames', 'states'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addOfferAllocation(Request $request)
    {
        try {
            $request->validate([
                'ddlOfferName' => 'required'
            ]);
            $fillable = $request->all();
            unset($fillable['_token']);
            if ($request->ddlOfferName == "new") {
                //hub id 
                $hubid = $request->hdSelHubIds;
                $array_hubid = json_decode($hubid, true);

                //points allocate
                $point_allocation = $request->hdSelHubPoints;
                $array_pointallocation = json_decode($point_allocation, true);

                foreach ($array_hubid as $key => $hubid_value) {
                    $point_allocation_value = $array_pointallocation[$key];

                    OfferHubAllocation::create([
                        'offer_id' => $request->ddlOfferName,
                        'hub_id' => $hubid_value,
                        'points_allocated' => $point_allocation_value,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now()
                    ]);
                }
            } else {
                unset($fillable['_token']);
                unset($fillable['id']);
                OfferHubAllocation::where('offer_id', $request->ddlOfferName)->delete();
                //hub id 
                $hubid = $request->hdSelHubIds;
                $array_hubid = json_decode($hubid, true);

                //points allocate
                $point_allocation = $request->hdSelHubPoints;
                $array_pointallocation = json_decode($point_allocation, true);
                foreach ($array_hubid as $key => $hubid_value) {
                    $point_allocation_value = $array_pointallocation[$key];

                    OfferHubAllocation::create([
                        'offer_id' => $request->ddlOfferName,
                        'hub_id' => $hubid_value,
                        'points_allocated' => $point_allocation_value,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
            $notification = array(
                'message' => 'Offer Allocation Created Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('offers-allocate')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Offer Allocation Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
    }

    public function getHubs(Request $request)
    {
        try {
            if ($request->city_id) {
                $common_offer_id = 3;
                $query = Hub::select(
                    'hubs.id',
                    'hubs.hub_name',
                    DB::raw('SUM(offer_hub_allocations.points_allocated) as total_points_allocated'),
                    DB::raw('SUM(CASE WHEN offer_hub_allocations.offer_id = ' . $common_offer_id . ' THEN offer_hub_allocations.points_allocated ELSE 0 END) as common_offer_points_allocated'),
                    DB::raw('SUM(offer_hub_allocations.points_allocated) - SUM(CASE WHEN offer_hub_allocations.offer_id = ' . $common_offer_id . ' THEN offer_hub_allocations.points_allocated ELSE 0 END) as other_offer_points_allocated')
                )
                    ->leftJoin('offer_hub_allocations', 'offer_hub_allocations.hub_id', 'hubs.id')
                    ->where('city_id', $request->city_id)
                    ->whereNull('offer_hub_allocations.deleted_at')
                    ->whereNull('hubs.deleted_at')
                    ->groupBy('hubs.id');
            } else if ($request->offer_id) {
                $query = Offer::select('offers.*', 'offer_hub_allocations.points_allocated', 'offers.offer_total_points')
                    ->leftJoin('offer_hub_allocations', 'offer_hub_allocations.offer_id', 'offers.id')
                    ->whereNull('offers.deleted_at')
                    ->where('offers.id', $request->offer_id);
            }

            $data = $query->get();
            return response()->json($data);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
