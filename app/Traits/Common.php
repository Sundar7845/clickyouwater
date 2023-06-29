<?php

namespace App\Traits;

use App\Enums\DocumentModulesType;
use App\Enums\MenuPermissionType;
use App\Enums\NotificationStrReplace;
use App\Enums\NotificationTypes;
use App\Enums\ProductType;
use App\Enums\RoleTypes;
use App\Enums\StatusTypes;
use App\Enums\WalletTransactionType;
use App\Enums\WalletTransactionTypes;
use App\Http\Controllers\Notification\PushNotificationController;
use App\Http\Resources\OrderDetailsResource;
use App\Http\Resources\UserAddressResource;
use App\Models\AdminSettings;
use App\Models\Area;
use App\Models\BillNoSetting;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerNearestHub;
use App\Models\CustomerStock;
use App\Models\DeliveryPeopleDocuments;
use App\Models\DeliveryPerson;
use App\Models\DeliveryPersonStock;
use App\Models\DocumentConfig;
use App\Models\DocumentModules;
use App\Models\EmployeeDocuments;
use App\Models\GeoApiSettings;
use App\Models\Hub;
use App\Models\HubDocuments;
use App\Models\HubManufactureConfig;
use App\Models\Ledger;
use App\Models\Log;
use App\Models\LogisticBooking;
use App\Models\LogisticDriverInfo;
use App\Models\LogisticPartner;
use App\Models\LogisticPartnerDocuments;
use App\Models\LogisticsHubConfig;
use App\Models\LogisticTrip;
use App\Models\Manufacturer;
use App\Models\ManufacturerDocuments;
use App\Models\ManufactureStock;
use App\Models\Menu;
use App\Models\NotificationConfig;
use App\Models\NotificationTypeVariables;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\OrderDet;
use App\Models\OrderTracking;
use App\Models\PaymentGatewaySettings;
use App\Models\Products;
use App\Models\RefferalSettings;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\SmsSettings;
use App\Models\State;
use App\Models\Surrender;
use App\Models\SurrenderHistory;
use App\Models\User;
use App\Models\UserDepositHistory;
use App\Models\UserNotifications;
use App\Models\UserOrderHistory;
use App\Models\UserReferralHistory;
use App\Models\UserRolePermission;
use App\Models\UserWallet;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Type\Integer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\File;
use Razorpay\Api\Api;

trait Common
{
    private $recordsperpage = 10;
    public $errorMessage = "Something went wrong!. Please try again.";
    public function getBaseUrl()
    {
        return url('/');
    }
    public function getAdminSetting()
    {
        return AdminSettings::first();
    }
    public function getReferralSetting()
    {
        return RefferalSettings::first();
    }
    public function getPaymentGatewaySettings($payment_method_id)
    {
        $paymentgateways = PaymentGatewaySettings::where('payment_method_id', $payment_method_id)
            ->value('value');
        $payment_settings_value = json_decode($paymentgateways);
        return $payment_settings_value;
    }

    public function getRefId($user_id, $role_id)
    {
        return User::where('id', $user_id)->where('role_id', $role_id)->pluck('ref_id')->first();
    }
    public function getUserId($ref_id, $role_id)
    {
        return User::where('ref_id', $ref_id)->where('role_id', $role_id)->pluck('id')->first();
    }

    public function inactiveUser($id, $role_id)
    {
        User::where('ref_id', $id)->where('role_id', $role_id)->update([
            'is_active' => 0
        ]);
    }
    public function activeUser($id, $role_id)
    {
        User::where('ref_id', $id)->where('role_id', $role_id)->update([
            'is_active' => 1
        ]);
    }
    public function sendSMS($mobile, $msg, $tempid)
    {
        $smsdetails = $this->getSmsDetails();

        $url = $smsdetails->api_url;

        // Set SMSIntegra API parameters
        $params = [
            'uid' => $smsdetails->uid,
            'pwd' => $smsdetails->pwd,
            'mobile' => $mobile,
            'msg' => $msg,
            'sid' => $smsdetails->senderid,
            'type' => 0,
            'dtTimeNow' => date('Y-m-d H:i:s'),
            'entityid' => $smsdetails->entityid,
            'tempid' => $tempid,
        ];
        // Send HTTP POST request to SMSIntegra API
        $client = new Client();
        $response = $client->request('POST', $url, ['query' => $params]);
        return (string) $response->getBody();
    }

    public function generateOtp($length)
    {
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        return rand($min, $max);
    }
    public function generateReferralCode()
    {
        $otpdetails = $this->getOtpDetails();

        $code = substr(md5(uniqid(mt_rand(), true)), 0, $otpdetails->referral_code_length); // generate a random string
        return strtoupper($code);
    }

    public function getSmsDetails()
    {
        return SmsSettings::first();
    }
    public function getOtpDetails()
    {
        return AdminSettings::first();
    }
    public function getMapDetails()
    {
        return GeoApiSettings::first();
    }
    //Create New User
    public function createUser($user_name, $email, $password, $ref_id, $display_name, $mobile, $role_id, $is_active, $created_by)
    {
        $user = User::create([
            'user_name' => $user_name,
            'email' => $email,
            'password' => Hash::make($password),
            'ref_id' => $ref_id,
            'display_name' => $display_name,
            'mobile' =>  $mobile,
            'role_id' => $role_id,
            'is_active' => $is_active,
            'created_by' => $created_by,
            'updated_by' => $created_by
        ]);

        $role_menus = RolePermission::where('role_id', $role_id)->pluck('menu_id')->first();
        $menus = explode(',', $role_menus);
        $menuPermissionData = [];
        foreach ($menus as $key => $menu) {
            $menuPermissionData['user_id'] = $user->id;
            $menuPermissionData['menu_id'] = $menu;
            $menuPermissionData['is_edit'] =  0;
            $menuPermissionData['is_delete'] =  0;
            $menuPermissionData['is_view'] = 1;
            $menuPermissionData['is_print'] = 0;
            $menuPermissionData['is_approval'] = 0;
            $menuPermissionData['created_by'] =  $created_by;
            $menuPermissionData['updated_by'] =  $created_by;
            UserRolePermission::create($menuPermissionData);
        }
    }

    //Update User
    public function updateUser($user_name, $email, $password, $ref_id, $display_name, $mobile, $role_id, $is_active, $created_by, $user_id = null)
    {

        if ($user_id) {
            $existing_role_id = User::where('id', $user_id)->pluck('role_id')->first();

            User::where('id', $user_id)->update([
                'user_name' => $user_name,
                'email' => $email,
                'ref_id' => $ref_id,
                'display_name' => $display_name,
                'mobile' =>  $mobile,
                'role_id' => $role_id,
                'is_active' => $is_active,
                'updated_by' => $created_by,
            ]);

            if ($existing_role_id != $role_id) {
                $role_menus = RolePermission::where('role_id', $role_id)->pluck('menu_id')->first();
                $menus = explode(',', $role_menus);
                $menuPermissionData = [];
                foreach ($menus as $key => $menu) {
                    $menuPermissionData['user_id'] = $user_id;
                    $menuPermissionData['menu_id'] = $menu;
                    $menuPermissionData['is_edit'] =  0;
                    $menuPermissionData['is_delete'] =  0;
                    $menuPermissionData['is_view'] = 1;
                    $menuPermissionData['is_print'] = 0;
                    $menuPermissionData['is_approval'] = 0;
                    $menuPermissionData['created_by'] =  $created_by;
                    $menuPermissionData['updated_by'] =  $created_by;
                    UserRolePermission::create($menuPermissionData);
                }
            }
        } else {
            User::where('ref_id', $ref_id)->where('role_id', $role_id)->update([
                'user_name' => $user_name,
                'email' => $email,
                'ref_id' => $ref_id,
                'display_name' => $display_name,
                'mobile' =>  $mobile,
                'role_id' => $role_id,
                'is_active' => $is_active,
                'updated_by' => $created_by,
            ]);
        }
    }
    public function updateLiveCount($documentsmodule_id, $plusorminus)
    {
        switch ($documentsmodule_id) {
            case DocumentModulesType::Hub:
                $data = BillNoSetting::first();
                $data->hub_live = ($plusorminus == 1 ? $data->hub_live + 1 : $data->hub_live - 1);
                $data->save();
                break;
            case DocumentModulesType::Employee:
                $data = BillNoSetting::first();
                $data->employee_live  = ($plusorminus == 1 ? $data->employee_live  + 1 : $data->employee_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::Manufacturer:
                $data = BillNoSetting::first();
                $data->manufacture_live  = ($plusorminus == 1 ? $data->manufacture_live  + 1 : $data->manufacture_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::Logistic:
                $data = BillNoSetting::first();
                $data->logistics_live  = ($plusorminus == 1 ? $data->logistics_live  + 1 : $data->logistics_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::DeliveryPerson:
                $data = BillNoSetting::first();
                $data->deliveryperson_live  = ($plusorminus == 1 ? $data->deliveryperson_live  + 1 : $data->deliveryperson_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::Ledger:
                $data = BillNoSetting::first();
                $data->ledger_live = ($plusorminus == 1 ? $data->ledger_live  + 1 : $data->ledger_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::Payment:
                $data = BillNoSetting::first();
                $data->Pay_live = ($plusorminus == 1 ? $data->Pay_live  + 1 : $data->Pay_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::Order:
                $data = BillNoSetting::first();
                $data->ORD_live = ($plusorminus == 1 ? $data->ORD_live  + 1 : $data->ORD_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::Invoice:
                $data = BillNoSetting::first();
                $data->INV_live = ($plusorminus == 1 ? $data->INV_live  + 1 : $data->INV_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::Surrender:
                $data = BillNoSetting::first();
                $data->SUR_live = ($plusorminus == 1 ? $data->SUR_live  + 1 : $data->SUR_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::StockOutward:
                $data = BillNoSetting::first();
                $data->outward_live = ($plusorminus == 1 ? $data->outward_live  + 1 : $data->outward_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::AdminOrder:
                $data = BillNoSetting::first();
                $data->adminorder_live = ($plusorminus == 1 ? $data->adminorder_live  + 1 : $data->adminorder_live  - 1);
                $data->save();
                break;
            case DocumentModulesType::LogisticBooking:
                $data = BillNoSetting::first();
                $data->LPBooking_live = ($plusorminus == 1 ? $data->LPBooking_live  + 1 : $data->LPBooking_live  - 1);
                $data->save();
                break;
            default:
                $data = [];
        }
        return $data;
    }

    public function getAutoGeneratedCode($documentsmodule_id)
    {
        $auto_generate_code = null;
        $data = BillNoSetting::first();
        switch ($documentsmodule_id) {
            case DocumentModulesType::Hub:
                $hubPrefix = $data->hub_prefix ?? 0;
                $hubLength = $data->hub_length ?? 0;
                $hubLive = (int)($data->hub_live ?? 0) + 1;
                if ($hubLive) {
                    $hubNumber = $hubLive;
                }
                $hubs = sprintf("%0{$hubLength}d", $hubNumber);
                $hubExample = $hubPrefix . $hubs;

                $auto_generate_code = $hubExample;
                break;

            case DocumentModulesType::Logistic:
                $logPrefix = $data->logistics_prefix ?? 0;
                $logLength = $data->logistics_length ?? 0;
                $logLive = (int)($data->logistics_live ?? 0) + 1;
                if ($logLive) {
                    $logNumber = $logLive;
                }
                $logs = sprintf("%0{$logLength}d", $logNumber);
                $logExample = $logPrefix . $logs;
                $auto_generate_code = $logExample;
                break;

            case DocumentModulesType::Manufacturer:
                $manPrefix = $data->manufacture_prefix ?? 0;
                $ManLength = $data->manufacture_length ?? 0;
                $manLive = (int)($data->manufacture_live ?? 0) + 1;
                if ($manLive) {
                    $manNumber = $manLive;
                }
                $mans = sprintf("%0{$ManLength}d", $manNumber);
                $manExample = $manPrefix . $mans;
                $auto_generate_code = $manExample;
                break;

            case DocumentModulesType::DeliveryPerson:
                $delPrefix = $data->deliveryperson_prefix ?? 0;
                $delLength = $data->deliveryperson_length ?? 0;
                $delLive = (int)($data->deliveryperson_live ?? 0) + 1;
                if ($delLive) {
                    $delNumber = $delLive;
                }
                $del = sprintf("%0{$delLength}d", $delNumber);
                $delExample = $delPrefix . $del;
                $auto_generate_code = $delExample;
                break;

            case DocumentModulesType::Employee:
                $manPrefix = $data->employee_prefix ?? 0;
                $ManLength = $data->employee_length ?? 0;
                $manLive = (int)($data->employee_live ?? 0) + 1;
                if ($manLive) {
                    $manNumber = $manLive;
                }
                $man = sprintf("%0{$ManLength}d", $manNumber);
                $manExample = $manPrefix . $man;
                $auto_generate_code = $manExample;
                break;
            case DocumentModulesType::Payment:
                $payPrefix = $data->Pay_prefix ?? 0;
                $payLength = $data->Pay_length ?? 0;
                $payLive = (int)($data->Pay_live ?? 0) + 1;
                if ($payLive) {
                    $payNumber = $payLive;
                }
                $payment = sprintf("%0{$payLength}d", $payNumber);
                $payExample = $payPrefix . $payment;
                $auto_generate_code = $payExample;
                break;

            case DocumentModulesType::Ledger:
                $ledPrefix = $data->ledger_prefix ?? 0;
                $ledLength = $data->ledger_length ?? 0;
                $ledLive = (int)($data->ledger_live ?? 0) + 1;
                if ($ledLive) {
                    $ledNumber = $ledLive;
                }
                $leds = sprintf("%0{$ledLength}d", $ledNumber);
                $auto_generate_code = $ledPrefix . $leds;
                break;
            case DocumentModulesType::Order:
                $ordPrefix = $data->ORD_prefix ?? 0;
                $ordLength = $data->ORD_length ?? 0;
                $ordLive = (int)($data->ORD_live ?? 0) + 1;
                if ($ordLive) {
                    $ordNumber = $ordLive;
                }
                $ords = sprintf("%0{$ordLength}d", $ordNumber);
                $auto_generate_code = $ordPrefix . $ords;
                break;
            case DocumentModulesType::Invoice:
                $invPrefix = $data->INV_prefix ?? 0;
                $invLength = $data->INV_length ?? 0;
                $invLive = (int)($data->INV_live ?? 0) + 1;
                if ($invLive) {
                    $invNumber = $invLive;
                }
                $invs = sprintf("%0{$invLength}d", $invNumber);
                $auto_generate_code = $invPrefix . $invs;
                break;
            case DocumentModulesType::Surrender:
                $surPrefix = $data->SUR_prefix ?? 0;
                $surLength = $data->SUR_length ?? 0;
                $surLive = (int)($data->SUR_live ?? 0) + 1;
                if ($surLive) {
                    $surNumber = $surLive;
                }
                $surs = sprintf("%0{$surLength}d", $surNumber);
                $auto_generate_code = $surPrefix . $surs;
                break;
            case DocumentModulesType::StockOutward:
                $outward_prefix = $data->outward_prefix ?? 0;
                $outward_length = $data->outward_length ?? 0;
                $outward_live = (int)($data->outward_live ?? 0) + 1;
                if ($outward_live) {
                    $outwardNumber = $outward_live;
                }
                $surs = sprintf("%0{$outward_length}d", $outwardNumber);
                $auto_generate_code = $outward_prefix . $surs;
                break;
            case DocumentModulesType::AdminOrder:
                $adminorder_prefix = $data->adminorder_prefix ?? 0;
                $adminorder_length = $data->adminorder_length ?? 0;
                $adminorder_live = (int)($data->adminorder_live ?? 0) + 1;
                if ($adminorder_live) {
                    $adminorderNumber = $adminorder_live;
                }
                $surs = sprintf("%0{$adminorder_length}d", $adminorderNumber);
                $auto_generate_code = $adminorder_prefix . $surs;
                break;
            case DocumentModulesType::LogisticBooking:
                $LPBooking_prefix = $data->LPBooking_prefix ?? 0;
                $LPBooking_length = $data->LPBooking_length ?? 0;
                $LPBooking_live = (int)($data->LPBooking_live ?? 0) + 1;
                if ($LPBooking_live) {
                    $LPBookingNumber = $LPBooking_live;
                }
                $surs = sprintf("%0{$LPBooking_length}d", $LPBookingNumber);
                $auto_generate_code = $LPBooking_prefix . $surs;
                break;
        }

        return $auto_generate_code;
    }



    public function getCountries()
    {
        return Country::where('is_active', 1)->orderBy('country_name', 'asc')->get(["country_name", "id"]);
    }

    public function getStates($country_id = 1, $all = 0)
    {
        return State::where('country_id', $country_id)
            ->where($all ? [] : ['is_active' => 1])
            ->orderBy('state_name', 'asc')
            ->select('state_name', 'state_code', 'id', 'is_active')
            ->get();
    }

    public function getCities($state_id, $all = 0)
    {
        return City::where('state_id', $state_id)
            ->where($all ? [] : ['is_active' => 1])
            ->orderBy('city_name', 'asc')
            ->select('city_name', 'id', 'is_active')
            ->get();
    }

    public function getAreas($city_id, $all = 0)
    {
        return Area::where('city_id', $city_id)
            ->where($all ? [] : ['is_active' => 1])
            ->whereNull('deleted_at')
            ->orderBy('area_name', 'asc')
            ->select('area_name', 'id', 'is_active')
            ->get();
    }

    public function getCustomer($customer_id)
    {
        $customer = Customer::where('id', $customer_id)
            ->first();
        return $customer;
    }

    public function getCustomerAddress_details($id = Null, $user_id = null)
    {
        $user_id = ($user_id ? $user_id : Auth::user()->id);
        if ($id != null) {
            return CustomerAddress::with('getAddressType', 'cityname', 'statename', 'countryname')
                ->where("customer_id", $this->getRefId($user_id, RoleTypes::Customer))
                ->where("id", $id)
                ->get();
        } else {
            return CustomerAddress::with('getAddressType', 'cityname', 'statename', 'countryname')
                ->where("customer_id", $this->getRefId($user_id, RoleTypes::Customer))->get();
        }
    }

    public function getCustomerNearestHub($address_id)
    {
        $hub_id = CustomerNearestHub::where('customer_address_id', $address_id)->value('hub_id');
        return ($hub_id ? $hub_id : 0);
    }

    public function checkUserPermission($user_id)
    {
        $userPermission = UserRolePermission::select('menu_id')->where('user_id', $user_id)->get()->toArray();
        $getMenuId = explode(',', $userPermission['menu_id'] ?? 0);
        $checkpermission = Menu::whereIn('id', [$getMenuId])->first();
        if ($checkpermission) {
            return true;
        } else {
            return false;
        }
    }

    public function fileUpload($fileinput, $filepath, $fileName)
    {
        $fileinput->move(public_path($filepath), $fileName);
        return $filepath . '/' . $fileName;
    }

    public function generateRandom($digit)
    {
        $min = pow(10, $digit - 1);
        $max = pow(10, $digit) - 1;
        return rand($min, $max);
    }

    public function getRolesForDropDown()
    {
        $role_id = [1, 3, 4, 5, 6, 17, 18];
        $roles = Role::whereNotIn('id', $role_id)->whereNull('deleted_at')->get();

        return $roles;
    }

    public function getUserRolesForDropDown()
    {
        $role_id = [1, 3, 4, 5, 6, 17, 18];
        $users = User::where('is_active', 1)->whereNotIn('role_id', $role_id)->whereNull('deleted_at')->get();

        return $users;
    }

    public function validateDocuments($request, $documentsmodule_id)
    {
        $documents = $this->getDocumentsByModule($documentsmodule_id);
        foreach ($documents as $item) {
            if ($item->is_mandatory == 1) {
                $document = 'doc_' . $item->id;
                $image = 'file_' . $item->id;
                if ($request->$document == null || $request->$image == null) {
                    return $item;
                }
            }
        }
        return true;
    }

    public function validateUpdateDocuments($request, $documentsmodule_id, $id)
    {
        $documents = $this->getDocumentConfigsByModule($documentsmodule_id, $id);
        foreach ($documents as $item) {
            if ($item->is_mandatory == 1) {
                $existingimage = 'hdDocumentImg_' . $item->id;
                $document = 'doc_' . $item->id;
                $image = 'file_' . $item->id;
                if ($request->$document == null || ($request->$existingimage == null ? $request->$image : $request->$existingimage) == null) {
                    return $item;
                }
            }
        }
        return true;
    }

    public function getDocumentsByModule($documentsmodule_id)
    {
        $documents = DocumentConfig::join('document_modules', 'document_modules.id', 'document_configs.documentmodule_id')
            ->join('document_types', 'document_types.id', 'document_configs.documenttype_id')
            ->where('documentmodule_id', $documentsmodule_id)->where('document_configs.is_active', 1)
            ->select('document_configs.*', 'document_modules.module_name', 'document_types.documenttype_name')
            ->get();
        return $documents;
    }
    public function getDocumentConfigsByModule($documentsmodule_id, $id)
    {
        $documents = [];
        switch ($documentsmodule_id) {
            case DocumentModulesType::Hub:
                $documents = DocumentConfig::with('documentType', 'documentModule')
                    ->leftJoin('hub_documents as hd', function ($join) use ($id) {
                        $join->on('hd.documenttype_id', 'document_configs.documenttype_id')
                            ->where('hd.hub_id', $id);
                    })
                    ->where('document_configs.documentmodule_id', $documentsmodule_id)
                    ->where('document_configs.is_active', 1)
                    ->select('document_configs.*', 'hd.hub_id', 'hd.document_number', 'hd.document_path', 'hd.is_verified')
                    ->get();

                break;
            case DocumentModulesType::Employee:
                $documents = DocumentConfig::with('documentType', 'documentModule')
                    ->leftJoin('employee_documents as ed', function ($join) use ($id) {
                        $join->on('ed.documenttype_id', 'document_configs.documenttype_id')
                            ->where('ed.employee_id', $id);
                    })
                    ->where('document_configs.documentmodule_id', $documentsmodule_id)
                    ->where('document_configs.is_active', 1)
                    ->select('document_configs.*', 'ed.employee_id', 'ed.document_number', 'ed.document_path', 'ed.is_verified')
                    ->get();

                break;
            case DocumentModulesType::Manufacturer:
                $documents = DocumentConfig::with('documentType', 'documentModule')
                    ->leftJoin('manufacturer_documents as md', function ($join) use ($id) {
                        $join->on('md.documenttype_id', 'document_configs.documenttype_id')
                            ->where('md.manufacture_id', $id);
                    })
                    ->where('document_configs.documentmodule_id', $documentsmodule_id)
                    ->where('document_configs.is_active', 1)
                    ->select('document_configs.*', 'md.manufacture_id', 'md.document_number', 'md.document_path', 'md.is_verified')
                    ->get();

                break;
            case DocumentModulesType::Logistic:
                $documents = DocumentConfig::with('documentType', 'documentModule')
                    ->leftJoin('logistic_partner_documents as lpd', function ($join) use ($id) {
                        $join->on('lpd.documenttype_id', 'document_configs.documenttype_id')
                            ->where('lpd.logistic_partner_id', $id);
                    })
                    ->where('document_configs.documentmodule_id', $documentsmodule_id)
                    ->where('document_configs.is_active', 1)
                    ->select('document_configs.*', 'lpd.logistic_partner_id', 'lpd.document_number', 'lpd.document_path', 'lpd.is_verified')
                    ->get();

                break;
            case DocumentModulesType::DeliveryPerson:
                $documents = DocumentConfig::with('documentType', 'documentModule')
                    ->leftJoin('delivery_people_documents as dpd', function ($join) use ($id) {
                        $join->on('dpd.documenttype_id', 'document_configs.documenttype_id')
                            ->where('dpd.delivery_people_id', $id);
                    })
                    ->where('document_configs.documentmodule_id', $documentsmodule_id)
                    ->where('document_configs.is_active', 1)
                    ->select('document_configs.*', 'dpd.delivery_people_id', 'dpd.document_number', 'dpd.document_path', 'dpd.is_verified')
                    ->get();

                break;
            default:
                $documents = [];
        }
        // dd($documents);
        return $documents;
    }

    public function Log($transaction_name, $mode, $log_message, $user_id, $ip_address, $system_name, $is_app = 0)
    {
        Log::create([
            'transaction_name' => $transaction_name,
            'mode' => $mode,
            'log_message' => $log_message,
            'user_id' => $user_id,
            'ip_address' => $ip_address,
            'system_name' =>  $system_name,
            'is_app' =>  $is_app,
            'log_date' => Carbon::now()
        ]);
    }

    public function getMenuUrl()
    {
        $previousUrl = url()->previous();
        $path = parse_url($previousUrl, PHP_URL_PATH);
        $segments = explode('/', $path);
        $menuUrl = '/' . $segments[1];

        return $menuUrl;
    }

    public function chkUserMenuPermission()
    {
        $menu = Menu::where('menu_url', $this->getMenuUrl())->first();
        if ($menu) {
            $chkUserFilePermission = UserRolePermission::select('is_edit', 'is_delete', 'is_view', 'is_print', 'is_approval')
                ->where('user_id', Auth::user()->id)
                ->where('menu_id', $menu->id)
                ->first();
            return $chkUserFilePermission;
        }
    }

    public function chkUserHasPermission()
    {
        $menu = Menu::where('menu_url', $this->getMenuUrl())->first();
        if ($menu) {
            $chkUserHasPermission = UserRolePermission::where('user_id', Auth::user()->id)
                ->where('menu_id', $menu->id)
                ->first();
            return ($chkUserHasPermission ? true : false);
        } else {
            return false;
        }
    }

    public function isUserHavePermission($permissionType)
    {
        if (Auth::user()->id == 1) {
            return true;
        }

        $userMenuPermission = $this->chkUserMenuPermission();

        switch ($permissionType) {
            case MenuPermissionType::Edit:
                return ($userMenuPermission->is_edit == 1);
            case MenuPermissionType::Delete:
                return ($userMenuPermission->is_delete == 1);
            case MenuPermissionType::View:
                return ($userMenuPermission->is_view == 1);
            case MenuPermissionType::Print:
                return ($userMenuPermission->is_print == 1);
            case MenuPermissionType::Approval:
                return ($userMenuPermission->is_approval == 1);
        }
    }

    public function documentTitle($documentsmodule_id)
    {
        $documentTitle = [];
        switch ($documentsmodule_id) {
            case DocumentModulesType::DeliveryPerson:
                $documentTitle = DocumentModules::where('id', $documentsmodule_id)->pluck('module_name')->first();
                break;
            case DocumentModulesType::Employee:
                $documentTitle = DocumentModules::where('id', $documentsmodule_id)->pluck('module_name')->first();
                break;
            case DocumentModulesType::Manufacturer:
                $documentTitle = DocumentModules::where('id', $documentsmodule_id)->pluck('module_name')->first();
                break;
            case DocumentModulesType::Logistic:
                $documentTitle = DocumentModules::where('id', $documentsmodule_id)->pluck('module_name')->first();
                break;
            case DocumentModulesType::Hub:
                $documentTitle = DocumentModules::where('id', $documentsmodule_id)->pluck('module_name')->first();
                break;
            default:
                $documentTitle = [];
        }
        return $documentTitle;
    }

    public function documentByUsers($documentsmodule_id, $id)
    {
        $documents = [];
        switch ($documentsmodule_id) {
            case DocumentModulesType::DeliveryPerson:
                $documents = DeliveryPeopleDocuments::with('documentType')
                    ->where('delivery_people_documents.delivery_people_id', $id)
                    ->get();
                break;
            case DocumentModulesType::Logistic:
                $documents = LogisticPartnerDocuments::with('documentType')
                    ->where('logistic_partner_documents.logistic_partner_id', $id)
                    ->get();
                break;
            case DocumentModulesType::Manufacturer:
                $documents = ManufacturerDocuments::with('documentType')
                    ->where('manufacturer_documents.manufacture_id', $id)
                    ->get();
                break;
            case DocumentModulesType::Hub:
                $documents = HubDocuments::with('documentType')
                    ->where('hub_documents.hub_id', $id)
                    ->get();
                break;
            case DocumentModulesType::Employee:
                $documents = EmployeeDocuments::with('documentType')
                    ->where('employee_documents.employee_id', $id)
                    ->get();
                break;
            default:
                $documents = [];
        }
        return $documents;
    }

    public function updateDocumentVerification($documentsmodule_id, $id, $status)
    {
        $documents = [];
        switch ($documentsmodule_id) {
            case DocumentModulesType::Logistic:
                LogisticPartnerDocuments::findorfail($id)->update([
                    'is_verified' => $status,
                    'updated_by' => Auth::user()->id
                ]);
                break;
            case DocumentModulesType::DeliveryPerson:
                DeliveryPeopleDocuments::findorfail($id)->update([
                    'is_verified' => $status,
                    'updated_by' => Auth::user()->id
                ]);
                break;
            case DocumentModulesType::Manufacturer:
                ManufacturerDocuments::findorfail($id)->update([
                    'is_verified' => $status,
                    'updated_by' => Auth::user()->id
                ]);
                break;
            case DocumentModulesType::Hub:
                HubDocuments::findorfail($id)->update([
                    'is_verified' => $status,
                    'updated_by' => Auth::user()->id
                ]);
                break;
            case DocumentModulesType::Employee:
                EmployeeDocuments::findorfail($id)->update([
                    'is_verified' => $status,
                    'updated_by' => Auth::user()->id
                ]);
                break;
            default:
                $documents = [];
        }
        return $documents;
    }

    public function getOrCreateAreaId($areaName, $stateId, $cityId)
    {
        $area = Area::where('area_name', $areaName)
            ->orWhere('id', $areaName)
            ->where('state_id', $stateId)
            ->where('city_id', $cityId)
            ->first();

        if ($area) {
            return $area->id;
        } else {
            $newArea = new Area;
            $newArea->area_name = $areaName;
            $newArea->state_id = $stateId;
            $newArea->city_id = $cityId;
            $newArea->created_by = Auth::user()->id;
            $newArea->created_at = Carbon::now();
            $newArea->save();

            return $newArea->id;
        }
    }

    public function getDeliveryInfo($product_type_id, $order_before_time, $delivery_duration)
    {
        // $product_type_delivery_durations = [
        //     ProductType::Elite => "$delivery_duration Hr Delivery",
        //     ProductType::Premium => "Same Day Delivery",
        //     ProductType::Classic => "Next Day Delivery",
        //     ProductType::Regular => "Delivery Within " . round($delivery_duration / 24) . " Days",
        // ];



        if ($delivery_duration < 12) {
            $delivery_day = "$delivery_duration Hr Delivery";
        } else if ($delivery_duration > 12 and $delivery_duration <= 24) {
            $delivery_day = "Same Day Delivery";
        } else if ($delivery_duration > 24 and $delivery_duration <= 48) {
            $delivery_day = "Next Delivery";
        } else {
            $delivery_day = "Delivery Within " . round($delivery_duration / 24) . " Days";
        }

        $current_time = Carbon::now();
        $order_before = Carbon::parse($order_before_time);

        if ($current_time >= $order_before) {
            $delivery_text = "Order will be delivered on next working day";
        } else {
            $diff = $this->timeDiff($current_time, $order_before);
            $time_string = ($diff->h > 0 ? $diff->h . " hrs " : "") . ($diff->i > 0 ? $diff->i . " mins " : "");
            $delivery_text = ($product_type_id == ProductType::Regular) ?
                "Order will be delivered within " . round($delivery_duration / 24) . " days" :
                "Order within " . $time_string . " to avail " . strtolower($delivery_day);
        }

        $data = [
            'delivery_text' => $delivery_text,
            'delivery_day' => $delivery_day
        ];
        return $data;
    }

    public function timeDiff($from_time, $to_time)
    {
        return $from_time->diff($to_time);
    }

    public function addReferralHistory($user_id, $referred_by)
    {
        UserReferralHistory::create([
            'user_id' => $user_id,
            'referred_by' => $referred_by->id,
            'referred_on' => Carbon::today()
        ]);
    }

    public function addReferralWallet($user_id, $referred_by)
    {
        $referral_points = $this->getReferralSetting()->earnpoints_per_referral;
        // $referrer_points = $this->getReferralSetting()->earnpoints_per_referrer;
        //Add referral points to user wallet
        $this->addWallet($user_id, $referral_points, WalletTransactionTypes::Referral);
        // $this->addWallet($referred_by->id, $referrer_points, WalletTransactionTypes::Referral);
    }

    public function addReferrerWallet($user_id)
    {
        $referred_by = UserReferralHistory::where('user_id', $user_id)->pluck('referred_by')->first();
        $referrer_points = $this->getReferralSetting()->earnpoints_per_referrer;
        $this->addWallet($referred_by, $referrer_points, WalletTransactionTypes::Referral);
    }

    public function addWallet($id, $points, $type)
    {

        //Get current wallet points for user
        $user_wallet_points = User::where('id', $id)
            ->value('wallet_points');

        $current_wallet_points = ($user_wallet_points + $points);

        $wallets = UserWallet::create([
            'user_id' => $id,
            'amount' => $points,
            'balance' => $current_wallet_points,
            'wallet_transaction_type_id' => $type,
            'transaction_date' => now()
        ]);

        User::where('id', $id)->update([
            'wallet_points' => $current_wallet_points
        ]);

        // Return the response with a 200 status code
        return true;
    }
    public function updateWallet($id, $used_points, $wallet_trans_type = null)
    {

        $wallet_trans_type = ($wallet_trans_type ? $wallet_trans_type :  WalletTransactionTypes::Used);
        //Get current wallet points for user
        $user_wallet_points = User::where('id', $id)
            ->value('wallet_points');

        $current_wallet_points = ($user_wallet_points - $used_points);

        $wallets = UserWallet::create([
            'user_id' => $id,
            'amount' => $used_points,
            'balance' => $current_wallet_points,
            'wallet_transaction_type_id' => $wallet_trans_type,
            'transaction_date' => now()
        ]);

        if ($wallet_trans_type != WalletTransactionTypes::WalletPending && $wallet_trans_type != WalletTransactionTypes::WalletFailed) {
            User::where('id', $id)->update([
                'wallet_points' => $current_wallet_points
            ]);
        }

        // Return the response with a 200 status code
        return true;
    }
    public function hubActivation($hub_id)
    {
        $deliveryPeople = DeliveryPerson::where('hub_id', $hub_id)
            ->where('is_active', 1)
            ->count();
        $logisticPartner = LogisticsHubConfig::select('logistics_hub_configs.*', 'logistic_partners.is_active')
            ->join('logistic_partners', 'logistic_partners.id', 'logistics_hub_configs.logistic_partner_id')
            ->where('logistics_hub_configs.hub_id', $hub_id)
            ->where('logistic_partners.is_active', 1)
            ->get()
            ->count();
        if ($deliveryPeople > 0 && $logisticPartner > 0) {
            Hub::findOrfail($hub_id)->update([
                'is_active' => 1,
                'updated_by' => Auth::user()->id
            ]);
        } else {
            Hub::findOrfail($hub_id)->update([
                'is_active' => 0,
                'updated_by' => Auth::user()->id
            ]);
        }
    }

    public function getCansInHand($id = null, $address_id = null)
    {
        // dd($address_id);
        if ($id) {
            $is_empty_return = Products::where('id', $id)->pluck('is_emptycan_return')->first();
            if ($is_empty_return) {
                // $result = DB::table('order_dets')->join('orders', 'orders.id', '=', 'order_dets.order_id')
                //     ->selectRaw('SUM(order_dets.qty) as totalqty, SUM(order_dets.return_empty_cans_qty) as total_return_empty_cans_qty')
                //     ->where('order_dets.product_id', $id)
                //     ->where('orders.user_id', Auth::user()->id)
                //     ->where('orders.status_id', StatusTypes::OrderDelivered)
                //     ->where('orders.delivery_address_id', $address_id)
                //     ->first();

                // $emptyCans = $result->totalqty - $result->total_return_empty_cans_qty;

                if ($address_id) {
                    $emptyCans = CustomerStock::where('user_id', Auth::user()->id)
                        ->where('address_id', $address_id)
                        ->where('product_id', $id)
                        ->pluck('empty_qty')
                        ->first();
                } else {
                    $emptyCans = CustomerStock::where('user_id', Auth::user()->id)
                        ->where('product_id', $id)
                        ->sum('empty_qty');
                }
                $emptyCans = ($emptyCans ? $emptyCans : 0);
            } else {
                $emptyCans = 0;
            }
        } else {
            $emptyCans = CustomerStock::where('user_id', Auth::user()->id)
                ->sum('empty_qty');
        }
        return (int)$emptyCans;
    }

    public function getTotalCansInHand()
    {
        return $this->getCansInHandAddressWise('empty_can');
    }

    public function getCansInHandAddressWise($type = null, $user_id = null)
    {
        $user_id = ($user_id ? $user_id : Auth::user()->id);
        $userOrders = Order::where('user_id', $user_id)
            ->where('status_id', StatusTypes::OrderDelivered)
            ->get();

        $empty_can = 0;
        $total_emptycan = 0;
        $total_qty = 0;
        $address_details = [];
        $data_address_product_wise = [];
        $address_empty_can = 0;
        $address_surrender_can = 0;
        if (!$userOrders->isEmpty()) {
            // dd($userOrders);
            foreach ($userOrders as $orders) {
                if ($orders->orderDets) {
                    foreach ($orders->orderDets as $orderDets) {
                        $total_emptycan += (int)$orderDets->return_empty_cans_qty;

                        // If the delivery address and product id combination is not yet in the array, add it
                        if (!isset($data_address_product_wise)) {
                            $data_address_product_wise[] = [
                                'empty_can' => 0,
                                'product_id' => 0,
                                'product_name' => 0,
                                'deposit_amount' => 0,
                                'surrender_can' => 0,
                            ];
                        }
                        $surrender_can = $this->getSurrenderCan($orders->delivery_address_id, $orderDets->product_id, $user_id);

                        // Increment the empty can count and total qty for this delivery address and product id combination
                        $data_address_product_wise[] = [
                            'empty_can' => (int)$orderDets->qty - (int)$orderDets->return_empty_cans_qty,
                            'product_id' => $orderDets->product_id,
                            'product_name' => $orderDets->products->product_name,
                            'deposit_amount' => $orderDets->deposit_amount,
                            'surrender_can' => $surrender_can
                        ];

                        $address_empty_can += (int)$orderDets->qty - (int)$orderDets->return_empty_cans_qty;
                        $address_surrender_can += $surrender_can;
                    }
                }
                $total_qty += (int)$orders->total_qty;
            }

            $empty_can = $total_qty - $total_emptycan;
            $formattedAddress = UserAddressResource::collection($this->getCustomerAddress_details($orders->delivery_address_id));
            $formattedAddress = $formattedAddress->values(); // Convert the collection to an array

            // Group the collection by product_id
            $groupedData = collect($data_address_product_wise)->groupBy('product_id');

            // Initialize an empty array to store the summed data
            $product_grouped_data = [];

            // Iterate over each group
            foreach ($groupedData as $product_id => $group) {
                // Calculate the sum for the current group
                $tot_empty_can = $group->sum('empty_can');
                $tot_surrender_can = $group->sum('surrender_can');

                // Get the first item from the group to retrieve other common data
                $firstItem = $group->first();

                // Add the summed data to the new array
                $product_grouped_data[] = [
                    'empty_can' => $tot_empty_can,
                    'surrender_can' => $tot_surrender_can,
                    'product_id' => $product_id,
                    'product_name' => $firstItem['product_name'],
                    'deposit_amount' => $firstItem['deposit_amount']
                ];
            }

            $address_details[] = [
                'address' => $formattedAddress,
                'empty_can' => $address_empty_can,
                'surrender_can' => $address_surrender_can,
                'product_wise' => $product_grouped_data
            ];
        }

        if ($type == "empty_can") {
            return $empty_can;
        }

        $return_data = [
            "total_can_in_hand" => $empty_can,
            "address_wise" => $address_details,
        ];

        return $return_data;
    }

    public function getSurrenderCan($address_id, $product_id, $user_id)
    {
        $surrender_orders = Surrender::where('user_id', $user_id)
            ->where('address_id', $address_id)
            ->whereIn('status_id', [StatusTypes::SurrenderRequested, StatusTypes::SurrenderApproved])
            ->get();
        // dd($surrender_orders);
        $surrender_can_qty = 0;
        if ($surrender_orders) {
            foreach ($surrender_orders as $key => $surrender_order) {
                if ($surrender_order->surrenderDets) {
                    foreach ($surrender_order->surrenderDets as $surrenderDet) {
                        if ($surrenderDet->product_id == $product_id) {
                            $surrender_can_qty += $surrenderDet->qty;
                        }
                    }
                }
            }
        }
        return $surrender_can_qty;
    }

    public function getCanDepositFromHistory($address_id, $product_id, $user_id)
    {
        $deposit_history = UserDepositHistory::where('user_id', $user_id)
            ->where('delivery_address_id', $address_id)
            ->where('product_id', $product_id)
            ->latest()
            ->first();
        // dd($deposit_history->deposit_amount);
        $deposit_amount = ($deposit_history ? $deposit_history->deposit_amount : 0);
        return $deposit_amount;
    }

    public function getOrderDetail($id)
    {
        $orderdetails = Order::where('id', $id)->with('products.orderDets')->get();

        // $orderdetails = OrderDetailsResource::collection($orderdetails);

        foreach ($orderdetails as $orderdetail) {

            $orderdetails = [
                'order_id' => $orderdetail->id,
                'order_no' => $orderdetail->order_no,
                'invoice_no' => $orderdetail->invoice_no,
                'delivery_address' => $orderdetail->delivery_address,
                'delivery_desc' => $orderdetail->desc,
                'delivery_charge' => $orderdetail->delivery_charge,
                'additional_delivery_charge' => $orderdetail->additional_delivery_charge,
                'coupon_code' => $orderdetail->coupon_code,
                'total_discount_amount' => $orderdetail->total_discount_amount,
                'total_igst_amount' => $orderdetail->total_igst_amount,
                'total_sgst_amount' => $orderdetail->total_sgst_amount,
                'total_cgst_amount' => $orderdetail->total_cgst_amount,
                'total_qty' => $orderdetail->total_qty,
                'wallet_points_used' => $orderdetail->wallet_points_used,
                'deposit_amount' => $orderdetail->deposit_amount,
                'total_tax_amount' => $orderdetail->total_tax_amount,
                'sub_total' => $orderdetail->sub_total,
                'taxable_amount' => $orderdetail->taxable_amount,
                'roundoff' => $orderdetail->roundoff,
                'grand_total' => $orderdetail->grand_total,
                'status_id' => $orderdetail->status_id,
                'status_name' => $orderdetail->status->status,
                'status_msg' => $orderdetail->status->status_msg,
                'status_color_css' => $orderdetail->status->status_color_css,
                'is_cancel' => $orderdetail->is_cancel,
                'exp_delivery_date' => DateTime::createFromFormat('Y-m-d H:i:s', $orderdetail->exp_delivery_date)->format('d M,y h:i A'),
                'transaction_date' => DateTime::createFromFormat('Y-m-d H:i:s', $orderdetail->transaction_date)->format('d M,y'),
                'transaction_amount' => $orderdetail->transaction_amount,
                'transaction_status' => $orderdetail->transaction_status,
                'transaction_id' => $orderdetail->transaction_id,
                'transaction_order_id' => $orderdetail->transaction_order_id,
                'payment_method' => $orderdetail->payment_method,
                'payment_through' => $orderdetail->payment_through,
                'show_invoice' => ($orderdetail->status_id == StatusTypes::OrderDelivered &&
                    Carbon::parse($orderdetail->transaction_date)->month == Carbon::now()->month ? true : false),
                'is_invoice_downloaded' => $orderdetail->is_invoice_downloaded,
                'is_elite' => $this->getOrderHasEliteItems($orderdetail->id),
                'show_retry_payment' => $this->checkRetryPaymentEligibility($orderdetail->id),
                'order_details' => $orderdetail->orderDets->map(function ($orderdet) {
                    return [
                        'product_id' => $orderdet->product_id,
                        'product_name' => $orderdet->products->product_name,
                        'quantity' => $orderdet->qty,
                        'return_empty_cans_qty' => $orderdet->return_empty_cans_qty,
                        'damaged_empty_cans_qty' => $orderdet->damaged_empty_cans_qty
                    ];
                }),
                'order_tracking_history' => $orderdetail->orderTrackings->sortBy('created_at')->map(function ($orderTracking) use ($orderdetail) {
                    return [
                        'status_name' => $orderTracking->status->status,
                        'status_msg' => $orderTracking->status->status_msg,
                        'current_status' => ($orderTracking->status_id == $orderdetail->status_id) ? true : false,
                        'date' => DateTime::createFromFormat('Y-m-d H:i:s', $orderTracking->updated_at)->format('d M,y, h:i A'),
                    ];
                }),
                // 'delivery_id' => $this->getDeliveryId($orderdetail->id),
                // 'customer_rating' => $this->getCustomerRating($orderdetail->id),
                // 'is_highlighted' => $this->checkOrderHighlighted($orderdetail->id),
                'delivery_details' => $orderdetail->orderDeliveries->filter(function ($delivery) {
                    return $delivery->is_notdelivered == 0;
                })->map(function ($delivery) use ($orderdetail) {
                    return [
                        'delivery_id' => $delivery->id,
                        'delivery_user_id' => $this->getDeliveryUserId($orderdetail->id, false),
                        'delivery_person_name' => $this->getDeliveryPersonName($orderdetail->id, false),
                        'floor' => $delivery->floor,
                        'is_lift' => $delivery->is_lift,
                        'delivery_user_notes' => $delivery->delivery_user_notes,
                        'delivery_reason' => $delivery->delivery_reason,
                        'customer_rating' => $delivery->customer_rating,
                        'is_highlighted' => ($delivery->is_highlighted == 1 ? true : false),
                        'is_notdelivered' => $delivery->is_notdelivered,
                        'delivered_on' => ($this->getDeliveryDate($orderdetail->id, false) != null ?
                            DateTime::createFromFormat('Y-m-d H:i:s', $this->getDeliveryDate($orderdetail->id, false))->format('d M,y H:i A') : null),

                    ];
                })->values(),
                'couldnotdeliver_details' => $orderdetail->orderDeliveries->filter(function ($delivery) {
                    return $delivery->is_notdelivered == 1;
                })->map(function ($delivery) use ($orderdetail) {
                    return [
                        'delivery_user_id' => $this->getDeliveryUserId($orderdetail->id, true),
                        'delivery_person_name' => $this->getDeliveryPersonName($orderdetail->id, true),
                        'delivery_reason' => $delivery->delivery_reason,
                        'is_notdelivered' => $delivery->is_notdelivered,
                    ];
                }),
            ];
        }

        return $orderdetails;
    }

    public function getOrders($status_id = null, $user_id = null, $is_notdelivered = null)
    {
        $user = User::where('id', ($user_id ? $user_id : Auth::user()->id))->first();
        $orders = "";
        $statusIds = explode(',', $status_id);
        switch ($user->role_id) {
            case RoleTypes::Customer:
                $orders = Order::where('user_id', Auth::user()->id);
                if ($status_id) {
                    $orders = $orders->whereIn('status_id', $statusIds);
                }
                break;
            case RoleTypes::Hub:
                $orders = Order::where('hub_id', $user->ref_id);
                // $orders = Order::join('order_deliveries', 'orders.id', '=', 'order_deliveries.order_id')
                //     ->where('order_deliveries.is_notdelivered', '=', 1)
                //     ->where('hub_id', $user->ref_id);
                if ($status_id) {
                    $orders = $orders->whereIn('status_id', $statusIds);
                    // dd($orders->count());
                }
                break;
            case RoleTypes::DeliveryPerson:
                if ($is_notdelivered == 1) {
                    $orders = Order::join('order_deliveries', 'orders.id', '=', 'order_deliveries.order_id')
                        ->where('order_deliveries.delivery_user_id', $user->id)
                        ->where('order_deliveries.is_notdelivered', '=', 1)
                        ->select('orders.*');
                } else {
                    $orders = Order::join('order_deliveries', 'orders.id', '=', 'order_deliveries.order_id')
                        ->where('order_deliveries.delivery_user_id', $user->id)
                        ->where('order_deliveries.is_notdelivered', '=', 0)
                        ->select('orders.*');
                }
                // dd($orders->get());
                if ($status_id) {
                    $orders = $orders->whereIn('status_id', $statusIds);
                }
                break;
            case RoleTypes::Manufacturer:
                $hubs = HubManufactureConfig::where('manufacturer_id', $user->ref_id)->get();
                $hubIds = $hubs->pluck('hub_id')->toArray(); // get an array of hub_ids from $hubs
                $orders = Order::whereIn('hub_id', $hubIds)
                    ->where('transaction_date', '<', now()->subHours($this->getAdminSetting()->show_orders_to_manufacturer));
                break;
        }

        return $orders->orderBy('orders.id', 'desc');
    }

    public function getAllOrders($type = "all", $cus_id = null, $hub_id = null)
    {
        $orders = Order::select('orders.*', 'customers.customer_name', 'hubs.hub_name', 'statuses.status', 'statuses.status_color_css')
            ->whereIn('status_id', [
                StatusTypes::OrderPlaced,
                StatusTypes::OrderShipped,
                StatusTypes::OrderDelivered,
                StatusTypes::AssignedToDelivery,
                StatusTypes::Failed
            ]);
        switch ($type) {
            case 'Customer':
                if ($cus_id > 0) {
                    $user_id = $this->getUserId($cus_id, RoleTypes::Customer);
                    $orders = Order::select('orders.*', 'customers.customer_name', 'hubs.hub_name', 'statuses.status', 'statuses.status_color_css')
                        ->where('user_id', $user_id);
                }
                break;
            case "Hub":
                if ($hub_id > 0) {
                    $orders = Order::select('orders.*', 'customers.customer_name', 'hubs.hub_name', 'statuses.status', 'statuses.status_color_css')
                        ->where('hub_id', $hub_id);
                }
                break;
            case "Manufacture":
                $orders = Order::select('orders.*', 'customers.customer_name', 'hubs.hub_name', 'statuses.status', 'statuses.status_color_css')
                    ->where('hub_id', $hub_id)
                    ->where('transaction_date', '<', now()->subHours($this->getAdminSetting()->show_orders_to_manufacturer));
                break;
        }

        $orders->join('users', 'users.id', 'orders.user_id')
            ->join('customers', 'customers.id', 'users.ref_id')
            ->join('hubs', 'hubs.id', 'orders.hub_id')
            ->join('customer_addresses', 'customer_addresses.id', 'orders.delivery_address_id')
            ->join('statuses', 'statuses.id', 'orders.status_id')
            ->join('states', 'states.id', 'customer_addresses.state_id')
            ->join('cities', 'cities.id', 'customer_addresses.city_id');

        // dd($orders->get());
        return $orders->orderBy('orders.id', 'desc');
    }

    public function getCancelledOrders()
    {
        $orders = Order::select('orders.*', 'customers.customer_name', 'hubs.hub_name', 'statuses.status', 'statuses.status_color_css')
            ->whereIn('status_id', [
                StatusTypes::OrderCancelledByAdmin,
                StatusTypes::Cancelled
            ]);
        $orders->join('users', 'users.id', 'orders.user_id')
            ->join('customers', 'customers.id', 'users.ref_id')
            ->join('hubs', 'hubs.id', 'orders.hub_id')
            ->join('customer_addresses', 'customer_addresses.id', 'orders.delivery_address_id')
            ->join('statuses', 'statuses.id', 'orders.status_id')
            ->join('states', 'states.id', 'customer_addresses.state_id')
            ->join('cities', 'cities.id', 'customer_addresses.city_id');

        // dd($orders->get());
        return $orders->orderBy('orders.id', 'desc');
    }

    public function getPendingOrders()
    {
        $orders = Order::select('orders.*', 'customers.customer_name', 'hubs.hub_name', 'statuses.status', 'statuses.status_color_css')
            ->whereIn('status_id', [
                StatusTypes::Pending
            ]);
        $orders->join('users', 'users.id', 'orders.user_id')
            ->join('customers', 'customers.id', 'users.ref_id')
            ->join('hubs', 'hubs.id', 'orders.hub_id')
            ->join('customer_addresses', 'customer_addresses.id', 'orders.delivery_address_id')
            ->join('statuses', 'statuses.id', 'orders.status_id')
            ->join('states', 'states.id', 'customer_addresses.state_id')
            ->join('cities', 'cities.id', 'customer_addresses.city_id');

        // dd($orders->get());
        return $orders->orderBy('orders.id', 'desc');
    }

    //TODO:: this method is not used now because order status directly updated in order table
    // public function getDPCouldNotDeliveredCount()
    // {
    //     $orders = Order::join('order_deliveries', 'orders.id', '=', 'order_deliveries.order_id')
    //         ->where('order_deliveries.delivery_user_id', Auth::user()->id)
    //         ->where('order_deliveries.is_notdelivered', '=', 1)
    //         ->select('orders.*');

    //     return $orders->count();
    // }

    //TODO:: this method is not used now because order status directly updated in order table
    // public function getHubCouldNotDeliveredCount()
    // {
    //     $orders = Order::join('order_deliveries', 'orders.id', '=', 'order_deliveries.order_id')
    //         ->where('orders.hub_id', Auth::user()->ref_id)
    //         ->where('order_deliveries.is_notdelivered', '=', 1)
    //         ->select('orders.*');

    //     return $orders->count();
    // }

    public function addOrderTracking($order_id, $status_id)
    {
        $order_tracking = OrderTracking::where('order_id', $order_id)
            ->where('status_id', $status_id)->exists();
        if (!$order_tracking) {
            OrderTracking::create([
                'order_id' => $order_id,
                'status_id' => $status_id,
            ]);
        } else {
            OrderTracking::where('order_id', $order_id)
                ->where('status_id', $status_id)
                ->update([
                    'order_id' => $order_id,
                    'status_id' => $status_id,
                ]);
        }
    }

    public function addSurrenderHistory($surrender_id, $status_id)
    {
        SurrenderHistory::create([
            'surrender_id' => $surrender_id,
            'status_id' => $status_id,
        ]);
    }

    public function addOrderStatusHistory($order_id, $status_id)
    {
        UserOrderHistory::create([
            'order_id' => $order_id,
            'status_id' => $status_id,
        ]);

        //Add order tracking status history
        if (
            $status_id == StatusTypes::OrderPlaced
            || $status_id == StatusTypes::AssignedToDelivery
            || $status_id == StatusTypes::OrderShipped
            || $status_id == StatusTypes::OrderDelivered
            || $status_id == StatusTypes::OrderCancelledByAdmin
            || $status_id == StatusTypes::Cancelled
            || $status_id == StatusTypes::OrderNotDelivered
        ) {
            $this->addOrderTracking($order_id, $status_id);
        }
    }

    public function saveOrderStatus($order_id, $status_id)
    {
        $order = Order::find($order_id);
        $order->status_id = $status_id;
        $order->save();
    }

    public function sendWalletNotification($points, $status_id, $user_id = null, $balancepoints = null)
    {
        $user_id = ($user_id ? $user_id : Auth::user()->id);
        // $order = Order::find($order_id);
        switch ($status_id) {
            case WalletTransactionTypes::WalletPending:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::WalletPending)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::WalletPending)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$points], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Wallet Payment Pending',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'type' => 'wallet'
                ];
                break;
            case WalletTransactionTypes::WalletSuccess:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::WalletSuccess)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::WalletFailed)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$points], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Wallet Payment Success',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'points_added' => $points,
                    'type' => 'wallet'
                ];
                break;
            case WalletTransactionTypes::WalletFailed:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::WalletFailed)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::WalletFailed)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$points], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Wallet Payment Failed',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'type' => 'wallet'
                ];
                break;
            case WalletTransactionTypes::Offers:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::Offers)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::Offers)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$points], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Offers Wallet',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'points_added' => $points,
                    'type' => 'wallet'
                ];
                break;
            case WalletTransactionTypes::Referral:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::Referral)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::Referral)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$points], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Referral Wallet',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'points_added' => $points,
                    'type' => 'wallet'
                ];
                break;
            case WalletTransactionTypes::Used:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::Used)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::Used)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$points, $balancepoints], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Used Wallet Payment',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'points_used' => $points,
                    'type' => 'wallet'
                ];
                break;
        }
        $pushNotificationController = new PushNotificationController();

        //TODO::Need to check this array_push
        // array_push($notification, $data);
        UserNotifications::create([
            'user_id' => $user_id,
            'notification_msg' => json_encode($notification),
            'notification_type_id' => $data_msg->notification_type_id,
            'notified_on' => now(),
        ]);

        // Call the function from PushNotificationController
        $pushNotificationController->sendNotification($user_id, $notification, $data);
    }
    public function sendOrderNotification($order_id, $status_id, $user_id = null, $reason = null)
    {
        //TODO::check userid scenarios
        $user_id = ($user_id ? $user_id : Auth::user()->id);
        $order = Order::find($order_id);
        switch ($status_id) {
            case StatusTypes::OrderShipped:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::OrderAcceptedByDP)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::OrderAcceptedByDP)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Shipped',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::OrderDelivered:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::OrderDelivered)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::OrderDelivered)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Delivered',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::OrderPlaced:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::OrderPlaced)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::OrderPlaced)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Placed',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::Success:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::PaymentSuccess)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::PaymentSuccess)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->transaction_id], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Payment Success',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'transaction_id' => $order->transaction_id,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::Failed:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::PaymentFailed)->first();
                $updatedMessage = $data_msg->notification_msg_format;
                $notification = [
                    'title' => 'Payment Failed',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'transaction_id' => $order->transaction_id,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::Cancelled:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::OrderCancelled)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::OrderCancelled)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Canceled',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::OrderCancelledByAdmin:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::OrderCancelled)->first();

                $updatedMessage = str_replace(NotificationStrReplace::OrderCancelled, $order->order_no, $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Canceled By Admin',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::InvoiceDownloaded:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::InvoiceDownloaded)->first();

                $updatedMessage = str_replace(NotificationStrReplace::InvoiceDownloaded, $order->order_no, $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Invoice Downloaded',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::OrderNotDelivered:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::OrderNotDelivered)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::OrderNotDelivered)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no, $reason], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Not Delivered',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
        }
        $pushNotificationController = new PushNotificationController();


        //TODO::Need to check this array_push
        // array_push($notification, $data);
        UserNotifications::create([
            'user_id' => $user_id,
            'notification_msg' => ($notification ? json_encode($notification) : ""),
            'notification_type_id' => $data_msg->notification_type_id,
            'notified_on' => now(),
        ]);

        // Call the function from PushNotificationController
        $pushNotificationController->sendNotification($user_id, $notification, $data);
    }

    public function sendHubNotification($order_id, $status_id, $hub_id = null, $dp_name = null, $reason = null, $surrender_order_no = null)
    {
        $user_id = $this->getUserId($hub_id, RoleTypes::Hub);
        $order = Order::find($order_id);
        switch ($status_id) {
            case StatusTypes::OrderPlaced:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::HubOrderPlaced)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::HubOrderPlaced)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Placed',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::Cancelled:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::HubOrderCancelledByCustomer)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::HubOrderCancelledByCustomer)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Cancelled',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::OrderShipped:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::HubOrderAcceptedByDP)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::HubOrderAcceptedByDP)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no, $dp_name], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Accepted',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;

            case StatusTypes::Rejected:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::HubOrderRejectedByDP)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::HubOrderRejectedByDP)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no, $dp_name], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Rejected',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::OrderDelivered:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::HubOrderDelivered)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::HubOrderDelivered)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no, $dp_name], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Delivered',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::OrderNotDelivered:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::HubOrderCouldNotDelivered)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::HubOrderCouldNotDelivered)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no, $dp_name, $reason], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Could Not Delivered',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::SurrenderApproved:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::HubSurrenderApproved)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::HubSurrenderApproved)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$surrender_order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Surrender Approved',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'surrender_id' => $surrender_order_no,
                    'type' => 'surrender'
                ];
                break;
        }
        $pushNotificationController = new PushNotificationController();

        //TODO::Need to check this array_push
        // array_push($notification, $data);
        UserNotifications::create([
            'user_id' => $user_id,
            'notification_msg' => ($notification ? json_encode($notification) : ""),
            'notification_type_id' => $data_msg->notification_type_id,
            'notified_on' => now(),
        ]);

        // Call the function from PushNotificationController
        $pushNotificationController->sendNotification($user_id, $notification, $data);
    }

    public function sendDPNotification($order_id, $status_id, $delivery_user_id = null)
    {
        $user_id = $delivery_user_id;
        $order = Order::find($order_id);
        switch ($status_id) {
            case StatusTypes::AssignedToDelivery:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::OrderAssigned)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::OrderAssigned)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Assigned',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
            case StatusTypes::Cancelled:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::HubOrderCancelledByCustomer)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::HubOrderCancelledByCustomer)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$order->order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Order Cancelled',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'order_id' => $order->order_no,
                    'type' => 'order'
                ];
                break;
        }
        $pushNotificationController = new PushNotificationController();

        //TODO::Need to check this array_push
        // array_push($notification, $data);
        UserNotifications::create([
            'user_id' => $user_id,
            'notification_msg' => ($notification ? json_encode($notification) : ""),
            'notification_type_id' => $data_msg->notification_type_id,
            'notified_on' => now(),
        ]);

        // Call the function from PushNotificationController
        $pushNotificationController->sendNotification($user_id, $notification, $data);
    }

    public function sendSurrenderNotification($surrender_id, $status_id, $user_id = null, $refund_to = null)
    {
        //TODO::check userid scenarios
        $user_id = ($user_id ? $user_id : Auth::user()->id);
        $surrender = Surrender::find($surrender_id);
        switch ($status_id) {
            case StatusTypes::SurrenderRequested:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::SurrenderRequested)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::SurrenderRequested)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$surrender->surrender_order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Surrender Request',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'surrender_id' => $surrender->surrender_order_no,
                    'type' => 'surrender'
                ];
                break;
            case StatusTypes::SurrenderApproved:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::SurrenderApproved)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::SurrenderApproved)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$surrender->surrender_order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Surrender Approved',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'surrender_id' => $surrender->surrender_order_no,
                    'type' => 'surrender'
                ];
                break;
            case StatusTypes::SurrenderRejected:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::SurrenderRejected)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::SurrenderRejected)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$surrender->surrender_order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Surrender Rejected',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'surrender_id' => $surrender->surrender_order_no,
                    'type' => 'surrender'
                ];
                break;
            case StatusTypes::SurrenderRequestCancelled:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::SurrenderRequestCancelled)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::SurrenderRequestCancelled)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$surrender->surrender_order_no], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Surrender Request Cancelled',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'surrender_id' => $surrender->surrender_order_no,
                    'type' => 'surrender'
                ];
                break;
            case StatusTypes::SurrenderCanCollected:
                $data_msg = NotificationConfig::where('notification_type_id', NotificationTypes::SurrenderCanCollected)->first();
                $notificationVariable = NotificationTypeVariables::where('notification_type_id', NotificationTypes::SurrenderCanCollected)->pluck('variables')->toArray();
                $updatedMessage = str_replace($notificationVariable, [$surrender->surrender_order_no, $refund_to], $data_msg->notification_msg_format);
                $notification = [
                    'title' => 'Surrender Can Collected',
                    'body' => $updatedMessage,
                ];
                $data = [
                    'surrender_id' => $surrender->surrender_order_no,
                    'type' => 'surrender'
                ];
                break;
        }
        $pushNotificationController = new PushNotificationController();


        //TODO::Need to check this array_push
        // array_push($notification, $data);
        UserNotifications::create([
            'user_id' => $user_id,
            'notification_msg' => ($notification ? json_encode($notification) : ""),
            'notification_type_id' => $data_msg->notification_type_id,
            'notified_on' => now(),
        ]);

        // Call the function from PushNotificationController
        $pushNotificationController->sendNotification($user_id, $notification, $data);
    }

    public function getDeliveryId($order_id)
    {
        $delivery_id = OrderDelivery::where('order_id', $order_id)
            ->where('is_notdelivered', 0)
            ->whereNull('delivered_on')
            ->pluck('id')->first();
        return ($delivery_id ? $delivery_id : 0);
    }

    public function getCustomerRating($order_id)
    {
        $customer_rating = OrderDelivery::where('order_id', $order_id)
            ->where('is_notdelivered', 0)
            ->pluck('customer_rating')->first();
        return ($customer_rating ? $customer_rating : 0);
    }
    public function checkOrderHighlighted($order_id)
    {
        $is_highlighted = OrderDelivery::where('order_id', $order_id)
            ->where('is_notdelivered', 0)
            ->pluck('is_highlighted')->first();
        return ($is_highlighted ? true : false);
    }
    public function getDPRating($delivery_user_id)
    {
        $avg_rating = OrderDelivery::where('delivery_user_id', $delivery_user_id)
            ->selectRaw('SUM(customer_rating)/COUNT(delivery_user_id) AS avg_rating')->first()->avg_rating;
        return ($avg_rating ? (int)$avg_rating : 0);
    }

    public function getDeliveryUserId($order_id, $is_delivery_attempted)
    {
        $delivery_user_id = OrderDelivery::where('order_id', $order_id)
            ->where('is_notdelivered', $is_delivery_attempted ? 1 : 0)
            // ->whereNull('delivered_on')
            ->pluck('delivery_user_id')->first();
        return ($delivery_user_id ? $delivery_user_id : 0);
    }
    public function getDeliveryPersonName($order_id, $is_delivery_attempted)
    {
        $delivery_user_id = $this->getDeliveryUserId($order_id, $is_delivery_attempted);

        $delivery_person_name = DeliveryPerson::where('id', $this->getRefId($delivery_user_id, RoleTypes::DeliveryPerson))
            ->pluck('delivery_person_name')
            ->first();

        return $delivery_person_name;
    }

    public function getDPName($delivery_person_id)
    {
        $delivery_person_id = ($delivery_person_id ? $delivery_person_id : Auth::user()->ref_id);
        $delivery_person_name = DeliveryPerson::where('id', $delivery_person_id)
            ->pluck('delivery_person_name')
            ->first();
        return $delivery_person_name;
    }

    public function getDeliveryDate($order_id, $is_delivery_attempted)
    {
        $delivery_date = OrderDelivery::where('order_id', $order_id)
            ->where('is_notdelivered', $is_delivery_attempted ? 1 : 0)
            ->pluck($is_delivery_attempted ? 'updated_at' : 'delivered_on')
            ->first();

        return $delivery_date;
    }
    public function getOrderHasEliteItems($order_id)
    {
        $is_elite = false;
        $orderDets = OrderDet::where('order_id', $order_id)->get();
        if ($orderDets) {
            foreach ($orderDets as $key => $orderDet) {
                if ($orderDet->products->productType->is_elite == 1) {
                    return $is_elite = true;
                }
            }
        }
        return $is_elite;
    }
    public function checkRetryPaymentEligibility($order_id)
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->where('id', '>', $order_id)
            ->count();
        if ($orders > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getDPList()
    {
        $deliveryPerson = DeliveryPerson::where('hub_id', Auth::user()->ref_id)->get();
        if ($deliveryPerson->count() > 0) {
            $deliveryMan = [];
            foreach ($deliveryPerson as $key => $value) {
                $delivery_user_id = $this->getUserId($value->id, RoleTypes::DeliveryPerson);
                $is_online = 1;
                if (Carbon::now()->toDateString() > Carbon::parse($value->checked_in)->toDateString()) {
                    $is_online = 0;
                    // dd(Carbon::parse($value->checked_in)->toDateString());
                    $delivery_person = DeliveryPerson::find($value->id);
                    $delivery_person->is_online = $is_online;
                    $delivery_person->checked_in = null;
                    $delivery_person->save();
                }
                $extra_items = DeliveryPersonStock::where('delivery_user_id', $delivery_user_id)->sum('extra_qty');
                $deliveryMan[] = array(
                    'id' => $value->id,
                    'delivery_person_name' => $value->delivery_person_name,
                    'mobile' => $value->mobile,
                    'delivery_person_user_id' => $this->getUserId($value->id, RoleTypes::DeliveryPerson),
                    'is_online' => ($value->checked_in ? $is_online : $value->is_online),
                    'orders_assigned' => $this->getDPAssignedOrders($value->id),
                    'orders_delivered' => $this->getDPDeliveredOrders($value->id),
                    'orders_delivered' => $this->getDPDeliveredOrders($value->id),
                    'extra_items' => (int)$extra_items,
                    'extra_items_list' => $this->getDPExtraItems($delivery_user_id)
                );
            }
        }
        return $deliveryMan;
    }

    public function getDPVehicleNo($delivery_user_id)
    {
        $vehicle_no = DeliveryPerson::join('delivery_vehicle_infos', 'delivery_vehicle_infos.delivery_people_id', 'delivery_people.id')
            ->join('hub_vehicle_infos', 'hub_vehicle_infos.id', 'delivery_vehicle_infos.hub_vehicle_info_id')
            ->where('delivery_people.id', $this->getRefId($delivery_user_id, RoleTypes::DeliveryPerson))
            ->pluck('hub_vehicle_infos.reg_no')->first();
        return $vehicle_no;
    }

    public function getDPVehicleBrand($delivery_user_id)
    {
        $vehicle_brand = DeliveryPerson::join('delivery_vehicle_infos', 'delivery_vehicle_infos.delivery_people_id', 'delivery_people.id')
            ->join('hub_vehicle_infos', 'hub_vehicle_infos.id', 'delivery_vehicle_infos.hub_vehicle_info_id')
            ->join('vehicle_brands', 'vehicle_brands.id', 'hub_vehicle_infos.vehicle_brand_id')
            ->where('delivery_people.id', $this->getRefId($delivery_user_id, RoleTypes::DeliveryPerson))
            ->pluck('vehicle_brands.brand_name')->first();
        return $vehicle_brand;
    }

    public function getDPExtraItems($delivery_user_id)
    {
        $extra_list = [];
        $extra_stocks = DeliveryPersonStock::where('delivery_user_id', $delivery_user_id)
            ->where('extra_qty', '>', 0)
            ->get();

        foreach ($extra_stocks as $key => $extra_stock) {
            $product = Products::where('id', $extra_stock->product_id)->first();
            $extra_list[] = [
                'product_id' => $extra_stock->product_id,
                'product_name' => $product->product_name,
                'qty' => $extra_stock->extra_qty,
            ];
        }
        return $extra_list;
    }

    public function getDPAssignedOrders($delivery_person_id)
    {
        //Get delivery person user id
        $delivery_user_id = $this->getUserId($delivery_person_id, RoleTypes::DeliveryPerson);
        $assigned_orders = OrderDelivery::where('delivery_user_id', $delivery_user_id)
            ->where('is_notdelivered', 0)
            ->whereNull('delivered_on')
            ->count();
        return $assigned_orders;
    }

    public function getDPDeliveredOrders($delivery_person_id)
    {
        //Get delivery person user id
        $delivery_user_id = $this->getUserId($delivery_person_id, RoleTypes::DeliveryPerson);
        $delivered_orders = OrderDelivery::where('delivery_user_id', $delivery_user_id)
            ->where('is_notdelivered', 0)
            ->whereNotNull('delivered_on')
            ->count();
        return $delivered_orders;
    }

    public function getPickupPersonName($delivery_user_id)
    {
        $pickup_person_name = DeliveryPerson::where('id', $this->getRefId($delivery_user_id, RoleTypes::DeliveryPerson))
            ->pluck('delivery_person_name')
            ->first();
        return $pickup_person_name;
    }

    public function getHubQRImage()
    {
        $hub = Hub::find(Auth::user()->ref_id);
        if ($hub) {
            $hub->qr_code_image = $this->getBaseUrl() . '/' . $hub->qr_code_image;
            return $hub->qr_code_image;
        } else {
            return "";
        }
    }

    public function getHubName($hub_id)
    {
        $hub = Hub::find($hub_id);
        return $hub->hub_name;
    }

    public function getManufactureQRImage()
    {
        $manufacture = Manufacturer::find(Auth::user()->ref_id);
        if ($manufacture) {
            $manufacture->qr_code_image = $this->getBaseUrl() . '/' . $manufacture->qr_code_image;
            return $manufacture->qr_code_image;
        } else {
            return "";
        }
    }

    public function getCartSummaryData($carts, $address_id)
    {
        $is_watercan = false;
        $sub_total = 0.00;
        $delivery_charge = 0.00;
        $additional_delivery_charge = 0.00;
        $newcan_deposit_amt = 0.00;
        $tot_qty = 0;
        $cgst = 0.00;
        $sgst = 0.00;
        $cart_summary = [];
        $cus_address = CustomerAddress::where('id', $address_id)->first();
        if ($cus_address) {
            //If lift not available and floor greater than 1 then customer have to pay additional delivery charge
            if ($cus_address->is_lift_avail_working == 0 && $cus_address->floor > 1) {
                $additional_delivery_charge = $this->getAdminSetting()->additional_delivery_charge;
            }
        }
        foreach ($carts as $cart) {
            $products = Products::with('productType')
                ->where('id', $cart->product_id)->first();

            $newcan_deposit_qty = ($cart->qty - $cart->return_empty_cans_qty);
            $tot_qty += $cart->qty;
            $sub_total = $sub_total + ($products->customer_price * $cart->qty);
            $delivery_charge = $delivery_charge + ($products->productType->delivery_charge * $cart->qty);
            $newcan_deposit_amt = $newcan_deposit_amt + ($products->productType->newcan_deposit_amt * $newcan_deposit_qty);
            $cgst = $cgst + ((($products->customer_price * $products->CGST) /  100) * $cart->qty);
            $sgst = $sgst + ((($products->customer_price * $products->SGST) / 100) * $cart->qty);
            if ($products->category->is_watercan == 1) {
                $is_watercan = true;
            }
        }

        if (!$is_watercan) {
            $additional_delivery_charge = 0.00;
        } else {
            $additional_delivery_charge = $additional_delivery_charge * $tot_qty;
        }

        $cart_summary = [
            'sub_total' => number_format((float)$sub_total, 0, '.', ''),
            'delivery_charge' => number_format((float)$delivery_charge, 0, '.', ''),
            'additional_delivery_charge' => number_format((float)$additional_delivery_charge, 0, '.', ''),
            'newcan_deposit_amt' => number_format((float)$newcan_deposit_amt, 0, '.', ''),
            'cgst' => number_format((float)$cgst, 2, '.', ''),
            'sgst' => number_format((float)$sgst, 2, '.', ''),
            'gst' => number_format((float)($cgst + $sgst), 2, '.', ''),
            'total' => number_format((float)($sub_total + $additional_delivery_charge + $delivery_charge + $newcan_deposit_amt + ($cgst + $sgst)), 0, '.', '')
        ];
        return $cart_summary;
    }

    public function getUnReadNotificationCount()
    {
        $noti_count = UserNotifications::where('user_id', Auth::user()->id)->where('is_viewed', false)->count();
        return $noti_count;
    }

    public function generateQrCode($id, $code, $module)
    {

        $temporaryFilePath = tempnam(sys_get_temp_dir(), 'qr_code');
        $temporarySvgFile = $temporaryFilePath . '.svg';
        if ($module == DocumentModulesType::Hub) {

            $qrCodeContent = 'hub_id:' . $id;

            QrCode::format('svg')->size(299)->generate($qrCodeContent, $temporarySvgFile);

            $filePath = $this->fileUpload(new File($temporarySvgFile), 'upload/hubs/' . $code, $code . '.svg');
            Hub::findOrFail($id)->update(['qr_code_image' => $filePath]);
        } else if ($module == DocumentModulesType::Manufacturer) {
            $qrCodeContent = 'manufacture_id:' . $id;

            QrCode::format('svg')->size(299)->generate($qrCodeContent, $temporarySvgFile);

            $filePath = $this->fileUpload(new File($temporarySvgFile), 'upload/Manufacture/' . $code, $code . '.svg');
            Manufacturer::findOrFail($id)->update(['qr_code_image' => $filePath]);
        }
    }

    public function addClosingBalance($amount)
    {
        $ledger = Ledger::where('ledger_type_id', 1)->first();
        if ($ledger) {
            $ledger->closing_balance = $ledger->closing_balance + $amount;
            $ledger->save();
        }
    }
    public function updateClosingBalance($amount)
    {
        $ledger = Ledger::where('ledger_type_id', 1)->first();
        if ($ledger) {
            $ledger->closing_balance = $ledger->closing_balance - $amount;
            $ledger->save();
        }
    }

    public function numberToWord($num = '')
    {
        $num    = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words  = array();

            $num    = str_replace(array(',', ' '), '', trim($num));

            $list1  = array(
                '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
            );

            $list2  = array(
                '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred'
            );

            $list3  = array(
                '', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num    = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds   = (int) ($num_part / 100);
                $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens       = (int) ($num_part % 100);
                $singles    = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words  = implode(', ', $words);

            $words  = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words  = str_replace(',', ' and', $words);
            }

            return $words;
        } else if (!((int) $num)) {
            return 'Zero';
        }
        return '';
    }

    public function generateRazorpayOrder($payment_method_id, $receipt_id, $total_amount)
    {
        $api = new Api($this->getPaymentGatewaySettings($payment_method_id)->razor_key, $this->getPaymentGatewaySettings($payment_method_id)->razor_secret);
        $order = $api->order->create([
            'receipt' => $receipt_id,
            'amount' => $total_amount * 100,
            'currency' => 'INR',
        ]);

        return $order['id'];
    }

    public function validateCart($product_details)
    {
        foreach ($product_details as $value) {
            $product = Products::where('id', $value['product_id'])->first();
            if ($product->is_active == 0) {
                return false;
            }
            if ($product->category->is_active == 0) {
                return false;
            }
            if ($product->productType->is_active == 0) {
                return false;
            }
            if ($product->brand->is_active == 0) {
                return false;
            }
        }
        return true;
    }

    public function getActiveTripId($driver_id)
    {
        $trip_id =  LogisticTrip::where('driver_id', $driver_id)
            ->where('is_active', 1)->pluck('id')->first();
        return $trip_id;
    }

    public function getActiveHubBookingId($hub_id)
    {
        $driver_id = $this->getDriverId($hub_id);
        $booking_id = LogisticBooking::join('logistic_booking_dets', 'logistic_booking_dets.logistic_booking_id', 'logistic_bookings.id')
            ->where('logistic_booking_dets.hub_id', $hub_id)
            ->where('logistic_bookings.driver_id', $driver_id)
            ->where('is_hub_confirmed', 0)
            ->where('trip_id', $this->getActiveTripId($driver_id))
            ->where('status_id', StatusTypes::LogisticReceivedfromManufacture)
            ->pluck('logistic_bookings.id')
            ->first();
        return $booking_id;
    }

    public function getDriverId($hub_id)
    {
        $driver_id = LogisticDriverInfo::whereRaw('FIND_IN_SET(?, hub_id)', [$hub_id])->pluck('id')->first();
        return $driver_id;
    }

    public function getManufactureInStock($product_id, $manufacture_id)
    {
        $in_stock = ManufactureStock::where('manufacture_id', $manufacture_id)->where('product_id', $product_id)->sum('filled_qty');
        return $in_stock;
    }
}
