<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\AdminSettings;
use App\Models\GeoApiSettings;
use App\Models\PaymentGatewaySettings;
use App\Models\PaymentMethod;
use App\Models\SmsSettings;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class AdminSettingsController extends Controller
{
    use Common;
    public function AdminSettings()
    {
        try {
            $adminsettings = AdminSettings::first();
            if (!$adminsettings) {
                $adminsettings = new AdminSettings();
            }            
            $smssettings = SmsSettings::first();
            $geoapisettings = GeoApiSettings::first();
            $paymentgateway = PaymentGatewaySettings::first();
            $paymentmethodCashondelivery = PaymentMethod::where('id', 2)->first();
            $paymentmethodRazorpay = PaymentMethod::where('id', 1)->first();
            // Retrieve the JSON data from the database table
            $jsonDatarazorpay = PaymentGatewaySettings::where('payment_method_id', 1)->pluck('value');
            // Loop through each row of JSON data and decode it
            $decodedDatarazorpay = $jsonDatarazorpay->map(function ($item, $key) {
                return json_decode($item);
            });
            // Retrieve the JSON data from the database table
            $jsonDatacashondelivery = PaymentGatewaySettings::where('payment_method_id', 2)->pluck('value');
            // Loop through each row of JSON data and decode it
            $decodedDatacashondelivery = $jsonDatacashondelivery->map(function ($item, $key) {
                return json_decode($item);
            });
            return view('admin.settings.admin_settings', compact(
                'adminsettings',
                'smssettings',
                'geoapisettings',
                'paymentgateway',
                'paymentmethodCashondelivery',
                'paymentmethodRazorpay',
                'decodedDatacashondelivery',
                'decodedDatarazorpay'
            ));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function AdminSettingsCreate(Request $request)
    {
        DB::beginTransaction();
        $request->validate([
            // 'otp_length'                      =>  'required',
            // 'otp_expiry_duration'             =>  'required',
            // 'additional_delivery_charge'      =>  'required',
            // 'referral_code_length'            =>  'required',
            // 'is_maintenace_mode'              =>  'required',
            // 'company_name'                    =>  'required',
            // 'company_address'                 =>  'required',
            // 'company_contactno'               =>  'required',
            // 'company_email'                   =>  'required',
            // 'privacy_policy_url'              =>  'required',
            // 'terms_conditions_url'            =>  'required',
            // 'company_website'                 =>  'required',
            // 'company_logo'                    =>  'required',
            // 'app_logo'                        =>  'required',
            // 'order_cancel_threshold_duration' =>  'required',
            // 'manufacture_order_delay'         =>  'required'
        ]);
        try {
            $fillable = $request->all();
            unset($fillable['_token']);
            unset($fillable['hdAdmin_logo']);
            unset($fillable['hdApp_logo']);
            if ($request->id == null) {
                AdminSettings::insertGetId($fillable);
                $notification = array(
                    'message' => 'Admin settings Created Successfully!',
                    'alert-type' => 'success'
                );
            } else {
                unset($fillable['_token']);
                unset($fillable['id']);
                AdminSettings::where('id', $request->id)->update($fillable);
                $notification = array(
                    'message' => 'Admin settings Updated Successfully!',
                    'alert-type' => 'success'
                );
            }

            $oldImage = $request->hdAdmin_logo;
            $oldAppImage = $request->hdApp_logo;
            if ($request->hasFile('company_logo')) {
                $file = $request->file('company_logo');
                if ($file != null) {
                    @unlink($oldImage);
                }
                $extension = $file->getClientOriginalExtension();
                $fileName = $this->generateRandom(16) . '.' . $extension;
            }
            if ($request->hasFile('app_logo')) {
                $appfile = $request->file('app_logo');
                if ($appfile != null) {
                    @unlink($oldImage);
                }
                $extension = $file->getClientOriginalExtension();
                $AppfileName = $this->generateRandom(16) . '.' . $extension;
            }
            AdminSettings::where('id', $request->id)->update([
                'company_logo' => $request->hasFile('company_logo') == true ? $this->fileUpload($request->file('company_logo'), 'upload/settings/admin', $fileName) : $oldImage,
                'app_logo' => $request->hasFile('app_logo') == true ? $this->fileUpload($request->file('app_logo'), 'upload/settings/admin', $AppfileName) : $oldAppImage,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'AdminSettings Not Updated!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('adminsettings')->with($notification);
    }

    public function SmsSettingsCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $fillable = $request->all();
            unset($fillable['_token']);
            if ($request->id == "new") {
                SmsSettings::create($fillable);
                $notification = array(
                    'message' => 'SmsSettings Created Successfully!',
                    'alert-type' => 'success'
                );
            } else {
                unset($fillable['_token']);
                unset($fillable['id']);

                SmsSettings::where('id', $request->id)->update($fillable);
                $notification = array(
                    'message' => 'SmsSettings Updated Successfully!',
                    'alert-type' => 'success'
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'SmsSettings Not Updated!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('adminsettings')->with($notification);
    }

    public function GeoApiSettingsCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $fillable = $request->all();
            unset($fillable['_token']);
            if ($request->id == "new") {
                GeoApiSettings::create($fillable);
                $notification = array(
                    'message' => 'GeoApiSettings Created Successfully!',
                    'alert-type' => 'success'
                );
            } else {
                unset($fillable['_token']);
                unset($fillable['id']);
                GeoApiSettings::where('id', $request->id)->update($fillable);
                $notification = array(
                    'message' => 'GeoApiSettings Updated Successfully!',
                    'alert-type' => 'success'
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'GeoApiSettings Not Updated!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('adminsettings')->with($notification);
    }

    public function PaymentGatewayCashonDeliveryCreate(Request $request, $paymentmethodid)
    {
        DB::beginTransaction();
        try {
            if ($paymentmethodid == 2) {
                $payment = PaymentGatewaySettings::where('payment_method_id', 2)->first();
                if (isset($payment) == false) {
                    PaymentGatewaySettings::create([
                        'payment_method_id' => $request->hdpaymentMethodid,
                        'value' => json_encode([
                            'status' => $request['rdcashondelivery'],
                        ]),
                    ]);
                    $notification = array(
                        'message' => 'Payment Gateway Created Successfully!',
                        'alert-type' => 'success'
                    );
                } else {
                    PaymentGatewaySettings::where('payment_method_id', 2)->update([
                        'payment_method_id' => $request->hdpaymentMethodid,
                        'value' => json_encode([
                            'status' => $request['rdcashondelivery'],
                        ]),
                    ]);
                    $notification = array(
                        'message' => 'Payment Gateway Updated Successfully!',
                        'alert-type' => 'success'
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Payment Gateway Settings Cash On Delivery Not Updated!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('adminsettings')->with($notification);
    }

    public function PaymentGatewayRazorpayCreate(Request $request, $paymentmethodid)
    {
        DB::beginTransaction();
        try {

            if ($paymentmethodid == 1) {
                $payment = PaymentGatewaySettings::where('payment_method_id', 1)->first();
                if ($payment == false) {
                    PaymentGatewaySettings::create([
                        'payment_method_id' => $request->hdpaymentMethodid,
                        'value' => json_encode([
                            'status' => $request['rdrazorpay'],
                            'razor_key' => $request['txtrazorpayid'],
                            'razor_secret' => $request['txtrazorpaykey'],
                        ]),
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now()
                    ]);
                    $notification = array(
                        'message' => 'Payment Gateway Created Successfully!',
                        'alert-type' => 'success'
                    );
                } else {
                    PaymentGatewaySettings::where('payment_method_id', 1)->update([
                        'payment_method_id' => $request->hdpaymentMethodid,
                        'value' => json_encode([
                            'status' => $request['rdrazorpay'],
                            'razor_key' => $request['txtrazorpayid'],
                            'razor_secret' => $request['txtrazorpaykey'],
                        ]),
                        'updated_by' => Auth::user()->id,
                    ]);
                    $notification = array(
                        'message' => 'Payment Gateway Updated Successfully!',
                        'alert-type' => 'success'
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Payment Gateway Settings RazorPay Not Updated!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('adminsettings')->with($notification);
    }

    public function activeMaintenancemode($id, $status)
    {
        try {
            AdminSettings::findorfail($id)->update([
                'is_maintenace_mode' => $status,
                'updated_by' => Auth::user()->id
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
