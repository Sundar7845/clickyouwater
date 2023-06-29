<?php

namespace App\Http\Controllers\Admin\LogisticManagement;

use App\Enums\MenuPermissionType;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\FuelType;
use App\Models\LogisticDriverInfo;
use App\Models\LogisticPartner;
use App\Models\LogisticVehicleInfo;
use App\Models\User;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Validation\Rule;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LogisticVehicleInfoController extends Controller
{
    use common;
    public function logisticVehicleInfo()
    {

        try {
            if (Auth::user()->role_id == RoleTypes::LogisticPartner) {
                // $logistic_partner_id = User::select('ref_id')->where('id', Auth::user()->id)->pluck('ref_id')->first();
                $logistic_partner_id =  $this->getRefId(Auth::user()->id, RoleTypes::LogisticPartner);
            } else {
                $logistic_partner_id = 0;
            }
            $logisticPartners = LogisticPartner::select('id', 'logistic_partner_name')->where('is_active', 1)->whereNull('deleted_at')->get();
            $fuelTypes = FuelType::get();
            $vehicleBrands = VehicleBrand::whereNull('deleted_at')->get();
            $vehicleTypes = VehicleType::get();
            return view('admin.logistic_management.add_logistic_vehicle_info', compact('logisticPartners', 'fuelTypes', 'vehicleBrands', 'vehicleTypes', 'logistic_partner_id'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addLogisticVehicleInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ddlLogisticPartner' => 'required',
            'ddlFuelType' => 'required',
            'ddlVehicleBrand' => 'required',
            'ddlVehicleType' => 'required',
            'txtRegNo' => [
                'required',
                Rule::unique('logistic_vehicle_infos', 'reg_no')->WhereNull('deleted_at')->ignore($request->hdLogisticVehicleId),
            ],
            'txtWeight' => 'required',
            'txtCapacity' => 'required'
        ], [
            'txtRegNo.unique' => 'Register number already exists.',
            'ddlLogisticPartner.required' => 'Please Select Logistic Partner.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        DB::beginTransaction();
        try {

            if ($request->hdLogisticVehicleId == null) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                LogisticVehicleInfo::create([
                    'logistic_partner_id' => $request->ddlLogisticPartner,
                    'fuel_type_id' => $request->ddlFuelType,
                    'vehicle_brand_id' => $request->ddlVehicleBrand,
                    'vehicle_type_id' => $request->ddlVehicleType,
                    'reg_no' => $request->txtRegNo,
                    'weight' => $request->txtWeight,
                    'capacity' => $request->txtCapacity,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                $notification = array(
                    'message' => 'Vehicle Info Created Successfully!',
                    'alert-type' => 'success'
                );
            } else {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                LogisticVehicleInfo::findorfail($request->hdLogisticVehicleId)->update([
                    'logistic_partner_id' => $request->ddlLogisticPartner,
                    'fuel_type_id' => $request->ddlFuelType,
                    'vehicle_brand_id' => $request->ddlVehicleBrand,
                    'vehicle_type_id' => $request->ddlVehicleType,
                    'reg_no' => $request->txtRegNo,
                    'weight' => $request->txtWeight,
                    'capacity' => $request->txtCapacity,
                    'updated_by' => Auth::user()->id
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                $notification = array(
                    'message' => 'Vehicle Info Updated Successfully!',
                    'alert-type' => 'success'
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Vehicle Info Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }

        $authLogisticPartner = Auth::user()->role_id == RoleTypes::LogisticPartner ? 'vehicles' : 'logisticVehicleInfo';
        return redirect()->route($authLogisticPartner)->with($notification);
    }

    public function deletLogisticVehicleInfo($id)
    {
        try {
            $logisticDriverCount = LogisticDriverInfo::where('logistic_vehicle_id', $id)->get()->count();
            if ($logisticDriverCount == 0) {
                $logisticVehicleInfo = LogisticVehicleInfo::findorfail($id);
                $logisticVehicleInfo->delete();
                $logisticVehicleInfo->Update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Vehicle Info Deleted Successfully!',
                    'alert' => 'success'
                );
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Vehicle Could Not Be Deleted!',
                    'alert' => 'error'
                );
                return response()->json([
                    'responseData' => $notification
                ]);
            }
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Vehicle Info Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getLogisticVehicleInfoById($id)
    {
        try {
            $logisticVehicleInfo = LogisticVehicleInfo::where('id', $id)->whereNull('deleted_at')->first();
            return response()->json([
                'logisticVehicleInfo' => $logisticVehicleInfo
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getVehicleBrandsByFuelType($fuelTypeId)
    {
        try {
            $vehicleBrands = VehicleBrand::where('fuel_type_id', $fuelTypeId)->whereNull('deleted_at')->get();
            return response()->json([
                'vehicleBrands' => $vehicleBrands
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }


    public function getLogisticVehicleInfoData()
    {
        try {
            $logisticVehicleInfoData = LogisticVehicleInfo::select(
                'logistic_vehicle_infos.*',
                'logistic_partners.logistic_partner_name',
                'fuel_types.fuel_type',
                'vehicle_types.vehicle_type',
                'vehicle_brands.brand_name',
                'ldi.logistic_vehicle_id'
            )
                ->join('logistic_partners', 'logistic_partners.id', 'logistic_vehicle_infos.logistic_partner_id')
                ->join('fuel_types', 'fuel_types.id', 'logistic_vehicle_infos.fuel_type_id')
                ->join('vehicle_types', 'vehicle_types.id', 'logistic_vehicle_infos.vehicle_type_id')
                ->join('vehicle_brands', 'vehicle_brands.id', 'logistic_vehicle_infos.vehicle_brand_id')
                ->leftjoin('logistic_driver_infos as ldi', 'ldi.logistic_vehicle_id', 'logistic_vehicle_infos.id')
                ->whereNull('logistic_vehicle_infos.deleted_at')
                ->whereNull('logistic_partners.deleted_at')
                ->whereNull('vehicle_brands.deleted_at')
                ->groupBy('logistic_vehicle_infos.id');

            if (Auth::user()->role_id == RoleTypes::LogisticPartner) {
                $logisticVehicleInfoData->where('logistic_partners.id', Auth::user()->ref_id);
            }

            $logisticVehicleInfoData = $logisticVehicleInfoData->get();
            return datatables()->of($logisticVehicleInfoData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->logistic_vehicle_id == null) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confirm-color' . $row->id . '" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
