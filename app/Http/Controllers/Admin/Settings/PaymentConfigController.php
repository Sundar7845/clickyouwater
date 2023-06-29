<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\CustomerType;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodConfig;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentConfigController extends Controller
{
    use Common;
    public function PaymentMethod()
    {
        $paymentMethods = PaymentMethod::get();
        $customerTypes = CustomerType::get();
        return view('admin.masters.payment_methods.payment_methods', compact('customerTypes', 'paymentMethods'));
    }

    public function addPaymentMethod(Request $request)
    {
        $request->validate([
            'ddlCustomerType' => 'required',
            'ddlPaymentMethod' => 'required'
        ]);
        DB::beginTransaction();
        try {

            $data = $request->all();

            if ($request->hdPaymentMethodId == null) {

                $paymentMethods = $data['ddlPaymentMethod'];
                $paymentMethodsArray = [];
                foreach ($paymentMethods as $method) {
                    $paymentMethodsArray[] = $method;
                }
                $paymentMethodIds = implode(",", $paymentMethodsArray);
                $paymentMethods = PaymentMethodConfig::where('customer_type_id', $request->ddlCustomerType)->exists();
                if (!$paymentMethods) {
                    PaymentMethodConfig::create([
                        'customer_type_id' => $request->ddlCustomerType,
                        'payment_method_id' => $paymentMethodIds,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now()
                    ]);
                    $notification = array(
                        'message' => 'Payment Method Created Successfully',
                        'alert-type' => 'success'
                    );
                } else {

                    $notification = array(
                        'message' => 'Payment Method Already Exit',
                        'alert-type' => 'error'
                    );
                }
            } else {

                $paymentMethods = $data['ddlPaymentMethod'];
                $paymentMethodsArray = [];
                foreach ($paymentMethods as $method) {
                    $paymentMethodsArray[] = $method;
                }
                $paymentMethodsString = implode(",", $paymentMethodsArray);

                PaymentMethodConfig::where('customer_type_id', $request->ddlCustomerType)
                    ->update([
                        'payment_method_id' => $paymentMethodsString
                    ]);

                $notification = array(
                    'message' => 'Payment Method Updated Successfully',
                    'alert-type' => 'success'
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Payment Method Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }

        return redirect()->route('paymentmethod')->with($notification);
    }


    public function getPaymentMethodById($id)
    {
        try {
            $PaymentMethod = PaymentMethodConfig::where('id', $id)->first();
            return response()->json([
                'PaymentMethod' => $PaymentMethod
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deletePaymentMethod($id)
    {
        DB::beginTransaction();
        try {
            $paymentMethod = PaymentMethodConfig::findorfail($id);
            $paymentMethod->delete();

            $paymentMethod->Update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Payment Method Deleted Successfully',
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
                'message' => 'Payment Method Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }


    public function getPaymentMethodData()
    {
        try {
            $paymentMethodData = PaymentMethodConfig::select('payment_method_configs.*', 'customer_types.customer_type', 'payment_methods.payment_method')->join('payment_methods', 'payment_methods.id', 'payment_method_configs.payment_method_id')->join('customer_types', 'customer_types.id', 'payment_method_configs.customer_type_id')->get();
            return datatables()->of($paymentMethodData)
                ->addColumn('action', function ($row) {
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete)) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confirm-color' . $row->id . '" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}