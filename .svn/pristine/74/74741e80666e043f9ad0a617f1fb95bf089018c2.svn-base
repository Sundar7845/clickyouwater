<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\ExpenseGroup;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ExpenseGroupController extends Controller
{
  use Common;
  public function expenseGroup()
  {
    return view('admin.masters.expense_group.expense_group');
  }

  public function addExpenseGroup(Request $request)
  {
    $request->validate([
      'txtExpense' => [
        'required',
        Rule::unique('expense_groups', 'expensegroup_name')->whereNull('deleted_at')->ignore($request->hdExpensegroupId),
      ],
    ], [
      'txtExpense.unique' => 'Expense group name already exists.',
    ]);

    DB::beginTransaction();
    try {

      if ($request->hdExpensegroupId == null) {
        ExpenseGroup::create([
          'expensegroup_name' => $request->txtExpense,
          'created_by' => Auth::user()->id,
          'created_at' => Carbon::now()
        ]);

        $notification = array(
          'message' => 'Expense Group Created Successfully',
          'alert-type' => 'success'
        );
      } else {
        ExpenseGroup::findorfail($request->hdExpensegroupId)->update([
          'expensegroup_name' => $request->txtExpense,
          'updated_by' => Auth::user()->id
        ]);

        $notification = array(
          'message' => 'Expense Group Updated Successfully',
          'alert-type' => 'success'
        );
      }
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      $notification = array(
        'message' => 'Expense Group Not Created!',
        'alert-type' => 'error'
      );
      $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
    }
    return redirect()->route('expensegroup')->with($notification);
  }

  public function getExpenseGroupdata()
  {
    try {
      $expensegroupdata = ExpenseGroup::select('expense_groups.*', 'expenses.expensegroup_id')
        ->leftJoin('expenses', 'expenses.expensegroup_id', 'expense_groups.id')
        ->whereNull('deleted_at')
        ->groupBy('expense_groups.id')
        ->get();

      return datatables()->of($expensegroupdata)
        ->addColumn('action', function ($row) {
          $html = "";
          if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
            $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
          }
          if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->expensegroup_id == null) {
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
    DB::beginTransaction();
    try {
      ExpenseGroup::findorfail($id)->update([
        'is_active' => $status,
        'updated_by' => Auth::user()->id
      ]);
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function getExpensegroupById($id)
  {
    try {
      $expensegroup = ExpenseGroup::select('expense_groups.*')->where('expense_groups.id', $id)->first();
      return response()->json([
        'expensegroup' => $expensegroup
      ]);
    } catch (\Exception $e) {
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
    }
  }

  public function deleteExpensegroup($id)
  {
    DB::beginTransaction();
    try {
      $expensegroup = ExpenseGroup::findorfail($id);
      $expensegroup->delete();
      $expensegroup->update([
        'deleted_by' => Auth::user()->id
      ]);

      $notification = array(
        'message' => 'Expense Group Deleted Successfully',
        'alert' => 'success'
      );
      DB::commit();
      return response()->json([
        'responseData' => $notification
      ]);
    } catch (\Exception $e) {
      DB::rollBack();
      $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
      $notification = array(
        'message' => 'Expense Group Could Not Be Deleted!',
        'alert' => 'error'
      );
      return response()->json([
        'responseData' => $notification
      ]);
    }
  }
}
