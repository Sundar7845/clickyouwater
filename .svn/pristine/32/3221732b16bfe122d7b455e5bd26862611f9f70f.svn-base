<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\Offer;
use App\Models\OfferAllocation;
use App\Models\OfferCode;
use App\Models\OfferHubAllocation;
use App\Models\OfferType;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class OffersController extends Controller
{
    use common;
    public function offers(Request $request, $id = NULL)
    {
        try {
            //Get states
            $states = $this->getStates();
            //To load list based type(All,Today,ThisMonth)
            $type = $request->input('type');
            if ($id) {
                $offer = Offer::find($id);
                $offerTypes = OfferType::get();
                $offercodes = OfferCode::where('offer_id', $id)->get();
                $offerallocation = OfferAllocation::select('state_id')->where('offer_id', $id)->get()->toArray();
                // Check if $offerallocation is empty
                if (empty($offerallocation)) {
                    $getStateName = null; // or some other default value
                } else {
                    $getStateName = explode(',', $offerallocation[0]['state_id']);
                    // Check if $getStateName contains only one element
                    if (count($getStateName) == 1) {
                        $getStateName = $getStateName[0];
                    }
                }
                return view('admin.offer.offers', compact('type', 'states', 'offerTypes', 'offercodes', 'offer', 'offerallocation', 'getStateName'));
            }
            $offerTypes = OfferType::get();
            $offercodes = null;
            $offer = null;
            $offerallocation = [];
            $getStateName = [];
            return view('admin.offer.offers', compact('type', 'states', 'offerTypes', 'offercodes', 'offer', 'offerallocation', 'getStateName'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function offersCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ddlOfferType' => 'required',
            'txtOfferName' => [
                'required',
                Rule::unique('offers', 'offer_name')->WhereNull('deleted_at')->ignore($request->hdDesignationId),
            ],
            'txtStartDate' => 'required',
            'txtEndDate' => 'required|after:txtStartDate',
            'txtOffertotalPoints' => 'required',
            'txtOfferclaimPoints' => 'required',
            'tabOfferCodes' => [
                'required',
                Rule::unique('offer_codes', 'offer_code')->ignore($request->hdOfferId, 'offer_code'),
            ],
            'tabOfferCodeTypes' => 'required',
        ], [
            'txtOfferName.unique' => 'Offer name already exists.',
            'txtEndDate.after' => 'The end date must be after the start date.',
            'tabOfferCodes.unique' => 'The offer code is already exists.',
            'tabOfferCodeTypes.required' => 'The offer code type is required'
        ]);

        $notification = array(
            'message' => 'Offer Code Already Exists.',
            'alert-type' => 'error'
        );
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with($notification);
        }

        DB::beginTransaction();
        try {
            if ($request->hdOfferId == null) {

                $data = $request->all();

                $startDate = Carbon::create($request->txtStartDate); // set the start date
                $endDate = Carbon::create($request->txtEndDate); // set the end date
                $daysBetween = $endDate->diffInDays($startDate);

                $image = $request->file('OfferImage');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                image::make($image)->save('upload/offers/' . $name_gen);
                $save_url = 'upload/offers/' . $name_gen;

                $last_inserted_offer_id = Offer::insertGetId([
                    'offer_type_id' => $request->ddlOfferType,
                    'offer_name' => $request->txtOfferName,
                    'validity' => $daysBetween,
                    'offer_total_points' => $request->txtOffertotalPoints,
                    'offer_claim_points' => $request->txtOfferclaimPoints,
                    'start_date' => $request->txtStartDate,
                    'end_date' => $request->txtEndDate,
                    'offer_image_path' => $save_url,
                    'is_active' => 1,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);

                if ($request->ddlState != null) {
                    $multistates = $data['ddlState'];
                    $multistateArray = [];
                    foreach ($multistates as $method) {
                        $multistateArray[] = $method;
                    }
                    $multistateString = implode(",", $multistateArray);
                    OfferAllocation::create([
                        'offer_id' => $last_inserted_offer_id,
                        'state_id' => $multistateString,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now()
                    ]);
                }
                //common offers
                if ($request->ddlOfferType == 3) {
                    $hubsCount = Hub::count();
                    $pointsPerHub = $request->txtOffertotalPoints / $hubsCount;
                    $hubs = Hub::pluck('id')->toArray();

                    // Check if there are any existing records with the new offer_id
                    $existingRecords = OfferHubAllocation::whereIn('hub_id', $hubs)
                        ->where('offer_id', $last_inserted_offer_id)
                        ->get();

                    if ($existingRecords->count() > 0) {
                        // Update existing records with the new values
                        $existingRecords->each(function ($record) use ($pointsPerHub) {
                            $record->update([
                                'points_allocated' => $pointsPerHub,
                                'created_by' => Auth::user()->id,
                                'created_at' => Carbon::now()
                            ]);
                        });
                    } else {
                        // Create new records with the new offer_id
                        foreach ($hubs as $hub) {
                            OfferHubAllocation::create([
                                'offer_id' => $last_inserted_offer_id,
                                'hub_id' => $hub,
                                'points_allocated' => $pointsPerHub,
                                'created_by' => Auth::user()->id,
                                'created_at' => Carbon::now()
                            ]);
                        }
                    }
                }

                $offercode = $request->tabOfferCodes;
                $offercodetype = $request->tabOfferCodeTypes;

                if (count($offercode) == count($offercodetype)) {
                    for ($i = 0; $i < count($offercode); $i++) {
                        $array = array(
                            "offer_id" => $last_inserted_offer_id,
                            "offer_code" => $offercode[$i],
                            "offer_code_type" => $offercodetype[$i],
                            "created_by" => Auth::user()->id,
                        );
                        OfferCode::insert($array);
                    }
                }
                $notification = array(
                    'message' => 'Offer Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                $request->validate([
                    'ddlOfferType' => 'required',
                    'txtStartDate' => 'required',
                    'txtEndDate' => 'required',
                    'txtOffertotalPoints' => 'required',
                    'txtOfferclaimPoints' => 'required',
                ]);
                $data = $request->all();
                $startDate = Carbon::create($request->txtStartDate);
                $endDate = Carbon::create($request->txtEndDate);
                $daysBetween = $endDate->diffInDays($startDate);
                $oldImage = $request->hdOfferImg;

                if ($request->file('OfferImage')) {
                    @unlink($oldImage);
                    $image = $request->file('OfferImage');
                    $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                    Image::make($image)->save('upload/offers/' . $name_gen);
                    $save_url = 'upload/offers/' . $name_gen;
                    Offer::findorfail($request->hdOfferId)->update([
                        'offer_image_path' => $save_url,
                        'updated_by' => Auth::user()->id
                    ]);
                }
                Offer::findorfail($request->hdOfferId)->update([
                    'offer_type_id' => $request->ddlOfferType,
                    'offer_name' => $request->txtOfferName,
                    'validity' => $daysBetween,
                    'offer_total_points' => $request->txtOffertotalPoints,
                    'offer_claim_points' => $request->txtOfferclaimPoints,
                    'start_date' => $request->txtStartDate,
                    'end_date' => $request->txtEndDate,
                    'is_active' => 1,
                    'updated_by' => Auth::user()->id
                ]);
                OfferAllocation::where('offer_id', $request->hdOfferId)->delete();
                if ($request->ddlState != null) {
                    $multistates = $data['ddlState'];
                    $multistateArray = [];
                    foreach ($multistates as $method) {
                        $multistateArray[] = $method;
                    }
                    $multistateString = implode(",", $multistateArray);
                    OfferAllocation::insert([
                        'offer_id' => $request->hdOfferId,
                        'state_id' => $multistateString,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now()
                    ]);
                }

                //common offers
                if ($request->ddlOfferType == 3) {
                    $hubsCount = Hub::count();
                    $pointsPerHub = $request->txtOffertotalPoints / $hubsCount;
                    $hubs = Hub::pluck('id')->toArray();

                    // Check if there are any existing records with the new offer_id
                    $existingRecords = OfferHubAllocation::whereIn('hub_id', $hubs)
                        ->where('offer_id', $request->hdOfferId)
                        ->get();

                    if ($existingRecords->count() > 0) {
                        // Update existing records with the new values
                        $existingRecords->each(function ($record) use ($pointsPerHub) {
                            $record->update([
                                'points_allocated' => $pointsPerHub,
                                'created_by' => Auth::user()->id,
                                'created_at' => Carbon::now()
                            ]);
                        });
                    } else {
                        // Create new records with the new offer_id
                        foreach ($hubs as $hub) {
                            OfferHubAllocation::create([
                                'offer_id' => $request->hdOfferId,
                                'hub_id' => $hub,
                                'points_allocated' => $pointsPerHub,
                                'created_by' => Auth::user()->id,
                                'created_at' => Carbon::now()
                            ]);
                        }
                    }
                }

                OfferCode::where('offer_id', $request->hdOfferId)->delete();
                $offercode = $request->tabOfferCodes;
                $offercodetype = $request->tabOfferCodeTypes;

                if (count($offercode) == count($offercodetype)) {
                    for ($i = 0; $i < count($offercode); $i++) {
                        $array = array(
                            "offer_id" => $request->hdOfferId,
                            "offer_code" => $offercode[$i],
                            "offer_code_type" => $offercodetype[$i],
                            "created_by" => Auth::user()->id,
                        );
                        OfferCode::insert($array);
                    }
                }
                $notification = array(
                    'message' => 'Offer Updated Successfully',
                    'alert-type' => 'success'
                );
            }
            DB::commit(); // Commit the transaction
            return redirect()->route('offers')->with($notification);
        } catch (\Exception $e) {
            DB::rollback(); // Roll back the transaction if an error occurs
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
            return redirect()->route('offers')->with($notification);
        }
    }

    public function getOffersData(Request $request)
    {
        try {
            $offerData = Offer::select(
                'offers.*',
                'offer_types.offer_type_name',
                DB::raw("DATE_FORMAT(offers.start_date, '%d/%m/%Y %H:%i:%s %p') as formatted_start_date"),
                DB::raw("DATE_FORMAT(offers.end_date, '%d/%m/%Y %H:%i:%s %p') as formatted_end_date"),
                'offer_allocations.offer_id as allocation_offer_id',
                'offer_hub_allocations.offer_id as hub_allocation_offer_id'
            )
                ->join('offer_types', 'offer_types.id', 'offers.offer_type_id')
                ->leftJoin('offer_allocations', 'offer_allocations.offer_id', 'offers.id')
                ->leftJoin('offer_hub_allocations', 'offer_hub_allocations.offer_id', 'offers.id')
                ->groupBy('offers.id')
                ->orderBy('offers.id', 'DESC');

            // Apply type filters based on the 'type' parameter
            if ($request->type === 'today') {
                $offerData->whereDate('offers.created_at', today());
            } elseif ($request->type === 'thismonth') {
                $offerData->whereMonth('offers.created_at', now()->month);
            } elseif ($request->type === 'all') {
                $offerData = $offerData;
            }

            $offerData = $offerData->get();

            return datatables()->of($offerData)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<a href="offer/' . $row->id . '"><i class="text-primary ti ti-pencil me-1"></i></a> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->allocation_offer_id == null && $row->hub_allocation_offer_id == null) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')" onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function activeStatus($id, $status)
    {
        try {
            Offer::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
            DB::commit();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getOfferById($id)
    {
        try {
            $offer = Offer::select('offers.*', 'offer_allocations.state_id')
                ->join('offer_allocations', 'offers.offer_type_id', 'offer_allocations.offer_id')
                ->where('offers.id', $id)->first();
            return response()->json([
                'offer' => $offer
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteOffers($id)
    {
        DB::beginTransaction();
        try {
            $references = [
                OfferAllocation::class, OfferHubAllocation::class,
            ];

            $count = 0;
            foreach ($references as $reference) {
                $count += $reference::where('offer_id', $id)->count();
            }

            if ($count === 0) {
                $offer = Offer::where('id', $id)->delete();
                $offerAllocation = OfferAllocation::where('offer_id', $id)->delete();
                $offerCodes = OfferCode::where('offer_id', $id)->delete();

                Offer::where('id', $id)->update([
                    'deleted_by' => Auth::user()->id
                ]);
                OfferAllocation::where('offer_id', $id)->update([
                    'deleted_by' => Auth::user()->id
                ]);
                OfferCode::where('offer_id', $id)->update([
                    'deleted_by' => Auth::user()->id
                ]);
                $notification = array(
                    'message' => 'Offer Deleted Successfully',
                    'alert' => 'success'
                );
            } else {
                $notification = [
                    'message' => 'Offer Could Not Be Deleted!',
                    'alert' => 'error'
                ];
            }
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Offer could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }
}
