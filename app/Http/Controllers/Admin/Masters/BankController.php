<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BankController extends Controller
{
    use Common;
    public function Banks()
    {

        return view('admin.masters.bank.bank');
    }

    public function addBank(Request $request)
    {

        $request->validate([

            'txtBankName' => [
                'required',
                Rule::unique('banks', 'bank_name')->WhereNull('deleted_at')->ignore($request->hdBankId)
            ]
        ], [
            'txtBankName.unique' => 'This bank name has already been taken.'
        ]);

        try {

            if ($request->hdBankId == null) {
                Bank::create([
                    'bank_name' => $request->txtBankName,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);

                $notification = array(
                    'message' => 'Bank Name Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                Bank::findorfail($request->hdBankId)->update([
                    'bank_name' => $request->txtBankName,
                    'updated_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Bank Name Updated Successfully',
                    'alert-type' => 'success'
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Bank Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('bank')->with($notification);
    }

    public function getBankData()
    {
        try {
            $bankData = Bank::select('banks.*', 'payments.bank_id')
                ->leftJoin('payments', 'payments.bank_id', 'banks.id')
                ->whereNull('banks.deleted_at')
                ->groupBy('banks.id')
                ->get();
            return datatables()->of($bankData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->bank_id == null) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getBankById($id)
    {
        try {
            $bank = Bank::select('banks.*')->where('banks.id', $id)->whereNull('deleted_at')->first();
            return response()->json([
                'bank' => $bank
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteBank($id)
    {
        DB::beginTransaction();
        try {
            $bank = Bank::findorfail($id);
            $bank->delete();
            $bank->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Bank Name Deleted Successfully',
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
                'message' => 'Bank Name Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }
}
