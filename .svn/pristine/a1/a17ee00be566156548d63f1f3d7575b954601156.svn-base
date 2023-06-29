<?php

namespace App\Http\Controllers\Admin\LogisticManagement;

use App\Enums\MenuPermissionType;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\LogisticDriverInfo;
use App\Models\LogisticPartner;
use App\Models\LogisticsHubConfig;
use App\Models\LogisticVehicleInfo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Common;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LogisticDriverInfoController extends Controller
{
    use common;
    public function LogisticDriverInfo(Request $request)
    {
        try {
            if (Auth::user()->role_id == RoleTypes::LogisticPartner) {
                // $logistic_partner_id = User::select('ref_id')->where('id', Auth::user()->id)->pluck('ref_id')->first();
                $logistic_partner_id = $this->getRefId(Auth::user()->id, RoleTypes::LogisticPartner);
            } else {
                $logistic_partner_id = 0;
            }

            $logisticPartners = LogisticPartner::select('id', 'logistic_partner_name')->where('is_active', 1)->whereNull('deleted_at')->get();
            $hubs = Hub::whereNull('deleted_at')->get();
            //To load list based type(All,Today,ThisMonth)
            $type = $request->input('type');
            return view('admin.logistic_management.add_logistic_driver_info', compact('type', 'logisticPartners', 'hubs', 'logistic_partner_id'));
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addLogisticDriverInfo(Request $request)
    {
        $request->validate([
            Auth::user()->role_id == RoleTypes::LogisticPartner ? 'hdLogisticPartnerId' : 'ddlLogisticPartner' => 'required',
            'ddlLogisticVehicle' => 'required',
            'ddlHub' => 'required',
            'txtDriverName' => 'required',
            'txtLicenseNo' => [
                'required',
                Rule::unique('logistic_driver_infos', 'license_no')->whereNull('deleted_at')->ignore($request->hdLogisticDriverId),
            ],
            'dtLicenseExpiry' => 'required',
            'txtMobileNo' => [
                'required',
                Rule::unique('logistic_driver_infos', 'mobile_no')->whereNull('deleted_at')->ignore($request->hdLogisticDriverId),
            ],
            // 'txtPassword' => 'min:6',
            // 'txtConfirmPassword' => 'required_with:password|same:txtPassword|min:6'
        ], [
            'txtLicenseNo.unique' => 'The License Number Is Already Taken!',
            'txtMobileNo.unique' => 'The Mobile Number Is Already Taken!',
        ]);


        DB::beginTransaction();
        try {

            if ($request->hdLogisticDriverId == null) {
                if ($request->hasFile('fileLicense')) {
                    $file = $request->file('fileLicense');
                    if ($file != null) {
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $this->generateRandom(16) . '.' . $extension;
                    } else {
                        throw new Exception('File is null');
                    }
                }

                $hubIds = $request['ddlHub'];
                $hubIdsArray = [];
                foreach ($hubIds as $hub_id) {
                    $hubIdsArray[] = $hub_id;
                }
                $hub_ids = implode(",", $hubIdsArray);

                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                $logist_partner_id = LogisticDriverInfo::insertGetId([
                    'logistic_partner_id' => $request->ddlLogisticPartner,
                    'logistic_vehicle_id' => $request->ddlLogisticVehicle,
                    'hub_id' => $hub_ids,
                    'driver_name' => $request->txtDriverName,
                    'license_no' => $request->txtLicenseNo,
                    'license_doc_path' => $this->fileUpload($request->file('fileLicense'), 'upload/logistics/Drivers' . $request->hdLogisticDriverId, $fileName),
                    'license_expiry' => $request->dtLicenseExpiry,
                    'mobile_no' => $request->txtMobileNo,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                //Create User Login Account For Driver
                $this->createUser(
                    $request->txtMobileNo,
                    '',
                    $request->txtMobileNo,
                    $logist_partner_id,
                    $request->txtDriverName,
                    $request->txtMobileNo,
                    RoleTypes::Driver,
                    1,
                    Auth::user()->id
                );

                $notification = array(
                    'message' => 'Driver Info Created Successfully!',
                    'alert-type' => 'success'
                );
            } else {
                $oldImage = $request->hdFileLicense;
                if ($request->hasFile('fileLicense')) {
                    $file = $request->file('fileLicense');
                    if ($file != null) {
                        @unlink($oldImage);
                        $extension = $file->getClientOriginalExtension();
                        $fileName = $this->generateRandom(16) . '.' . $extension;
                    } else {
                        throw new Exception('File is null');
                    }
                }

                $hubIds = $request['ddlHub'];
                $hubIdsArray = [];
                foreach ($hubIds as $hub_id) {
                    $hubIdsArray[] = $hub_id;
                }
                $hub_ids = implode(",", $hubIdsArray);
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                LogisticDriverInfo::findorfail($request->hdLogisticDriverId)->update([
                    'logistic_partner_id' => $request->ddlLogisticPartner,
                    'logistic_vehicle_id' => $request->ddlLogisticVehicle,
                    'hub_id' => $hub_ids,
                    'driver_name' => $request->txtDriverName,
                    'license_no' => $request->txtLicenseNo,
                    'license_doc_path' => $request->hasFile('fileLicense') ? $this->fileUpload($file, 'upload/logistics/Drivers' . $request->hdLogisticDriverId, $fileName) : $oldImage,
                    'license_expiry' => $request->dtLicenseExpiry,
                    'mobile_no' => $request->txtMobileNo,
                    'updated_by' => Auth::user()->id
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');

                //Update User Login Account For Driver
                $this->updateUser(
                    $request->txtMobileNo,
                    '',
                    $request->txtMobileNo,
                    $request->hdLogisticDriverId,
                    $request->txtDriverName,
                    $request->txtMobileNo,
                    RoleTypes::Driver,
                    1,
                    Auth::user()->id
                );

                $notification = array(
                    'message' => 'Driver Info Updated Successfully!',
                    'alert-type' => 'success'
                );
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Driver Info Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        $authLogisticPartner = Auth::user()->role_id == RoleTypes::LogisticPartner ? 'drivers' : 'logisticDriverInfo';
        return redirect()->route($authLogisticPartner)->with($notification);
    }

    //Change Active Status
    public function activeStatus($id, $status)
    {
        DB::beginTransaction();
        try {
            LogisticDriverInfo::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
            //In active user account
            if ($status == 0) {
                $this->inactiveUser($id, RoleTypes::Driver);
            } else {
                $this->activeUser($id, RoleTypes::Driver);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deletLogisticDriverInfo($id)
    {
        DB::beginTransaction();
        try {
            $logisticDriverInfo = LogisticDriverInfo::findorfail($id);
            $logisticDriverInfo->delete();
            $logisticDriverInfo->Update([
                'deleted_by' => Auth::user()->id
            ]);

            //In activate user
            $this->inactiveUser($id, RoleTypes::Driver);

            $notification = array(
                'message' => 'Driver Info Deleted Successfully!',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Driver Info Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getLogisticDriverInfoById($id)
    {
        try {
            $logisticDriverInfo = LogisticDriverInfo::where('id', $id)->whereNull('deleted_at')->first();
            return response()->json([
                'logisticDriverInfo' => $logisticDriverInfo
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    private function getDistinctLogisticVehicles()
    {

        $logisticVehicles = LogisticDriverInfo::join('logistic_partners', 'logistic_partners.id', 'logistic_driver_infos.logistic_partner_id')
            ->pluck('logistic_driver_infos.logistic_vehicle_id')
            ->whereNull('deleted_at')
            ->toArray();

        return $logisticVehicles;
    }

    public function getLogisticVehicleById(Request $request, $logistic_id)
    {
        try {

            if ($request->driver_id) {
                $vehicles = LogisticVehicleInfo::where('logistic_partner_id', $logistic_id)
                    ->whereNotIn('id', $this->getDistinctLogisticVehicles())
                    ->pluck('id')->toArray();
                $edit_vehicle_id = LogisticDriverInfo::where('id', $request->driver_id)->pluck('logistic_vehicle_id')->toArray();
                $vehicle = array_merge($vehicles, $edit_vehicle_id);

                $logisticVehicle = LogisticVehicleInfo::where('logistic_partner_id', $logistic_id)
                    ->whereIn('id', $vehicle)
                    ->whereNull('deleted_at')
                    ->get();
            } else {
                $vehicles = $this->getDistinctLogisticVehicles();
                $logisticVehicle = LogisticVehicleInfo::where('logistic_partner_id', $logistic_id)
                    ->whereNotIn('id', $vehicles)
                    ->whereNull('deleted_at')
                    ->get();
            }

            return response()->json([
                'logisticVehicle' => $logisticVehicle
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getHubsByLogisticId(Request $request, $logistic_id)
    {
        try {
            $allocated_hub_ids = LogisticsHubConfig::where('logistic_partner_id', $logistic_id)->pluck('hub_id')->toArray();

            $allocated_hubs = LogisticDriverInfo::where('logistic_partner_id', $logistic_id)->pluck('hub_id')->first();
            $allocated_hubs = explode(',', $allocated_hubs);
            $split_hub_ids = [];

            foreach ($allocated_hubs as $hub_id) {
                $split_hub_ids = array((int)$hub_id);
            }

            if ($split_hub_ids) {
                $allocated_hub_ids = array_diff($allocated_hub_ids, $split_hub_ids);
            }

            if ($request->driver_id) {
                $drivers_hub_id = LogisticDriverInfo::select('hub_id')->where('id', $request->driver_id)->get()->toArray();
                $edit_driver_id = explode(',', $drivers_hub_id[0]['hub_id']);
                $hub = array_merge($allocated_hub_ids, $edit_driver_id);

                $hubs = Hub::select('hubs.*')
                    ->whereNull('deleted_at')
                    ->whereIn('id', $hub)
                    ->get();
            } else {
                $hubs = Hub::select('hubs.*')
                    ->whereNull('deleted_at')
                    ->whereIn('hubs.id', $allocated_hub_ids)
                    ->get();
            }

            return response()->json([
                'hubs' => $hubs
            ]);
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getLogisticDriverInfoData(Request $request)
    {
        try {
            $logisticDriverInfoData = LogisticDriverInfo::select(
                'logistic_driver_infos.*',
                'logistic_partners.logistic_partner_name',
                'logistic_vehicle_infos.reg_no',
                'hubs.hub_name',
                DB::raw("DATE_FORMAT(logistic_driver_infos.license_expiry, '%d/%m/%Y') as formatted_license_expiry")
            )
                ->join('logistic_partners', 'logistic_partners.id', 'logistic_driver_infos.logistic_partner_id')
                ->join('logistic_vehicle_infos', 'logistic_vehicle_infos.id', 'logistic_driver_infos.logistic_vehicle_id')
                ->join('hubs', 'hubs.id', 'logistic_driver_infos.hub_id')
                ->whereNull('logistic_driver_infos.deleted_at')
                ->whereNull('logistic_partners.deleted_at');

            if (Auth::user()->role_id == RoleTypes::LogisticPartner) {
                $logisticDriverInfoData->where('logistic_partners.id', Auth::user()->ref_id);
            }
            // Apply type filters based on the 'type' parameter
            if ($request->type === 'today') {
                $logisticDriverInfoData->whereDate('logistic_driver_infos.created_at', today());
            } elseif ($request->type === 'thismonth') {
                $logisticDriverInfoData->whereMonth('logistic_driver_infos.created_at', now()->month);
            }

            $logisticDriverInfoData = $logisticDriverInfoData->get();

            return datatables()->of($logisticDriverInfoData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    // if ($this->isUserHavePermission(MenuPermissionType::Delete)) {
                    //     $html .= '<i class="text-danger ti ti-trash me-1" id="confirm-color' . $row->id . '" onclick="showDelete(' . $row->id . ');"></i>';
                    // }
                    return $html;
                })->toJson();
        } catch (Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
