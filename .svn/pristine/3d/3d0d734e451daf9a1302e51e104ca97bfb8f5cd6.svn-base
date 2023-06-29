<?php

namespace App\Http\Controllers\Admin\UserRightsManagement;

use App\Enums\MenuPermissionType;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\DeliveryPerson;
use App\Models\Employee;
use App\Models\Hub;
use App\Models\LogisticDriverInfo;
use App\Models\LogisticPartner;
use App\Models\Manufacturer;
use App\Models\Menu;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRolePermission;
use App\Traits\Common;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use Common;
    public function users()
    {
        try {
            $roles = RolePermission::select('role_permissions.*', 'roles.role_name', 'roles.id as role_id')->join('roles', 'roles.id', 'role_permissions.role_id')->where('roles.id', '!=', 1)->whereNull('role_permissions.deleted_at')->get();
            return view('admin.users_rights_management.users', compact('roles'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function createUser(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hdUserId == null) {

                $user_id = $request->hdUserId;
                $fileds = $request['menuId'];
                $menuPermissionData = [];
                for ($i = 0; $i < count($request['menuId']); $i++) {

                    $row = $fileds[$i];
                    $menuPermissionData['user_id'] = $user_id;
                    $menuPermissionData['menu_id'] = $row;
                    $menuPermissionData['is_edit'] = $request['checkEdit'][$row][0] ?? 0;
                    $menuPermissionData['is_delete'] = $request['checkDelete'][$row][0] ?? 0;
                    $menuPermissionData['is_view'] = $request['checkView'][$row][0] ?? 0;
                    $menuPermissionData['is_print'] = $request['checkPrint'][$row][0] ?? 0;
                    $menuPermissionData['is_approval'] = $request['checkApproval'][$row][0] ?? 0;
                    $menuPermissionData['created_by'] =  Auth::user()->id;
                    $menuPermissionData['updated_by'] =  Auth::user()->id;

                    $dd = UserRolePermission::create($menuPermissionData);
                }

                $notification = array(
                    'message' => 'User Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                UserRolePermission::where('user_id', $request->hdUserId)->delete();
                $user_id = $request->hdUserId;
                $fileds = $request['menuId'];
                $menuPermissionData = [];
                for ($i = 0; $i < count($request['menuId']); $i++) {

                    $row = $fileds[$i];
                    $menuPermissionData['user_id'] = $user_id;
                    $menuPermissionData['menu_id'] = $row;
                    $menuPermissionData['is_edit'] = $request['checkEdit'][$row][0] ?? 0;
                    $menuPermissionData['is_delete'] = $request['checkDelete'][$row][0] ?? 0;
                    $menuPermissionData['is_view'] = $request['checkView'][$row][0] ?? 0;
                    $menuPermissionData['is_print'] = $request['checkPrint'][$row][0] ?? 0;
                    $menuPermissionData['is_approval'] = $request['checkApproval'][$row][0] ?? 0;
                    $menuPermissionData['created_by'] =  Auth::user()->id;
                    $menuPermissionData['updated_by'] =  Auth::user()->id;

                    $create = UserRolePermission::create($menuPermissionData);
                }

                $notification = array(
                    'message' => 'User Updated Successfully',
                    'alert-type' => 'success'
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'User Not Updated!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('users')->with($notification);
    }

    public function listMenus($id)
    {
        try {
            $getMenuId = RolePermission::select('menu_id')->where('role_id', '=', $id)->get()->toArray();
            $getMenuName = explode(',', $getMenuId[0]['menu_id']);
            $menu = Menu::where('is_visible', 1)->whereIn('id', $getMenuName)->get();
            return response()->json([
                'menu' => $menu
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getUserPermissionData()
    {
        try {
            $userRoleData = User::select('users.*', 'roles.role_name')
                ->join('roles', 'roles.id', 'users.role_id')
                ->where('users.id', '!=', 1)
                ->where('users.role_id', '!=', RoleTypes::Customer)
                ->whereNull('users.deleted_at')->get();
            return datatables()->of($userRoleData)
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
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getUserPermissionById($id)
    {
        try {
            $userPermission = User::select('users.*', 'roles.role_name')->join('roles', 'roles.id', 'users.role_id')
                ->where('users.id', '!=', 1)->where('users.id', $id)->whereNull('users.deleted_at')->first();

            $userMenuPermission = UserRolePermission::where('user_id', $id)->get();

            return response()->json([
                'userPermission' => $userPermission,
                'userMenuPermission' => $userMenuPermission
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function activeStatus($id, $status)
    {
        DB::beginTransaction();
        try {
            User::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
            $user = User::find($id);
            switch ($user->role_id) {
                case RoleTypes::Manufacturer:
                    Manufacturer::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::Hub:
                    Hub::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::LogisticPartner:
                    LogisticPartner::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::Driver:
                    LogisticDriverInfo::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::DeliveryPerson:
                    DeliveryPerson::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::Admin:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::RegionalManager:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::AreaManager:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::SalesHead:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::FinanceHead:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::AccountsHead:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::Accounts:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::ManufacturerIncharge:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::HubIncharge:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::LogisticsIncharge:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
                case RoleTypes::BackOfficeSupport:
                    Employee::where('id', $user->ref_id)->update([
                        'is_active' => $status
                    ]);
                    break;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteUserPermission($id)
    {
        DB::beginTransaction();
        try {
            $permission = User::findorfail($id);
            $permission->delete();

            $permission->Update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'User Deleted Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'User could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function checkMobileNumber(Request $request)
    {
        try {
            $mobileNumber = $request->mobile_number;
            $roleId = $request->role_id;
            $refId = $request->ref_id;

            if ($refId > 0) {
                $user = User::where('mobile', $mobileNumber)
                    // ->where('role_id', $roleId)
                    ->whereNotIn('ref_id', [$refId])
                    ->pluck('mobile')->first();
            } else {
                $user = User::where('mobile', $mobileNumber)
                    // ->where('role_id', $roleId)
                    ->pluck('mobile')->first();
            }
            if ($user) {
                // Mobile number already exists
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mobile number already exists.',
                ]);
            }
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
