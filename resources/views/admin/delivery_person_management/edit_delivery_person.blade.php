@extends('layouts.main_master')
@section('content')
@section('title')
    Edit Delivery Person | Click Your Order | Dashboard
@endsection
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Edit Delivery Person
    </h4>
    <form action="{{ route('deliverypersoncreate') }}" method="POST" name="delivery_person_edit"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="hdDelPerId" id="hdDelPerId" value="{{ $deliveryPerson ? $deliveryPerson->id : '' }}">
        <input type="hidden" name="hdDeliveryPerImg" id="hdBrandImg"
            value="{{ $deliveryPerson->delivery_person_image ?? '' }}">
        <div class="row mb-4">
            <!-- Browser Default -->
            <div class="col-md-12 mb-4 mb-md-0">
                <div class="login-form">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="txtDeliveryPersonId" class="form-label">Delivery Person ID<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="txtDeliveryPersonId"
                                            id="txtDeliveryPersonId" value="{{ $delExample }}" readonly />
                                        @if ($errors->has('txtDeliveryPersonId'))
                                            <div class="text-danger">{{ $errors->first('txthubId') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Delivery Person Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="txtDeliveryPersonName"
                                            id="txtDeliveryPersonName" placeholder="Delivery Person Name"
                                            value="@isset($deliveryPerson){{ $deliveryPerson ? $deliveryPerson->delivery_person_name : '' }}@endisset"
                                            title="Enter Delivery Person Name" required />
                                        @if ($errors->has('txtDeliveryPersonName'))
                                            <div class="text-danger">{{ $errors->first('txtDeliveryPersonName') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Mobile<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control mobilenumber"
                                            name="txtDeliveryPersonMobile" id="txtDeliveryPersonMobile"
                                            placeholder="Mobile"
                                            value="@isset($deliveryPerson){{ $deliveryPerson ? $deliveryPerson->mobile : '' }}@endisset"
                                            title="Enter mobile number" required />

                                        @if ($errors->has('txtDeliveryPersonMobile'))
                                            <div class="text-danger">{{ $errors->first('txtDeliveryPersonMobile') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="deliveryPersonEmail"
                                            id="deliveryPersonEmail" placeholder="Email"
                                            value="@isset($deliveryPerson){{ $deliveryPerson ? $deliveryPerson->email : '' }}@endisset"
                                            title="Enter Email" required />
                                        @if ($errors->has('deliveryPersonEmail'))
                                            <div class="text-danger">{{ $errors->first('deliveryPersonEmail') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Hub Name<span class="text-danger">*</span></label>
                                        <select name="ddlHub" id="ddlHub" class="select2 form-select"
                                            title="Select Hub Name" required>
                                            <option value="">Select</option>
                                            @if (!empty($hubs))
                                                @foreach ($hubs as $hub)
                                                    <option value="{{ $hub->id }}"
                                                        @if ($deliveryPerson->hub_id == $hub->id) selected @endif>
                                                        {{ $hub->hub_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('ddlHub'))
                                            <div class="text-danger">{{ $errors->first('ddlHub') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Vehicle<span class="text-danger">*</span></label>
                                        <select name="ddlVehicle[]" id="ddlVehicle" class="select2 form-select"
                                            title="Select Vehicle" multiple required>
                                            @isset($deliveryVehicleInfo)
                                                @foreach ($deliveryVehicleInfo as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ in_array($item->id, $deliveryVehicleConfiq) ? 'selected' : '' }}>
                                                        {{ $item->reg_no }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        @if ($errors->has('ddlVehicle'))
                                            <div class="text-danger">{{ $errors->first('ddlVehicle') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>

                                {{-- <div class="col-md-4">
                                    <div class="mb-3 form-password-toggle">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="******" />
                                            <span class="input-group-text cursor-pointer">
                                                <i class="ti ti-eye-off"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="text-danger">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3 form-password-toggle">
                                        <label class="form-label" for="password_confirmation">Confirm
                                            Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" class="form-control" name="password_confirmation"
                                                id="password_confirmation" placeholder="******" />
                                            <span class="input-group-text cursor-pointer">
                                                <i class="ti ti-eye-off"></i>
                                            </span>
                                        </div>
                                        @if ($errors->has('password_confirmation'))
                                            <div class="text-danger">{{ $errors->first('password_confirmation') }}
                                            </div>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Delivery Person Image</label>
                                        <div class="upload__box">
                                            <div class="upload__btn-box">
                                                <label>
                                                    <input type="file" name="fileDelPersonImage"
                                                        id="fileDelPersonImage" class="form-control">
                                                </label>
                                                <div class="img mt-2">
                                                    @if ($deliveryPerson->delivery_person_image)
                                                        <img src="{{ asset($deliveryPerson->delivery_person_image) }}"
                                                            id="previewImage1" width="100" height="100">
                                                    @else
                                                        <img src="{{ asset('assets\img\avatars\14.png') }}"
                                                            id="previewImage1" width="100" height="100">
                                                    @endif
                                                    @if ($errors->has('fileDelPersonImage'))
                                                        <div class="text-danger">
                                                            {{ $errors->first('fileDelPersonImage') }}
                                                        </div>
                                                    @endif
                                                    <span class="error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <div class="card-header p-0">
                    <h4>Address info</h4>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">State Name<span class="text-danger">*</span>
                            </label>
                            <select name="ddlState" id="ddlState" class="select2 form-select"
                                title="Select State Name" required>
                                <option value="">Select</option>
                                @if (!empty($states))
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            @isset($deliveryPerson->state_id)@if ($deliveryPerson->state_id == $state->id) {{ 'selected' }} @endif @endisset>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('ddlState'))
                                <div class="text-danger">{{ $errors->first('ddlState') }}</div>
                            @endif
                            <span class="error"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">District Name<span class="text-danger">*</span>
                            </label>
                            <select name="ddlCity" id="ddlCity" class="select2 form-select"
                                title="Select District Name" required>
                                @isset($deliveryPerson)
                                    @if (!empty($cities))
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                @isset($deliveryPerson)@if ($deliveryPerson->city_id == $city->id) {{ 'selected' }}@endif @endisset>
                                                {{ $city->city_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endisset
                            </select>
                            @if ($errors->has('ddlCity'))
                                <div class="text-danger">{{ $errors->first('ddlCity') }}</div>
                            @endif
                            <span class="error"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Area Name<span class="text-danger">*</span></label>
                            <select name="ddlArea" id="ddlArea" class="select2 form-select" data-tags="true"
                                title="Select Area Name" required>
                                @isset($deliveryPerson)
                                    @if (!empty($areas))
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}"
                                                @isset($deliveryPerson)@if ($deliveryPerson->area_id == $area->id) {{ 'selected' }}@endif @endisset>
                                                {{ $area->area_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endisset
                            </select>
                            @if ($errors->has('ddlArea'))
                                <div class="text-danger">{{ $errors->first('ddlArea') }}</div>
                            @endif
                            <span class="error"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Door No / Street / Landmark
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="txtDoorNo" id="txtDoorNo" class="form-control"
                                placeholder="Enter Door No / Street / Landmark"
                                value="@isset($deliveryPerson){{ $deliveryPerson ? $deliveryPerson->address : '' }}@endisset"
                                title="enter Door No / Street / Landmark" required>

                            @if ($errors->has('txtDoorNo'))
                                <div class="text-danger">{{ $errors->first('txtDoorNo') }}</div>
                            @endif
                            <span class="error"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Pincode<span class="text-danger">*</span></label>
                            <input type="text" name="txtPincode" id="txtPincode" class="form-control numvalidate"
                                placeholder="Pincode"
                                value="@isset($deliveryPerson){{ $deliveryPerson ? $deliveryPerson->pincode : '' }}@endisset"
                                title="Enter Pincode" required />

                            @if ($errors->has('txtPincode'))
                                <div class="text-danger">{{ $errors->first('txtPincode') }}</div>
                            @endif
                            <span class="error"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                @if (isset($bindDocuments) && $bindDocuments->count() > 0)
                    <div class="card-header p-0">
                        <h4>Documents</h4>
                    </div>
                    <div class="row">
                        @foreach ($bindDocuments as $item)
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="doc_{{ $item->id }}">{{ $item->documentType->documenttype_name }}
                                        Number
                                        @if ($item->is_mandatory == 1)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="text" id="doc_{{ $item->id }}"
                                        name="doc_{{ $item->id }}" class="form-control"
                                        placeholder="Enter {{ $item->documentType->documenttype_name }} Number"
                                        value="{{ isset($deliveryPerson) ? $item->document_number : '' }}">
                                </div>
                            </div>
                            <div class=" col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Upload File <sup>(PDF only)</sup>
                                        @if ($item->is_mandatory == 1)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="hidden" name="hdDocumentTypeName"
                                        value="{{ isset($deliveryPerson) ? $item->documenttype_name : '' }}">
                                    <input type="hidden" id="hddocumentNum_{{ $item->id }}"
                                        name="hddocumentNum_{{ $item->id }}"
                                        value="{{ isset($deliveryPerson) ? $item->document_number : '' }}">
                                    <input id="file_{{ $item->id }}" name="file_{{ $item->id }}"
                                        type="file" class="form-control"
                                        @if ($deliveryPerson == null ? '' : !$deliveryPerson->id) @if ($item->is_mandatory == 1) required @endif
                                        @endif
                                    accept="application/pdf" id="previewImage1" />
                                    <input type="hidden" name="hdDocumentImg_{{ $item->id }}"
                                        id="hdDocumentImg_{{ $item->id }}"
                                        value="{{ isset($deliveryPerson) ? $item->document_path : '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                @if (isset($deliveryPerson) && $item->document_path)
                                    <div class="mb-3">
                                        <label class="form-label">View Uploaded Document</label>
                                        <div>
                                            <a href="{{ asset($item->document_path) }}" class="btn btn-primary"
                                                target="_blank"><i class="ti ti-eye"></i>View</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="mt-4 mb-3">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('deliverypersonlist') }}" class="btn btn-danger">Cancel</a>
                        </div>
                        <div class="mt-4 mb-3">
                            <a href="{{ route('deliverypersonlist') }}" class="btn btn-primary">Go To List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- / Content -->

@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/deliverypersonmanagement/deliveryperson.js') }}"></script>
@endsection
