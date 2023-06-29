<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reasons;
use App\Traits\Common;
use App\Models\ReasonType;
use App\Enums\MenuPermissionType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ReasonController extends Controller
{
    use Common;
    public function Reasons()
    {
        try {
            $resontypes = ReasonType::get();
            return view('admin.masters.reasons.reasons', compact('resontypes'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addReasons(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ddlreasonType' => [
                'required',
                Rule::unique('reasons', 'reason_type_id')
                    ->where(function ($query) use ($request) {
                        return $query->where('reason', $request->txtReson);
                    })
                    ->whereNull('deleted_at')
                    ->ignore($request->hdReasonId, 'id')
            ],
            'txtReson' => [
                'required',
                Rule::unique('reasons', 'reason')
                    ->where(function ($query) use ($request) {
                        return $query->where('reason_type_id', $request->ddlreasonType);
                    })
                    ->whereNull('deleted_at')
                    ->ignore($request->hdReasonId, 'id')
            ],
        ], [
            'ddlreasonType.unique' => 'Reason Type already exists.',
            'txtReson.unique' => 'Reason already exists.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            if ($request->hdReasonId == null) {
                Reasons::create([
                    'reason_type_id' => $request->ddlreasonType,
                    'reason' => $request->txtReson,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);

                $notification = array(
                    'message' => 'Reasons Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                Reasons::findorfail($request->hdReasonId)->update([
                    'reason_type_id' => $request->ddlreasonType,
                    'reason' => $request->txtReson,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now()
                ]);

                $notification = array(
                    'message' => 'Reasons Updated Successfully',
                    'alert-type' => 'success'
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
            $notification = array(
                'message' => 'Reasons Not Created!',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }

    public function getReasonsdata()
    {
        try {
            $reasons = Reasons::select('reasons.*', 'reason_types.reason_type', 'surrenders.reason_id')
                ->join('reason_types', 'reason_types.id', 'reasons.reason_type_id')
                ->leftJoin('surrenders', 'surrenders.reason_id', 'reasons.id')
                ->whereNull('deleted_at')
                ->groupBy('reasons.id')
                ->get();
            return datatables()->of($reasons)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    // if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->reason_id == null) {
                    //     $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"></i>';
                    // }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getReasonsById($id)
    {
        try {
            $reasons = Reasons::select('reasons.*', 'reason_types.reason_type')
                ->join('reason_types', 'reason_types.id', 'reasons.reason_type_id')
                ->where('reasons.id', $id)
                ->first();

            if ($reasons) {
                return response()->json([
                    'reasons' => $reasons
                ]);
            } else {
                return response()->json([
                    'message' => 'Reasons not found'
                ], 404);
            }
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            return response()->json([
                'message' => 'An error occurred'
            ], 500);
        }
    }

    public function deleteReasons($id)
    {
        DB::beginTransaction();
        try {
            $reasons = Reasons::findorfail($id);
            $reasons->delete();
            $reasons->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Reasons Deleted Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            DB::rollBack();
            $notification = array(
                'message' => 'Reasons  Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }
}
