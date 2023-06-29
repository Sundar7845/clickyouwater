@extends('layouts.main_master') @section('content')
@section('title')
    Add Hub | Click Your Order | Dashboard
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Add Hub
    </h4>
    <form method="post" action="{{ url('hub-create') }}" name="hub" id="hubCreate" enctype="multipart/form-data">
        @csrf
        <div class="row mb-4">
            <!-- Browser Default -->
            <div class="col-md-12 mb-4 mb-md-0">
                <div class="card">
                    <div class="card-header">
                        <h4>Basic Company Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txthubId">Hub ID <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txthubId" class="form-control" id="txthubId"
                                        placeholder="HUBGLB001" value="{{ $hub_auto_code }}" required readonly
                                        title="Hub ID" />
                                    @if ($errors->has('txthubId'))
                                        <div class="text-danger">{{ $errors->first('txthubId') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txthubName">Hub Name <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txthubName" class="form-control" id="txthubName"
                                        value="{{ old('txthubName') }}" placeholder="Hub Name" required
                                        title="Enter Hub Name" />
                                    @if ($errors->has('txthubName'))
                                        <div class="text-danger">{{ $errors->first('txthubName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtYrsofExp" class="form-label">Years of Experience <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" name="txtYrsofExp" id="txtYrsofExp" min="0"
                                            oninput="validity.valid||(value='');" value="{{ old('txtYrsofExp') }}"
                                            placeholder="Years of Eperience" class="form-control" title="Enter Years of Experience" required />
                                    </div>
                                    @if ($errors->has('txtYrsofExp'))
                                        <div class="text-danger">{{ $errors->first('txtYrsofExp') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtMobile">Mobile / Landline Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtMobile" id="txtMobile"
                                        class="form-control mobilenumber" placeholder="Mobile / Landline Number"
                                        value="{{ old('txtMobile') }}" title="Enter Mobile / Landline Number" required />
                                    @if ($errors->has('txtMobile'))
                                        <div class="text-danger">{{ $errors->first('txtMobile') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtofficialEmail">Official Email <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="txtofficialEmail" id="txtofficialEmail"
                                        value="{{ old('txtofficialEmail') }}" class="form-control" placeholder="Email"
                                        title="Enter Official Email" required />
                                    @if ($errors->has('txtofficialEmail'))
                                        <div class="text-danger">{{ $errors->first('txtofficialEmail') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtcreditPeriod" class="form-label">Credit Period (Days) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" name="txtcreditPeriod" id="txtcreditPeriod"
                                            value="{{ old('txtcreditPeriod') }}" placeholder="Credit Period"
                                            class="form-control" title="Enter Credit Period" required />
                                    </div>
                                    @if ($errors->has('txtcreditPeriod'))
                                        <div class="text-danger">{{ $errors->first('txtcreditPeriod') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtsettlementPeriod">Settlement Period (Days) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" name="txtsettlementPeriod" id="txtsettlementPeriod"
                                            value="{{ old('txtsettlementPeriod') }}" placeholder="Settlement Period"
                                            class="form-control" required title="Enter Settlement Period" />
                                    </div>
                                    @if ($errors->has('txtsettlementPeriod'))
                                        <div class="text-danger">{{ $errors->first('txtsettlementPeriod') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtsecurityDeposit">Security Deposit (₹) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtsecurityDeposit" id="txtsecurityDeposit"
                                        value="{{ old('txtsecurityDeposit') }}" class="form-control"
                                        placeholder="Security Deposit" title="Enter Security Deposit" required />
                                    @if ($errors->has('txtsecurityDeposit'))
                                        <div class="text-danger">{{ $errors->first('txtsecurityDeposit') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password
                                        {!! isset($hub->id) ? '' : '<span class="text-danger">*</span>' !!}</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password" id="password" minlength="6" 
                                            placeholder="******" {{ isset($hub->id) ? '' : 'required' }} title="Enter Password" required/>
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirm Password
                                        {!! isset($hub->id) ? '' : '<span class="text-danger">*</span>' !!}
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" placeholder="******"
                                            {{ isset($hub->id) ? '' : 'required' }} title="Enter Confirm Password" required/>
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="error"></span>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="card-header p-0">
                            <h4>Geofence Map</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="txtlatitude">Latitude <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtlatitude" id="txtlatitude" class="form-control"
                                        value="{{ old('txtlatitude') }}" placeholder="Latitude" title="Enter Latitude" required readonly />

                                    @if ($errors->has('txtlatitude'))
                                        <div class="text-danger">{{ $errors->first('txtlatitude') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="txtlangtitute">Longtitude <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtlangtitute" id="txtlangtitute"
                                        value="{{ old('txtlangtitute') }}" class="form-control"
                                        placeholder="Longtitude" title="Enter Longtitude" required readonly />
                                    @if ($errors->has('txtlangtitute'))
                                        <div class="text-danger">{{ $errors->first('txtlangtitute') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="txtgeolocation">Geo Location <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtgeolocation" id="txtgeolocation"
                                        value="{{ old('txtgeolocation') }}" class="form-control"
                                        placeholder="Geo Location" title="Enter Geo Location" required readonly />
                                    @if ($errors->has('txtgeolocation'))
                                        <div class="text-danger">{{ $errors->first('txtgeolocation') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="txtcoordinates">Geo Coordinates <span
                                            class="text-danger">*</span>
                                    </label>
                                    <textarea type="text" rows="8" name="txtcoordinates" id="txtcoordinates" rows="5" cols="80"
                                        class="form-control" title="Enter Geo Coordinates" required readonly></textarea>

                                    @if ($errors->has('txtcoordinates'))
                                        <div class="text-danger">{{ $errors->first('txtcoordinates') }}</div>
                                    @endif
                                    <span class="error"></span>
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
                                <label class="form-label" for="">State Name<span class="text-danger">*</span>
                                </label>
                                <select name="ddlState" id="ddlState" class="select2 form-select " title="Enter State Name" required>
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('ddlState') == $state->id ? 'selected' : '' }}>
                                            {{ $state->state_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ddlState'))
                                    <div class="text-danger">{{ $errors->first('ddlState') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="">District Name<span
                                        class="text-danger">*</span>
                                </label>
                                <select name="ddlCity" id="ddlCity" class="select2 form-select" title="Enter District Name" required>
                                    <option value="">Select City</option>
                                </select>
                                @if ($errors->has('ddlCity'))
                                    <div class="text-danger">{{ $errors->first('ddlCity') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4" id="areaId">
                            <div class="mb-3">
                                <label class="form-label">Area Name<span class="text-danger">*</span></label>
                                <select name="ddlArea" id="ddlArea" data-tags="true"
                                    class="select2 form-select " title="Enter Area Name" required>
                                    <option value="">Select Area</option>
                                </select>
                                @if ($errors->has('ddlArea'))
                                    <div class="text-danger">{{ $errors->first('ddlArea') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtLandmark">Door No / Street / Landmark
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="txtLandmark" id="txtLandmark" class="form-control"
                                    value="{{ old('txtLandmark') }}" placeholder="Enter Door No / Street / Landmark"
                                    title="Enter Door No / Street / Landmark" required>
                                @if ($errors->has('txtLandmark'))
                                    <div class="text-danger">{{ $errors->first('txtLandmark') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtpinCode">Pin Code <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="txtpinCode" id="txtpinCode"
                                    class="form-control numvalidate" value="{{ old('txtpinCode') }}"
                                    placeholder="Enter Pin Code" title="Enter Pincode" required>
                                @if ($errors->has('txtpinCode'))
                                    <div class="text-danger">{{ $errors->first('txtpinCode') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-header p-0">
                        <h4>Choose Manufacuturer</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dropzone" id="dropzone">
                                <div class="dz-info">
                                    Please complete Geofencing and Address info sections
                                    <span class="note">(After the completion of above sections, you can able
                                        to choose manufacturer)</span>
                                </div>
                            </div>
                        </div>
                        <div class="row loadManufacturer">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-header p-0">
                        <h4>Contact Info</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtProprietorName">Proprietor Name <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="txtProprietorName" id="txtProprietorName"
                                    value="{{ old('txtProprietorName') }}" class="form-control"
                                    placeholder="Enter Proprietor Name" required title="Enter Proprietor Name" />
                                @if ($errors->has('txtProprietorName'))
                                    <div class="text-danger">{{ $errors->first('txtProprietorName') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtProprietorMobile">Proprietor Mobile <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="txtProprietorMobile" id="txtProprietorMobile"
                                    value="@isset($hub){{ $hub ? $hub->proprietor_mobile : '' }}@endisset"
                                    class="form-control mobilenumber" placeholder="Enter Proprietor Mobile" required
                                    title="Enter Proprietor Mobile" />
                                @if ($errors->has('txtProprietorMobile'))
                                    <div class="text-danger">{{ $errors->first('txtProprietorMobile') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtProprietorEmail">Proprietor Email <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="email" name="txtProprietorEmail" id="txtProprietorEmail"
                                    value="{{ old('txtProprietorEmail') }}" class="form-control"
                                    placeholder="Enter Proprietor Email" required title="Enter Proprietor Email" />
                                @if ($errors->has('txtProprietorEmail'))
                                    <div class="text-danger">{{ $errors->first('txtProprietorEmail') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtContactPersonName">Contact Person Name <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="txtContactPersonName" id="txtContactPersonName"
                                    value="{{ old('txtContactPersonName') }}" class="form-control"
                                    placeholder="Enter Contact Person Name" required
                                    title="Enter Contact Person Name" />
                                @if ($errors->has('txtContactPersonName'))
                                    <div class="text-danger">{{ $errors->first('txtContactPersonName') }}
                                    </div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtContactPersonMobile">Contact Person Mobile
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="txtContactPersonMobile" id="txtContactPersonMobile"
                                    value="{{ old('txtContactPersonMobile') }}" class="form-control mobilenumber"
                                    placeholder="Enter Contact Person Number" required
                                    title="Enter Contact Person Number" />
                                @if ($errors->has('txtContactPersonMobile'))
                                    <div class="text-danger">{{ $errors->first('txtContactPersonMobile') }}
                                    </div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="txtContactPersonEmail">Contact Person Email <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="email" id="txtContactPersonEmail" name="txtContactPersonEmail"
                                    value="{{ old('txtContactPersonEmail') }}" class="form-control"
                                    placeholder="Enter Contact Person Email" required
                                    title="Enter Contact Person Email" />
                                @if ($errors->has('txtContactPersonEmail'))
                                    <div class="text-danger">{{ $errors->first('txtContactPersonEmail') }}
                                    </div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($bindDocuments->count() > 0)
                <div class="card mt-3">
                    <div class="card-body">
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
                                            value="{{ old('doc_' . $item->id) }}">
                                    </div>
                                </div>
                                <div class=" col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Upload File <sup>(PDF only)</sup>
                                            @if ($item->is_mandatory == 1)
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input id="file_{{ $item->id }}" name="file_{{ $item->id }}"
                                            type="file" class="form-control"
                                            value="{{ old('file_' . $item->id) }}"
                                            @if ($item->is_mandatory == 1) required @endif accept="application/pdf"
                                            id="previewImage1" />
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-header p-0">
                        <h4>Vehicle info</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label" for="ddlfueltype">Fuel/Electric<span
                                        class="text-danger">*</span>
                                </label>
                                <select name="ddlfueltype" id="ddlfueltype" class="select2 form-select" title="Select Fuel Type" required>  
                                    <option value="">Select</option>
                                    @foreach ($fueltypes as $fueltype)
                                        <option value="{{ $fueltype->id }}"
                                            {{ old('ddlfueltype') == $fueltype->id ? 'selected' : '' }}>
                                            {{ $fueltype->fuel_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ddlfueltype'))
                                    <div class="text-danger">{{ $errors->first('ddlfueltype') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="ddlvehicletype">Vehicle Type<span class="text-danger">*</span>
                                </label>
                                <select name="ddlvehicletype" id="ddlvehicletype" class="select2 form-select" title="Select Vehicle Type" required>
                                    <option value="">Select Vehicle Type</option>
                                    @foreach ($vehicletypes as $vehicletype)
                                        <option value="{{ $vehicletype->id }}"
                                            {{ old('ddlvehicletype') == $vehicletype->id ? 'selected' : '' }}>
                                            {{ $vehicletype->vehicle_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ddlvehicletype'))
                                    <div class="text-danger">{{ $errors->first('ddlvehicletype') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="ddlvehiclebrand">Brand<span class="text-danger">*</span>
                                </label>
                                <select name="ddlvehiclebrand" id="ddlvehiclebrand" class="select2 form-select" title="Select Brand" required>
                                    <option value="">Select Brand</option>
                                </select>
                                @if ($errors->has('ddlvehiclebrand'))
                                    <div class="text-danger">{{ $errors->first('ddlvehiclebrand') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="txtregno">Reg No<span class="text-danger">*</span>
                                </label>
                                <input type="text" name="txtregno" id="txtregno" class="form-control"
                                    placeholder="Enter Reg No" title="Enter Reg No" required>
                                @if ($errors->has('txtregno'))
                                    <div class="text-danger">{{ $errors->first('txtregno') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3">
                                <img src="{{ asset('upload/common/add.png') }}" class="img-fluid"
                                    onclick="return addVehicleInfo();" id="btnAdd" width="50px" height="50px"
                                    style="margin-top:18px; cursor:pointer;">
                                <img src="{{ asset('upload/common/addgreen.png') }}" class="img-fluid"
                                    onclick="return addVehicleInfo();" id="btnUpdate" width="40"
                                    style="margin-top:21px; cursor:pointer; display: none">
                                <input type="hidden" id="hdEditVehicleInfoRowId" value="0">

                            </div>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="table table-responsive">
                                <thead>
                                    <th>Fuel/Electric</th>
                                    <th>Vehicle Type</th>
                                    <th>Brand</th>
                                    <th>Reg No</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="tbodyVehicleType">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <div class="mt-4 mb-3">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-danger" onclick="cancel()">Cancel</button>
                        </div>
                        <div class="mt-4 mb-3">
                            <a href="{{ route('hub-list') }}" class="btn btn-primary">Go To List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</form>
</div>
<!-- /Browser Default -->
<!-- / Content -->
@endsection
@section('footer')
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxSrT3mnTnRnbUSW1DGhTKAu2kGpdgm5Y&libraries=drawing,geometry,places">
</script>
<script src="{{ asset('assets/js/admin/hubmanagement/hub.js') }}"></script>
{{-- <script src="{{ asset('assets/js/admin/hubmanagement/geofencing.js') }}"></script> --}}
<script>
    var map; // Global declaration of the map
    var lat_longs = new Array();
    var drawingManager;
    var lastpolygon = null;
    var bounds = new google.maps.LatLngBounds();
    var polygons = [];
    let marker;
    let markers = [];
    let geocoder;

    function resetMap(controlDiv) {
        // Set CSS for the control border.
        const controlUI = document.createElement("div");
        controlUI.style.backgroundColor = "#fff";
        controlUI.style.border = "2px solid #fff";
        controlUI.style.borderRadius = "3px";
        controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        controlUI.style.cursor = "pointer";
        controlUI.style.marginTop = "8px";
        controlUI.style.marginBottom = "22px";
        controlUI.style.textAlign = "center";
        controlUI.title = "Reset map";
        controlDiv.appendChild(controlUI);
        // Set CSS for the control interior.
        const controlText = document.createElement("div");
        controlText.style.color = "rgb(25,25,25)";
        controlText.style.fontFamily = "Roboto,Arial,sans-serif";
        controlText.style.fontSize = "10px";
        controlText.style.lineHeight = "16px";
        controlText.style.paddingLeft = "2px";
        controlText.style.paddingRight = "2px";
        controlText.innerHTML = "X";
        controlUI.appendChild(controlText);
        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener("click", () => {
            lastpolygon.setMap(null);
            $('#coordinates').val('');

        });
    }

    function placeMarker(location) {

        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
        markers.push(marker);

    }

    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function hideMarkers() {
        setMapOnAll(null);
    }

    // Shows any markers currently in the array.
    function showMarkers() {
        setMapOnAll(map);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        hideMarkers();
        markers = [];
    }

    function geocode(request) {
        geocoder
            .geocode(request)
            .then((result) => {
                const {
                    results
                } = result;
                $("#txtgeolocation").val(results[0].formatted_address);
                return results;
            })
            .catch((e) => {
                alert("Geocode was not successful for the following reason: " + e);
            });
    }

    function initialize() {
        var myLatlng = new google.maps.LatLng(($("#txtlatitude").val() == "" ? 11.004556 : $("#txtlatitude").val()), ($(
            "#txtlangtitute").val() == "" ? 76.961632 : $("#txtlangtitute").val()));
        var myOptions = {
            zoom: 11,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map"), myOptions);

        //Init geocoder service
        geocoder = new google.maps.Geocoder();


        google.maps.event.addListener(map, 'click', function(event) {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to change the hub location!",
                icon: "error",
                showCancelButton: true,
                confirmButtonText: "Yes, do it!",
                customClass: {
                    confirmButton: "btn btn-success me-3",
                    cancelButton: "btn btn-danger",
                },
                buttonsStyling: false,
            }).then(function(result) {
                if (result.value) {
                    deleteMarkers();
                    placeMarker(event.latLng);
                    geocode({
                        location: event.latLng
                    });
                    // console.log(event.latLng.toUrlValue());
                    $("#txtlatitude").val(event.latLng.toUrlValue().split(',')[0]);
                    $("#txtlangtitute").val(event.latLng.toUrlValue().split(',')[1]);
                }
            });
        });

        @isset($hub->geo_coordinates)
            @if (is_array($hub->geo_coordinates))
                {
                    const polygonCoords = [

                        @foreach ($hub->geo_coordinates[0] as $coords)
                            {
                                lat: {{ $coords->getLat() }},
                                lng: {{ $coords->getLng() }}
                            },
                        @endforeach
                    ];

                    var zonePolygon = new google.maps.Polygon({
                        paths: polygonCoords,
                        strokeColor: "#050df2",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillOpacity: 0,
                    });

                    zonePolygon.setMap(map);

                    zonePolygon.getPaths().forEach(function(path) {
                        path.forEach(function(latlng) {
                            bounds.extend(latlng);
                            map.fitBounds(bounds);
                        });
                    });

                }
            @endif
        @endisset


        drawingManager = new google.maps.drawing.DrawingManager({
            // drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: [google.maps.drawing.OverlayType.POLYGON]
            },
            polygonOptions: {
                editable: true
            }
        });
        drawingManager.setMap(map);

        google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
            var newShape = event.overlay;
            newShape.type = event.type;
        });

        google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
            if (lastpolygon) {
                lastpolygon.setMap(null);
            }
            $('#txtcoordinates').val(event.overlay.getPath().getArray());
            lastpolygon = event.overlay;
            // auto_grow();
        });
        const resetDiv = document.createElement("div");
        resetMap(resetDiv, lastpolygon);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);

    }

    function drawPolygonOtherHubs() {

        $.ajax({
            url: "/get/hubcoordinates",
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                hub_id: $("#hub_id").val(),
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function(data) {
                // console.log(data);

                for (var i = 0; i < data.length; i++) {
                    polygons.push(new google.maps.Polygon({
                        paths: data[i],
                        strokeColor: "#FF0000",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "#FF0000",
                        fillOpacity: 0.1,
                    }));
                    polygons[i].setMap(map);
                }

            },
        });

    }

    function placeMarkerOnEdit() {
        if (($("#txtcoordinates").val() != undefined && $("#txtcoordinates").val() != "") && ($("#txtcoordinates")
                .val() != undefined && $("#txtcoordinates").val() != "")) {
            var location = new google.maps.LatLng($("#txtlatitude").val(), $("#txtlangtitute").val());
            placeMarker(location);
            map.setCenter(location);
        }
    }


    function drawPolygon(hubcoordinates, isEditable = false, isDraggable = false, isClickable = false) {
        // Construct the polygon.
        const hub = new google.maps.Polygon({
            paths: hubcoordinates,
            clickable: isClickable,
            draggable: isDraggable,
            editable: isEditable,
            fillColor: "#ffff00",
            fillOpacity: 0.2,
        });

        hub.setMap(map);

        // if (isClickable) {
        //     google.maps.event.addListener(hub, 'click', function(e) {
        //         setSelection(hub);
        //     });
        // }
    }

    google.maps.event.addDomListener(window, 'load', function() {
        initialize();
        drawPolygonOtherHubs();
        placeMarkerOnEdit();
    });
</script>
@endsection
