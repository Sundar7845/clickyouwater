<?php

namespace App\Http\Controllers\Admin\UserRightsManagement;

use App\Enums\MenuPermissionType;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use App\Models\RolePermission;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserRightsController extends Controller
{
    use Common;
    public function rights()
    {
        try {
            $roles = Role::select('roles.role_name', 'roles.id as role_id')->leftJoin('role_permissions', 'role_permissions.role_id', 'roles.id')
                ->whereNull('role_permissions.id')
                ->whereNotIn('roles.id', [RoleTypes::SuperAdmin, RoleTypes::Customer])
                ->groupBy('roles.id')
                ->get();
            return view('admin.users_rights_management.users_rights', compact('roles'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getMenus()
    {
        try {
            $menus = Menu::where('is_visible', 1)->get();
            return response()->json([
                'menus' => $menus
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function createPermission(Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request->ddlRole != null) {
                $validator = Validator::make($request->all(), [
                    'ddlRole' => [
                        'required',
                        Rule::unique('role_permissions', 'role_id')->ignore($request->hdRole_id, 'role_id')->whereNull('deleted_at'),
                    ],
                ], [
                    'ddlRole.unique' => 'Role already exists.',
                    'ddlRole.required' => 'The role name is required.'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            if ($request->hdPermission_id == null) {
                $createPermission = ([
                    'menu_id' => $request->permission_id,
                    'role_id' => $request->ddlRole,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                RolePermission::create($createPermission);
                $notification = array(
                    'message' => 'Permission Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                RolePermission::findorfail($request->hdPermission_id)->update([
                    'menu_id' => $request->permission_id,
                    'role_id' => $request->hdRole_id,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Permission Updated Successfully',
                    'alert-type' => 'success'
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Permission Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('rights')->with($notification);
    }

    public function deletePermission($id)
    {
        DB::beginTransaction();
        try {
            $permission = RolePermission::findorfail($id);
            $permission->delete();

            $permission->Update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Permission Deleted Successfully',
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
                'message' => 'Permission could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getPermissionById($id)
    {
        try {
            $permission = RolePermission::where('id', $id)->first();
            $role = Role::where('id', $permission->role_id)->get();
            return response()->json([
                'permission' => $permission,
                'role' => $role
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getPermissionData()
    {
        try {
            $permissionData = RolePermission::select(
                'role_permissions.*',
                'roles.role_name'
            )
                ->join('roles', 'roles.id', 'role_permissions.role_id')
                ->where('roles.id', '!=', 1)->get();

            return datatables()->of($permissionData)
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
}
