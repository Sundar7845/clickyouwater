<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\FuelType;
use App\Models\VehicleBrand;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleBrandController extends Controller
{
    use Common;
    public function vehicleBrands()
    {
        try {
            $fuelTypes = FuelType::get();
            return view('admin.masters.vehiclebrands.vehicle_brands', compact('fuelTypes'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addVehicleBrands(Request $request)
    {
        $request->validate([
            'ddlFuelType' => 'required',
            'txtBrandName' => [
                'required',
                Rule::unique('vehicle_brands', 'brand_name')->where(function ($query) use ($request) {
                    return $query->where('fuel_type_id', $request->input('ddlFuelType'));
                })->whereNull('deleted_at')->ignore($request->hdVehicleBrandId),
            ],
        ], [
            'txtBrandName.unique' => 'Brand name already exists.'
        ]);

        DB::beginTransaction();
        try {

            if ($request->hdVehicleBrandId == null) {
                VehicleBrand::create([
                    'fuel_type_id' => $request->ddlFuelType,
                    'brand_name' => $request->txtBrandName,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);

                $notification = array(
                    'message' => 'Vehicle Brand Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                VehicleBrand::findorfail($request->hdVehicleBrandId)->update([
                    'fuel_type_id' => $request->ddlFuelType,
                    'brand_name' => $request->txtBrandName,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Vehicle Brand Updated Successfully',
                    'alert-type' => 'success'
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Vehicle Brand Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }

        return redirect()->route('vehiclebrands')->with($notification);
    }

    public function deletVehicleBrands($id)
    {
        DB::beginTransaction();
        try {
            $vehicleBrands = VehicleBrand::findorfail($id);
            $vehicleBrands->delete();

            $vehicleBrands->Update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Vehicle Brand Deleted Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Vehicle Brand Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getVehicleBrandnById($id)
    {
        try {
            $vehicleBrands = VehicleBrand::where('id', $id)->whereNull('deleted_at')->first();
            return response()->json([
                'vehiclebrands' => $vehicleBrands
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getVehicleBrandsData()
    {
        try {
            $vehicleBrandsData = VehicleBrand::select('vehicle_brands.*', 'fuel_types.fuel_type', 'hub_vehicle_infos.vehicle_brand_id as hub_vehicle_brand_id', 'logistic_vehicle_infos.vehicle_brand_id as log_vehicle_brand_id')
                ->join('fuel_types', 'fuel_types.id', 'vehicle_brands.fuel_type_id')
                ->leftJoin('hub_vehicle_infos', 'hub_vehicle_infos.vehicle_brand_id', 'vehicle_brands.id')
                ->leftJoin('logistic_vehicle_infos', 'logistic_vehicle_infos.vehicle_brand_id', 'vehicle_brands.id')
                ->whereNull('vehicle_brands.deleted_at')
                ->groupBy('vehicle_brands.id')
                ->orderBy('vehicle_brands.id', 'ASC')
                ->get();

            return datatables()->of($vehicleBrandsData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->hub_vehicle_brand_id == null && $row->log_vehicle_brand_id == null) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confirm-color' . $row->id . '" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
