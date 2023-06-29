<?php

namespace App\Http\Controllers\API;

use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserAddressResource;
use App\Models\AddressType;
use App\Models\CustomerAddress;
use App\Models\CustomerNearestHub;
use App\Models\Hub;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\Common;
use App\Traits\Maps;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    use Common;
    use Maps;
    use ResponseAPI;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkServiceAvailable(Request $request)
    {
        try {
            $hub_id = $this->getServiceAvailable($request->latitude, $request->longitude, $request->state_id, $request->city_id);

            $message = ($hub_id ? "Service available in this area" : "Service not available in this area");
            $response = [
                'hub_id' => $hub_id,
                'status' => ($hub_id ? true : false),
                'message' => $message,
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }

    public function addEditAddress(Request $request, $id = Null)
    {
        $validatedData = $request->validate([
            'addresstype_id' => 'required',
            'building_no' => 'required',
            'street' => 'required',
            'area' => 'required',
            'landmark' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'pincode' => 'required',
            'floor' => 'required',
            'is_lift_avail_working' => 'required',
            'contact_person_name' => 'required',
            'contact_person_mobile' => 'required',
        ]);
        DB::beginTransaction();

        // longitude
        // geolocation
        // apikey=AIzaSyCxSrT3mnTnRnbUSW1DGhTKAu2kGpdgm5Y
        try {
            // if ($request->latitude == '' || $request->latitude == null && $request->longitude == '' || $request->longitude == null) {

            //     $address = $request->building_no . ' ' . $request->street . ' ' . $request->area . ' ' . $request->city_name . ' ' . $request->state_name . ' ' . $request->country_name;
            //     $mapDetails = $this->getMapDetails();

            //     $apiKey = $mapDetails->api_key;

            //     $response = Http::get($mapDetails->api_url, [
            //         'address' => urlencode($address),
            //         'key' => $apiKey,
            //     ]);
            //     $location = $response->json()['results'][0]['geometry']['location'];

            //     $request['latitude'] = $location['lat'];
            //     $request['longitude'] = $location['lng'];
            // }

            $request['customer_id'] = $this->getRefId(Auth::user()->id, RoleTypes::Customer);
            $hub_id = $request->hub_id;
            unset($request['country_name']);
            unset($request['city_name']);
            unset($request['state_name']);
            unset($request['hub_id']);
            if ($id != null) {
                unset($request['customer_id']);
                $request['updated_by'] = Auth::user()->id;

                $address = CustomerAddress::find($id);
                $address->update($request->all());

                if ($hub_id != null) {
                    $customer_nearest_hub = CustomerNearestHub::where('hub_id', $hub_id)->first();
                    if ($customer_nearest_hub) {
                        $hub = Hub::where('id', $hub_id)->first();
                        $hub_location = $hub['latitude'] . ',' . $hub['longtitude'];
                        $cus_location = $request->latitude . ',' . $request->longitude;
                        $distance = $this->getDistance($cus_location, $hub_location);

                        CustomerNearestHub::findorfail($customer_nearest_hub->id)->update([
                            'distance' => $distance
                        ]);
                    }
                }
                $response = [
                    'status' => true,
                    'message' => "Address Updated Successfully",
                    'data' => $id,
                ];
            } else {
                $addresses = CustomerAddress::where('customer_id', $this->getRefId(Auth::user()->id, RoleTypes::Customer))->get();
                if ($addresses->count() > 0) {
                    $request['is_default'] = 0;
                } else {
                    $request['is_default'] = 1;
                }
                $request['created_by'] = Auth::user()->id;
                $last_inserted_address_id = CustomerAddress::insertGetId($request->all());

                if ($hub_id != null) {
                    $hub = Hub::where('id', $hub_id)->first();
                    $hub_location = $hub['latitude'] . ',' . $hub['longtitude'];
                    $cus_location = $request->latitude . ',' . $request->longitude;
                    $distance = $this->getDistance($cus_location, $hub_location);

                    CustomerNearestHub::create([
                        'customer_address_id' => $last_inserted_address_id,
                        'hub_id' => $hub_id,
                        'distance' => $distance
                    ]);
                }
                $response = [
                    'status' => true,
                    'message' => "Address added Successfully",
                    'data' => $last_inserted_address_id,
                ];
            }

            DB::commit(); // Commit the transaction
            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollback(); // Roll back the transaction if an error occurs
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), Auth::user()->id, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }

    public function getCustomerAddress($id = Null)
    {
        try {
            // dd($this->getCustomerNearestHub(1));
            // dd($this->getCustomerAddress_details($id));
            $customer_address = $this->getCustomerAddress_details($id);

            $customer_address = UserAddressResource::collection($customer_address);
            foreach ($customer_address as $address) {
                $order = Order::where('delivery_address_id', $address->id)->where('user_id', Auth::user()->id)->first();
                $address->is_order = ($order != null ? true : false);
            }

            $response = [
                'status' => true,
                'data' => $customer_address,
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    public function setDefaultAddress($id)
    {
        DB::beginTransaction();

        try {

            $addresses = CustomerAddress::where('customer_id', $this->getRefId(Auth::user()->id, RoleTypes::Customer))->update(['is_default' => 0]);

            $address = CustomerAddress::find($id);
            $address->is_default = 1;
            $address->save();
            $res = UserAddressResource::collection($this->getCustomerAddress_details());
            DB::commit(); // Commit the transaction

            $response = [
                'status' => true,
                'message' => "Updated Successfully",
                'data' => $res,
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollback(); // Roll back the transaction if an error occurs
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    public function getState($id = 1)
    {

        try {

            $response = [
                'status' => true,
                'data' => $this->getStates($id),
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    public function deleteAddress($id)
    {
        # code...


        DB::beginTransaction();

        try {
            $address = CustomerAddress::find($id);
            if ($address->is_default == 1) {
                $address_default = CustomerAddress::where('customer_id', Auth::user()->id)->first();
                $address_default->is_default = 1;
                $address_default->save();
            }
            if ($address) {
                $address->is_default = 0;
                $address->deleted_by = Auth::user()->id;
                $address->delete();
            }
            DB::commit(); // Commit the transaction

            $response = [
                'status' => true,
                'message' => "Deleted Successfully",
                'data' => []
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            DB::rollback(); // Roll back the transaction if an error occurs
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }

    public function getCitie($id = NULL)
    {
        try {

            $response = [
                'status' => true,
                'data' => $this->getCities($id),
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    public function getArea($id = NULL)
    {
        try {

            $response = [
                'status' => true,
                'data' => $this->getAreas($id),
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAddressType()
    {
        try {
            $adress_type = AddressType::all();
            $response = [
                'status' => true,
                'data' => $adress_type,
            ];
            return response($response, 200);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, request()->method(), $e->getMessage(), 1, request()->ip(), gethostname(), 1);
            // return $this->error($e->getMessage(), 200);
            $response = array(
                'message' => $this->errorMessage,
                'status' => false,
            );
            return response($response, 500);
        }
    }
}
