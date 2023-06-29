<?php

namespace App\Http\Controllers\Admin\HubManagement;

use App\Enums\DocumentModulesType;
use App\Enums\MenuPermissionType;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\DeliveryVehicleInfo;
use App\Models\Hub;
use App\Models\HubDocuments;
use App\Models\HubManufactureConfig;
use App\Models\Manufacturer;
use App\Traits\Common;
use App\Traits\Maps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\FuelType;
use App\Models\HubVehicleInfo;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Illuminate\Support\Facades\Validator;

class HubController extends Controller
{
    use Common, Maps;
    public function hub($id = NULL)
    {
        try {
            //Get manufacture
            $manufacture = Manufacturer::select('id', 'manufacturer_name')->where('is_active', 1)->get();
            //Get hub documents
            // $documents = $this->getDocumentsByModule(DocumentModulesType::Hub);
            //Get states
            $states = $this->getStates();
            $hub =  null;
            $hubmanfconfiq = [];
            $bindDocuments = $this->getDocumentConfigsByModule(DocumentModulesType::Hub, $id);
            if ($bindDocuments->isEmpty()) {
                $bindDocuments = $this->getDocumentsByModule(DocumentModulesType::Hub);
            }
            //Get fuel types from default table
            $fueltypes = FuelType::select('id', 'fuel_type')->get();
            //Get vehicle types from default table
            $vehicletypes = VehicleType::select('id', 'vehicle_type')->get();
            if ($id) {
                $rdx = 1;
                //Get hub by id
                $hub = Hub::selectRaw("*,ST_AsText(ST_Centroid(`geo_coordinates`)) as center")->findOrFail($id);

                //Get Cities against state
                $cities = $this->getCities($hub->state_id);
                //Get Areas against city
                $areas = $this->getAreas($hub->city_id);

                //Get hub vehicle infos
                $hubvehicleinfo = HubVehicleInfo::select(
                    'hub_vehicle_infos.*',
                    'fuel_types.fuel_type',
                    'vehicle_types.vehicle_type',
                    'vehicle_brands.brand_name'
                )
                    ->join('fuel_types', 'fuel_types.id', 'hub_vehicle_infos.fuel_type_id')
                    ->join('vehicle_types', 'vehicle_types.id', 'hub_vehicle_infos.vehicle_type_id')
                    ->join('vehicle_brands', 'vehicle_brands.id', 'hub_vehicle_infos.vehicle_brand_id')
                    ->where('hub_id', $id)
                    ->get();

                $delivery_vehicle_info = DeliveryVehicleInfo::select('delivery_vehicle_infos.hub_vehicle_info_id')
                    ->join('hub_vehicle_infos', 'hub_vehicle_infos.id', 'delivery_vehicle_infos.hub_vehicle_info_id')
                    ->join('hubs', 'hubs.id', 'hub_vehicle_infos.hub_id')
                    ->where('hubs.id', $id)
                    ->get()
                    ->count();

                //Get hub manufacture config data
                $hubmanfconfiq = HubManufactureConfig::where('hub_id', $id)->pluck('manufacturer_id')->first();

                $hub_auto_code = $hub->hub_code;

                // $response = $this->getServiceAvailable(11.064238,77.001811);

                //Get hub documents against config
                // $bindDocuments = $this->getDocumentConfigsByModule(DocumentModulesType::Hub, $id);
                return view('admin.hub_management.hub_edit', compact('states', 'bindDocuments', 'fueltypes', 'vehicletypes', 'hub', 'hub_auto_code', 'hubmanfconfiq', 'cities', 'areas', 'manufacture', 'hubvehicleinfo', 'rdx', 'delivery_vehicle_info'));
            }
            $hubvehicleinfo = null;
            //Get auto generated code for hub
            $hub_auto_code = $this->getAutoGeneratedCode(DocumentModulesType::Hub);
            return view('admin.hub_management.hub', compact('states', 'hub', 'bindDocuments', 'hub_auto_code', 'hubmanfconfiq', 'manufacture', 'fueltypes', 'vehicletypes', 'hubvehicleinfo'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function hubCreate(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "txthubId" => 'required',
                "txthubName" => 'required',
                "manufacturerId" => 'required',
                "txtYrsofExp" => 'required',
                "txtMobile" => 'required|numeric|digits:10|unique:hubs,mobile',
                "txtofficialEmail" => 'required|email|unique:hubs,official_email',
                "txtlatitude" => 'required',
                "txtlangtitute" => 'required',
                "txtgeolocation" => 'required',
                // "txtRadius" => 'required',
                //  "txtcoordinates" => 'required',
                "txtcreditPeriod" => 'required',
                "txtsettlementPeriod" => 'required',
                "txtsecurityDeposit" => 'required',
                // 'password' => 'required|min:6|confirmed',
                "ddlState" => 'required',
                "ddlCity" => 'required',
                "ddlArea" => 'required',
                "txtLandmark" => 'required',
                "txtpinCode" => 'required',
                "txtProprietorName" => 'required',
                "txtProprietorMobile" => 'required|numeric|digits:10',
                "txtProprietorEmail" => 'required|email',
                "txtContactPersonName" => 'required',
                "txtContactPersonMobile" => 'required|numeric|digits:10',
                "txtContactPersonEmail" => 'required|email'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            //Create New Area Or Get Area ID
            $area_id = $this->getOrCreateAreaId($request->ddlArea, $request->ddlState, $request->ddlCity);

            //Validate the documents for hub
            $is_valid = $this->validateDocuments($request, DocumentModulesType::Hub);

            if (isset($is_valid->documentType->documenttype_name)) {
                $notification = array(
                    'message' => $is_valid->documentType->documenttype_name . ' Required',
                    'alert-type' => 'error'
                );
                return redirect()->route('hub')->with($notification);
            }

            $value = $request->txtcoordinates;
            foreach (explode('),(', trim($value, '()')) as $index => $single_array) {
                if ($index == 0) {
                    $lastcord = explode(',', $single_array);
                }
                $coords = explode(',', $single_array);
                $polygon[] = new Point($coords[0], $coords[1]);
            }
            $polygon[] = new Point($lastcord[0], $lastcord[1]);
            $geo_coordinates = new Polygon([new LineString($polygon)]);

            $data = $request->all();
            $last_inserted_hub_id = Hub::insertGetId([
                "hub_code" => $request->txthubId,
                "hub_name" => $request->txthubName,
                "years_of_experience" => $request->txtYrsofExp,
                "mobile" => $request->txtMobile,
                "official_email" => $request->txtofficialEmail,
                "latitude" => $request->txtlatitude,
                "longtitude" => $request->txtlangtitute,
                "geo_location" => $request->txtgeolocation,
                // "geo_coordinates" => $geo_coordinates,
                // "radius" => $request->txtRadius,
                "credit_period" => $request->txtcreditPeriod,
                "settlement_period" => $request->txtsettlementPeriod,
                "security_deposit" => $request->txtsecurityDeposit,
                // 'password' => Hash::make($request->password),
                "state_id" => $request->ddlState,
                "city_id" => $request->ddlCity,
                "area_id" => $area_id,
                "address" => $request->txtLandmark,
                "pincode" => $request->txtpinCode,
                "is_active" => 0,
                "proprietor_name" => $request->txtProprietorName,
                "proprietor_mobile" => $request->txtProprietorMobile,
                "proprietor_email" => $request->txtProprietorEmail,
                "contact_person_name" => $request->txtContactPersonName,
                "contact_person_mobile" => $request->txtContactPersonMobile,
                "contact_person_email" => $request->txtContactPersonEmail,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);

            $hub_coords = Hub::findOrfail($last_inserted_hub_id)->update([
                'geo_coordinates' => $geo_coordinates
            ]);
            //Create hub manufacture config
            $this->createHubManufactureConfig($data['manufacturerId'], $request->txtlatitude, $request->txtlangtitute, $last_inserted_hub_id);

            //Create hub vehicle info
            $fueltype = $request->tabFuel;
            $vehicletypes = $request->tabVehicleType;
            $vehiclebrands = $request->tabVehicleBrand;
            $regnos = $request->tabRegNo;

            if (
                count($fueltype) == count($vehicletypes) &&
                count($vehicletypes) == count($vehiclebrands) &&
                count($vehiclebrands) == count($regnos)
            ) {
                $data = [];
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                for ($i = 0, $count = count($fueltype); $i < $count; $i++) {
                    $data[] = [
                        "hub_id" => $last_inserted_hub_id,
                        "fuel_type_id" => $fueltype[$i],
                        "vehicle_type_id" => $vehicletypes[$i],
                        "vehicle_brand_id" => $vehiclebrands[$i],
                        "reg_no" => $regnos[$i]
                    ];
                }
                HubVehicleInfo::insert($data);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            //Get hub documents from config table
            $configDocuments = $this->getDocumentsByModule(DocumentModulesType::Hub);

            //Create hub documents in create mode
            $this->createHubDocuments($request, $configDocuments, $last_inserted_hub_id);

            //Increase hublive count in settings table
            $this->updateLiveCount(DocumentModulesType::Hub, 1);

            //Create hub user account for login
            $this->createUser(
                $request->txtMobile,
                $request->txtofficialEmail,
                $request->txtMobile,
                $last_inserted_hub_id,
                $request->txthubName,
                $request->txtMobile,
                RoleTypes::Hub,
                1,
                Auth::user()->id
            );

            //Create QR Code for Manufacturer
            $this->generateQrCode($last_inserted_hub_id, $request->txthubId, DocumentModulesType::Hub);

            DB::commit(); // Commit the transaction
            $notification = array(
                'message' => 'Hub Created Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('hub-list')->with($notification);
        } catch (\Exception $e) {
            DB::rollback(); // Roll back the transaction if an error occurs
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
            return redirect()->route('hub')->with($notification);
        }
    }

    private function createHubManufactureConfig($manufacture_id, $hub_lat, $hub_lng, $hub_id)
    {
        $hmconfig = [];
        $manufacture = Manufacturer::where('id', $manufacture_id)->first();
        $mf_location = $manufacture['latitude'] . ',' . $manufacture['longtitude'];
        $hub_location = $hub_lat . ',' . $hub_lng;
        $distance = $this->getDistance($mf_location, $hub_location);
        $hmconfig[] = [
            'hub_id' => $hub_id,
            'manufacturer_id' => $manufacture_id,
            'distance' => $distance
        ];
        // }
        HubManufactureConfig::insert($hmconfig);
    }

    public function hubUpdate(Request $request)
    {

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                "txthubId" => 'required',
                "txthubName" => 'required',
                "manufacturerId" => 'required',
                "txtYrsofExp" => 'required',
                "txtMobile" => 'required|numeric|digits:10|unique:hubs,mobile,' . $request->id,
                "txtofficialEmail" => 'required|email|unique:hubs,official_email,' . $request->id,
                "txtlatitude" => 'required',
                "txtlangtitute" => 'required',
                "txtgeolocation" => 'required',
                "txtcoordinates" => 'required',
                // "txtRadius" => 'required',
                "txtcreditPeriod" => 'required',
                "txtsettlementPeriod" => 'required',
                "txtsecurityDeposit" => 'required',
                // 'password' => 'required|min:6|confirmed',
                "ddlState" => 'required',
                "ddlCity" => 'required',
                "ddlArea" => 'required',
                "txtLandmark" => 'required',
                "txtpinCode" => 'required',
                "txtProprietorName" => 'required',
                "txtProprietorMobile" => 'required|numeric|digits:10',
                "txtProprietorEmail" => 'required|email',
                "txtContactPersonName" => 'required',
                "txtContactPersonMobile" => 'required|numeric|digits:10',
                "txtContactPersonEmail" => 'required|email'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            //Create New Area Or Get Area ID
            $area_id = $this->getOrCreateAreaId($request->ddlArea, $request->ddlState, $request->ddlCity);

            //Validate the documents for hub
            $is_valid = $this->validateUpdateDocuments($request, DocumentModulesType::Hub, $request->id);

            if ($is_valid !== true) {
                if ($is_valid->document_number == null || $is_valid->document_path == null) {
                    $notification = array(
                        'message' => $is_valid->documentType->documenttype_name . ' Required',
                        'alert-type' => 'error'
                    );
                    return redirect()->route('hub', $request->id)->with($notification);
                }
            }

            $value = $request->txtcoordinates;
            foreach (explode('),(', trim($value, '()')) as $index => $single_array) {
                if ($index == 0) {
                    $lastcord = explode(',', $single_array);
                }
                $coords = explode(',', $single_array);
                $polygon[] = new Point($coords[0], $coords[1]);
            }
            $polygon[] = new Point($lastcord[0], $lastcord[1]);
            $geo_coordinates = new Polygon([new LineString($polygon)]);

            $data = $request->all();
            Hub::findorfail($request->id)->update([
                "hub_code" => $request->txthubId,
                "hub_name" => $request->txthubName,
                "years_of_experience" => $request->txtYrsofExp,
                "mobile" => $request->txtMobile,
                "official_email" => $request->txtofficialEmail,
                "latitude" => $request->txtlatitude,
                "longtitude" => $request->txtlangtitute,
                "geo_location" => $request->txtgeolocation,
                // "geo_coordinates" => $geo_coordinates,
                // "radius" => $request->txtRadius,
                "credit_period" => $request->txtcreditPeriod,
                "settlement_period" => $request->txtsettlementPeriod,
                "security_deposit" => $request->txtsecurityDeposit,
                // 'password' => Hash::make($request->password),
                "state_id" => $request->ddlState,
                "city_id" => $request->ddlCity,
                "area_id" => $area_id,
                "address" => $request->txtLandmark,
                "pincode" => $request->txtpinCode,
                "proprietor_name" => $request->txtProprietorName,
                "proprietor_mobile" => $request->txtProprietorMobile,
                "proprietor_email" => $request->txtProprietorEmail,
                "contact_person_name" => $request->txtContactPersonName,
                "contact_person_mobile" => $request->txtContactPersonMobile,
                "contact_person_email" => $request->txtContactPersonEmail,
                'updated_by' => Auth::user()->id
            ]);

            $hub_coords = Hub::findOrfail($request->id)->update([
                'geo_coordinates' => $geo_coordinates
            ]);

            // Delete existing records
            HubManufactureConfig::where('hub_id', $request->id)->delete();

            //Create hub manufacture config
            $this->createHubManufactureConfig($data['manufacturerId'], $request->txtlatitude, $request->txtlangtitute, $request->id);

            // Delete existing records
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            HubVehicleInfo::where('hub_id', $request->id)->delete();

            //Create hub vehicle info
            $fueltype = $request->tabFuel;
            $vehicletypes = $request->tabVehicleType;
            $vehiclebrands = $request->tabVehicleBrand;
            $regnos = $request->tabRegNo;

            $count = count($fueltype);
            $data = [];
            for ($i = 0; $i < $count; $i++) {
                HubVehicleInfo::where('hub_id', $request->id)->updateorcreate([
                    "hub_id" => $request->id,
                    "fuel_type_id" => $fueltype[$i],
                    "vehicle_type_id" => $vehicletypes[$i],
                    "vehicle_brand_id" => $vehiclebrands[$i],
                    "reg_no" => $regnos[$i]
                ]);
                HubVehicleInfo::whereNotIn('reg_no', $regnos)->where('hub_id', $request->id)->delete();
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            }

            $hub_documents = $this->getDocumentConfigsByModule(DocumentModulesType::Hub, $request->id);

            $configDocuments = $this->getDocumentsByModule(DocumentModulesType::Hub);

            foreach ($hub_documents as $doc) {
                if ($request->hasFile('file_' . $doc->id)) {
                    @unlink($doc->document_path);
                }
            }

            // Delete existing records
            HubDocuments::where('hub_id', $request->id)->delete();

            //Create hub documents in edit mode
            $this->createHubDocuments($request, $hub_documents == null ? $hub_documents : $configDocuments, $request->id);

            //Create QR Code for Hub
            $this->generateQrCode($request->id, $request->txthubId, DocumentModulesType::Hub);

            //Update hub user account for login
            $this->updateUser(
                $request->txtMobile,
                $request->txtofficialEmail,
                $request->txtMobile,
                $request->id,
                $request->txthubName,
                $request->txtMobile,
                RoleTypes::Hub,
                1,
                Auth::user()->id
            );

            DB::commit(); // Commit the transaction
            $notification = array(
                'message' => 'Hub Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('hub-list')->with($notification);
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
            return redirect()->route('hub', $request->id)->with($notification);
        }
    }

    private function createHubDocuments(Request $request, $documents, $hub_id)
    {
        try {
            foreach ($documents as $doc) {
                if ($request->hasFile('file_' . $doc->id)) {
                    $path = $request->file('file_' . $doc->id)->store('temp');
                    $file = $request->file('file_' . $doc->id);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $this->generateRandom(16) . '.' . $extension;
                }
                $doc_no = 'doc_' . $doc->id;
                $existingfile_path = 'hdDocumentImg_' . $doc->id;

                $documentPath = null;
                if ($request->hasFile('file_' . $doc->id)) {
                    $documentPath = $this->fileUpload($file, 'upload/hubs/' . $request->txthubId, $fileName);
                } elseif ($request->$existingfile_path != null) {
                    $documentPath = $request->$existingfile_path;
                }

                if ($documentPath !== null) {
                    HubDocuments::create([
                        'hub_id' => $hub_id,
                        'documenttype_id' => $doc->documenttype_id,
                        'documentmodule_id' => $doc->documentmodule_id,
                        'document_path' => $documentPath,
                        'document_number' => $request->$doc_no
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
    }

    public function deleteHub($id)
    {
        DB::beginTransaction();
        try {
            $hub = Hub::findorfail($id);
            $hub->delete();

            $hub->Update([
                'deleted_by' => Auth::user()->id
            ]);

            //In activate user
            $this->inactiveUser($id, RoleTypes::Hub);

            $notification = array(
                'message' => 'Hub Deleted Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Hub could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function activeHubStatus($id, $status)
    {
        DB::beginTransaction();
        try {
            if ($status == 0) {
                Hub::findorfail($id)->update([
                    'is_active' => $status,
                    'updated_by' => Auth::user()->id
                ]);
                //In active user account
                $this->inactiveUser($id, RoleTypes::Hub);
            } else {
                //Check hub activation based on the delivery person and logistic partner
                $this->hubActivation($id);
                $hub_current_status = Hub::where('id', $id)->value('is_active');

                if ($status != $hub_current_status) {
                    $returnActivation = [
                        'message' => 'Hub status did not change. You are creating a logistic partner and delivery person.',
                        'alert' => 'returnActivation'
                    ];

                    return response()->json([
                        'returnActivation' => $returnActivation
                    ]);
                }
                //Activate User
                $this->activeUser($id, RoleTypes::Hub);
            }
            DB::commit();
            // return view('admin.hub_management.hublist', compact('type', 'states'));
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function hubList(Request $request)
    {
        try {
            //Get states
            $states = $this->getStates();
            //To load list based type(All,Today,ThisMonth)
            $type = $request->input('type');
            return view('admin.hub_management.hublist', compact('type', 'states'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getHubCoordinates(Request $request)
    {
        try {

            $hub_coordinates = Hub::where('geo_coordinates', '!=', null)->get();


            $data = [];
            foreach ($hub_coordinates as $hubs) {
                $data[] = $this->format_coordiantes($hubs->geo_coordinates[0]);
            }
            return response()->json($data);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function hubData(Request $request)
    {
        try {
            $hubData = "";
            $query = Hub::join('hub_manufacture_configs', 'hub_manufacture_configs.hub_id', 'hubs.id')
                ->join('manufacturers', 'manufacturers.id', 'hub_manufacture_configs.manufacturer_id')
                ->leftJoin('delivery_people', 'delivery_people.hub_id', 'hubs.id')
                ->leftJoin('logistics_hub_configs', 'logistics_hub_configs.hub_id', 'hubs.id')
                ->leftjoin('hub_documents', 'hub_documents.hub_id', 'hubs.id')
                ->select(
                    'hubs.*',
                    'hub_documents.document_path',
                    'manufacturers.manufacturer_name',
                    DB::raw('COUNT(delivery_people.id) as delivery_people_count'),
                    'logistics_hub_configs.hub_id as log_hub_id',
                    'delivery_people.hub_id as dp_hub_id'
                )
                ->groupBy('hubs.id', 'manufacturers.manufacturer_name')
                ->whereNull('hubs.deleted_at')
                ->distinct();

            if ($request->state_id > 0) {
                $query = $query->where('hubs.state_id', $request->state_id);
            }
            if ($request->city_id > 0) {
                $query = $query->where('hubs.city_id', $request->city_id);
            }
            if ($request->area_id > 0) {
                $query = $query->where('hubs.area_id', $request->area_id);
            }

            // Apply type filters based on the 'type' parameter
            if ($request->type === 'today') {
                $query = $query->whereDate('hubs.created_at', today());
            } elseif ($request->type === 'thismonth') {
                $query = $query->whereMonth('hubs.created_at', now()->month);
            }

            $hubData = $query->get();

            return datatables()->of($hubData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<a href="hub/' . $row->id . '"><i class="text-primary ti ti-pencil me-1" onclick = "doEditvehicle(' . $row->id . ');"></i></a> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->log_hub_id == null && $row->dp_hub_id == null) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confirm-color' . $row->id . '" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })
                ->addColumn('delivery_people_count', function ($row) {
                    return $row->delivery_people_count ?? 0;
                })
                ->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getVehicleInfo($id)
    {

        $hubvehicleinfo = HubVehicleInfo::select('hub_vehicle_infos.*')->where('hub_vehicle_infos.hub_id', $id)->first();
        return response()->json([
            'hubvehicleinfo' => $hubvehicleinfo
        ]);
    }

    public function hubDocument($id)
    {
        try {
            $documentTitle = $this->documentTitle(DocumentModulesType::Hub);
            $documents = $this->documentByUsers(DocumentModulesType::Hub, $id);
            $documentmodule_id = DocumentModulesType::Hub;
            $hubDetails = Hub::with('area', 'city', 'state')
                ->where('id', $id)
                ->first();
            $userCode = $hubDetails->hub_code;
            $userName = $hubDetails->hub_name;
            $userMobile = $hubDetails->mobile;
            $userActiveStatus = $hubDetails->is_active;
            $userAddress = $hubDetails->address . ','
                . $hubDetails->area->area_name . ','
                . $hubDetails->city->city_name . ','
                . $hubDetails->state->state_name . '-'
                . $hubDetails->pincode;
            return view('admin.documents.documents', compact(
                'documents',
                'documentTitle',
                'documentmodule_id',
                'userCode',
                'userName',
                'userMobile',
                'userAddress',
                'userActiveStatus'
            ));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function verifyDocument($id, $status)
    {
        try {
            $this->updateDocumentVerification(DocumentModulesType::Hub, $id, $status);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getBrands(Request $request)
    {

        $data = VehicleBrand::where("fuel_type_id", $request->fuel_type_id)->orderBy('brand_name', 'asc')->get(["brand_name", "id"]);

        return response()->json($data);
    }

    public function getManufacturer(Request $request)
    {
        try {
            $manufacturer = Manufacturer::where("state_id", $request->state_id)->where("city_id", $request->city_id)->where('is_active', 1)->whereNull('deleted_at')->get();

            $manufacturerData = [];
            foreach ($manufacturer as $value) {
                $mf_location = $value['latitude'] . ',' . $value['longtitude'];
                $hub_location = $request->latitude . ',' . $request->longtitude;
                $distance = $this->getDistance($mf_location, $hub_location);

                $hub = HubManufactureConfig::where('manufacturer_id', $value->id)->get();
                $hub_count = $hub->count();
                $manufacturerData[] = [
                    'manufacturer_id' => $value->id,
                    'manufacturer_name' => $value->manufacturer_name,
                    'address' => $value->geo_location,
                    'distance' => $distance,
                    'hub_count' => $hub_count
                ];
            }
            return response()->json($manufacturerData);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}