<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    use Common;
    public function department()
    {
        try {
            return view('admin.masters.department.department');
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addDepartment(Request $request)
    {
        $request->validate([
            'txtDepartmentName' => [
                'required',
                Rule::unique('departments', 'department_name')->WhereNull('deleted_at')->ignore($request->hdDepartmentId),
            ],
        ], [
            'txtDepartmentName.unique' => 'Department name already exists.'
        ]);

        try {
            if ($request->hdDepartmentId == null) {

                Department::create([
                    'department_name' => $request->txtDepartmentName,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);

                $notification = array(
                    'message' => 'Department Created Successfully',
                    'alert-type' => 'success'
                );
            } else {

                Department::findorfail($request->hdDepartmentId)->update([
                    'department_name' => $request->txtDepartmentName,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Department Updated Successfully',
                    'alert-type' => 'success'
                );
            }
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Department Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('department')->with($notification);
    }

    public function deleteDepartment($id)
    {
        DB::beginTransaction();
        try {
            $department = Department::findorfail($id);
            $department->delete();
            $department->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Department Deleted Successfully',
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
                'message' => 'Department Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getDepartmentById($id)
    {
        try {
            $department = Department::select('departments.*')->where('departments.id', $id)->whereNull('deleted_at')->first();
            return response()->json([
                'department' => $department
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getDepartmentData()
    {
        try {
            $departmentData = Department::select('departments.*', 'employees.department_id')
                ->leftJoin('employees', 'employees.department_id', 'departments.id')
                ->whereNull('departments.deleted_at')
                ->whereNull('employees.deleted_at')
                ->groupBy('departments.id')
                ->get();
            return datatables()->of($departmentData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                    onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->department_id == null) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function activeStatus($id, $status)
    {
        try {
            Department::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}