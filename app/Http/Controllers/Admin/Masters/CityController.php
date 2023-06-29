<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CityController extends Controller
{
    use Common;
    public function city()
    {
        try {
            $city = City::paginate(10);
            return view('admin.masters.city.city', compact('city'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getCityData()
    {
        try {
            $city = City::select('states.state_name', 'cities.*')->join('states', 'states.id', 'cities.state_id')->get();

            return datatables()->of($city)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<label class="switch">
                            <input type="checkbox" onclick="doStatus(' . $row->id . ');" id="chkCity' . $row->id . '" name="chkCity"
                            class="switch-input" ' . ($row->is_active == 1 ? "checked" : "") . '/>
                            <span class="switch-toggle-slider">
                                <span class="switch-on"></span>
                                <span class="switch-off"></span>
                            </span>
                        </label>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function syncCity()
    {
        try {
            $country = Country::where('id', 1)->first();
            $states = $this->getStates();

            if ($states->isEmpty()) {
                $notification = array(
                    'message' => 'Please sync states first!',
                    'alert-type' => 'error'
                );
            } else {
                foreach ($states as $state) {
                    $cities = Http::withHeaders([
                        'X-CSCAPI-KEY' => 'WVo5c0hpUWVGNGhkRWNTSzZ2bmpVZkZYWmZFUHNjaENsSm16djE0UQ=='
                    ])->get("https://api.countrystatecity.in/v1/countries/" . $country->country_code . "/states/" . $state->state_code . "/cities")->collect();

                    foreach ($cities as $city) {
                        $is_value_entered = City::where('city_name', $city['name'])->where('state_id', $state->id)->first();
                        if ($is_value_entered == null) {
                            City::create([
                                'city_name'  => $city['name'],
                                'state_id'   => $state->id
                            ]);
                        }
                    }
                }
                $notification = array(
                    'message' => 'Cities Synced Successfully',
                    'alert' => 'success'
                );
            }
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }

        return redirect()->route('city')->with($notification);
    }

    public function activeStatus($id, $status)
    {
        DB::beginTransaction();
        try {
            City::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getCityByStates(Request $request)
    {
        try {
            $city = $this->getCities($request->id)->toArray();
            return $city;
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
