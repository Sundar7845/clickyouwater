@extends('layouts.main_master') @section('content')
@section('title')
    Add Manufacturer | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Add Manufacturer
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <form method="post" action="{{ url('manufacture-create') }}" name="manufacture" id="register-form"
                enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="card-header p-0">
                            <h4>Basic Company Info</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtManufacturerId">Manufacturer ID <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="txtManufacturerId"
                                        id="txtManufacturerId" placeholder="MFTGLB001"
                                        value="{{ $manExample }}"readonly />
                                    @if ($errors->has('txtManufacturerId'))
                                        <div class="text-danger">{{ $errors->first('txtManufacturerId') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtManufacturerName">Manufacturer Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('txtManufacturerName') }}"
                                        name="txtManufacturerName" id="txtManufacturerName" maxlength="255"
                                        placeholder="Enter Manufacturer Name" class="form-control"
                                        title="Enter Manufacturer Name" required>
                                </div>
                                @if ($errors->has('txtManufacturerName'))
                                    <div class="text-danger">{{ $errors->first('txtManufacturerName') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtMobile">Official Mobile <span
                                            class="text-danger ">*</span>
                                    </label>
                                    <input type="text" id="txtMobile" name="txtMobile"
                                        class="form-control mobilenumber" value="{{ old('txtMobile') }}"
                                        placeholder="Mobile" title="Enter Mobile Number" />
                                    @if ($errors->has('txtMobile'))
                                        <div class="text-danger">{{ $errors->first('txtMobile') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtOffEmail">Official Email<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="email" id="txtOffEmail" name="txtOffEmail" class="form-control"
                                        value="{{ old('txtOffEmail') }}" placeholder="Email"
                                        title="Enter Official Email" />
                                    @if ($errors->has('txtOffEmail'))
                                        <div class="text-danger">{{ $errors->first('txtOffEmail') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtCreditPeriod" class="form-label">Credit Period (Days) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtCreditPeriod" placeholder="Credit Period" 
                                            value="{{ old('txtCreditPeriod') }}" name="txtCreditPeriod"
                                            class="form-control" title="Enter Credit Period" />

                                    </div>
                                    @if ($errors->has('txtCreditPeriod'))
                                        <div class="text-danger">{{ $errors->first('txtCreditPeriod') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtSettlementPeriod" class="form-label">Settlement Period (Days) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtSettlementPeriod" placeholder="Settlement Period"
                                            value="{{ old('txtSettlementPeriod') }}" name="txtSettlementPeriod"
                                            class="form-control" title="Enter Settlement Period" />

                                    </div>
                                    @if ($errors->has('txtSettlementPeriod'))
                                        <div class="text-danger">{{ $errors->first('txtSettlementPeriod') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="yearOfExp" class="form-label">Years of Experience <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" id="yearOfExp" placeholder="Years of Eperience"
                                            min="0" oninput="validity.valid||(value='');"
                                            value="{{ old('yearOfExp') }}" name="yearOfExp" class="form-control" title="Enter Year of Experience"/>

                                    </div>
                                    @if ($errors->has('yearOfExp'))
                                        <div class="text-danger">{{ $errors->first('yearOfExp') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3" id="">
                                    <label for="txtNoOfBrands" class="form-label">No of Brands <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtNoOfBrands" placeholder="No of Brands"
                                            value="{{ old('txtNoOfBrands') }}" name="txtNoOfBrands" 
                                            class="form-control" title="Enter No of Brands"/>

                                    </div>
                                    @if ($errors->has('txtNoOfBrands'))
                                        <div class="text-danger">{{ $errors->first('txtNoOfBrands') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtAnnualTurnOver" class="form-label">Annual Turn Over (Lakhs) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtAnnualTurnOver" placeholder="Annual Turn Over"
                                            value="{{ old('txtAnnualTurnOver') }}" name="txtAnnualTurnOver"
                                            class="form-control" title="Enter Annual Turn Over"/>

                                    </div>
                                    @if ($errors->has('txtAnnualTurnOver'))
                                        <div class="text-danger">{{ $errors->first('txtAnnualTurnOver') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtSecurityDeposit" class="form-label">Security Deposit (₹) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtSecurityDeposit" placeholder="Security Deposit"
                                            value="{{ old('txtSecurityDeposit') }}" name="txtSecurityDeposit"
                                            class="form-control" title="Enter Security Deposit"/>
                                    </div>
                                    @if ($errors->has('txtSecurityDeposit'))
                                        <div class="text-danger">{{ $errors->first('txtSecurityDeposit') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password {!! isset($man->id) ? '' : '<span class="text-danger">*</span>' !!}
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="******" {{ isset($man->id) ? '' : 'required' }} title="Enter Password" />
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('password'))
                                        <div class="text-danger">{{ $errors->first('password') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirm
                                        Password {!! isset($man->id) ? '' : '<span class="text-danger">*</span>' !!}
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" placeholder="******"
                                            {{ isset($man->id) ? '' : 'required' }}  title="Enter Confirm Password"/>
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <div class="text-danger">{{ $errors->first('password_confirmation') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Third Party Tie-Up<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <label class="switch">
                                            <input type="checkbox" id="chkIsThirdParty" 
                                                name="chkThirdpartyTieup" value="0" class="switch-input"  {{ old('chkThirdpartyTieup') == 1 ? 'checked' : '' }}>
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 ThirdParty" id="ThirdParty" style="display:none;">
                                    <label class="form-label">No of Third Party Brands<span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtThirdpartyBrands"
                                            placeholder="No of Third Party Brands"
                                            value="{{ old('txtThirdpartyBrands') }}" title="Enter Third Party Brands" name="txtThirdpartyBrands"
                                            class="form-control" required/>
                                        </span>
                                    </div>
                                    @if ($errors->has('txtThirdpartyBrands'))
                                        <div class="text-danger">{{ $errors->first('txtThirdpartyBrands') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 ThirdParty" id="ThirdParty" style="display:none;">
                                    <label class="form-label">Third Party Brand Names (Brand1,Brand2) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtThirdpartyBrandName"
                                            placeholder="Third Party Brand Name"
                                            value="{{ old('txtThirdpartyBrandName') }}" title="Enter Thirty Party Brand Name" name="txtThirdpartyBrandName"
                                            class="form-control" required/>

                                    </div>
                                    @if ($errors->has('txtThirdpartyBrandName'))
                                        <div class="text-danger">{{ $errors->first('txtThirdpartyBrandName') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 ThirdParty" id="ThirdParty" style="display:none;">
                                    <label class="form-label">Third Party Turn Over (₹) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtThirdPartyTurnover" title="Enter Third Party Turn Over"
                                            placeholder="Third Party Turn Over" value="{{ old('txtThirdPartyTurnover') }}"
                                            name="txtThirdPartyTurnover" class="form-control" required/>
                                        </span>

                                    </div>
                                    @if ($errors->has('txtThirdPartyTurnover'))
                                        <div class="text-danger">{{ $errors->first('txtThirdPartyTurnover') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 ThirdParty" id="ThirdParty" style="display:none;">
                                    <label class="form-label">Total Turn Over (₹) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtTotalTurnover" 
                                            value="{{ old('txtTotalTurnover') }}" name="txtTotalTurnover"
                                            class="form-control" readonly/>
                                        </span>

                                    </div>
                                    @if ($errors->has('txtTotalTurnover'))
                                        <div class="text-danger">{{ $errors->first('txtTotalTurnover') }}</div>
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
                            <h4>Geofence Map</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="txtLatitude">Latitude <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="txtLatitude" name="txtLatitude"
                                            class="form-control" value="{{ old('txtLatitude') }}"
                                            placeholder="Latitude" readonly />
                                        @if ($errors->has('txtLatitude'))
                                            <div class="text-danger">{{ $errors->first('txtLatitude') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="txtLongtitude">Longtitude <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="txtLongtitude" name="txtLongtitude"
                                            value="{{ old('txtLongtitude') }}" class="form-control"
                                            placeholder="Longtitude" readonly />
                                        @if ($errors->has('txtLongtitude'))
                                            <div class="text-danger">{{ $errors->first('txtLongtitude') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="txtGeoLocation">Geo Location <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="txtGeoLocation" name="txtGeoLocation"
                                            value="{{ old('txtGeoLocation') }}" class="form-control"
                                            placeholder="Geo Location" readonly />
                                        @if ($errors->has('txtGeoLocation'))
                                            <div class="text-danger">{{ $errors->first('txtGeoLocation') }}</div>
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
                            <h4>Address Info</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="ddlState">State Name<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="ddlState" id="ddlState"
                                        class="select2 form-select ">
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
                                    <label class="form-label" for="ddlCity">District Name<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="ddlCity" id="ddlCity" class="select2 form-select ">
                                        <option value="">Select</option>

                                    </select>
                                    @if ($errors->has('ddlCity'))
                                        <div class="text-danger">{{ $errors->first('ddlCity') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3" id="areaId">
                                    <label class="form-label" for="ddlArea">Area Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlArea" id="ddlArea" class="select2 form-select "
                                        data-tags="true" required>
                                        <option value="">Select</option>

                                    </select>
                                    @if ($errors->has('ddlArea'))
                                        <div class="text-danger">{{ $errors->first('ddlArea') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtAddress">Door No / Street /
                                        Landmark<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="txtAddress" name="txtAddress"
                                        value="{{ old('txtAddress') }}"
                                        placeholder="Enter Door No / Street / Landmark">
                                    @if ($errors->has('txtAddress'))
                                        <div class="text-danger">{{ $errors->first('txtAddress') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtPincode">Pin Code <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control numvalidate"
                                        placeholder="Enter Pin Code" value="{{ old('txtPincode') }}"
                                        name="txtPincode" id="txtPincode">
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
                        <div class="card-header p-0">
                            <h4>Contact Info</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtProprietorName">Proprietor Name <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="txtProprietorName" class="form-control" maxlength="255"
                                        value="{{ old('txtProprietorName') }}" name="txtProprietorName"
                                        placeholder="Enter Proprietor Name" />
                                    @if ($errors->has('txtProprietorName'))
                                        <div class="text-danger">{{ $errors->first('txtProprietorName') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtProprietorMobile">Proprietor Mobile
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="txtProprietorMobile"
                                        class="form-control mobilenumber numvalidate"
                                        value="{{ old('txtProprietorMobile') }}" name="txtProprietorMobile"
                                        placeholder="Enter Proprietor Mobile" />
                                    @if ($errors->has('txtProprietorMobile'))
                                        <div class="text-danger">{{ $errors->first('txtProprietorMobile') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtProprietorEmail">Proprietor Email <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="email" id="txtProprietorEmail" class="form-control"
                                        value="{{ old('txtProprietorEmail') }}" name="txtProprietorEmail"
                                        placeholder="Enter Proprietor Email" />
                                    @if ($errors->has('txtProprietorEmail'))
                                        <div class="text-danger">{{ $errors->first('txtProprietorEmail') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtContactPersonName">Contact Person Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="txtContactPersonName" class="form-control" maxlength="255"
                                        value="{{ old('txtContactPersonName') }}" name="txtContactPersonName"
                                        placeholder="Enter Contact Person Name" />
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
                                    <input type="text" id="txtContactPersonMobile"
                                        class="form-control mobilenumber numvalidate"
                                        value="{{ old('txtContactPersonMobile') }}" name="txtContactPersonMobile"
                                        placeholder="Enter Contact Person Number" />
                                    @if ($errors->has('txtContactPersonMobile'))
                                        <div class="text-danger">
                                            {{ $errors->first('txtContactPersonMobile') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtContactPersonEmail">Contact Person Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" id="txtContactPersonEmail" class="form-control"
                                        value="{{ old('txtContactPersonEmail') }}" name="txtContactPersonEmail"
                                        placeholder="Enter Contact Person Email" />
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
                <div class="card mt-3">
                    <div class="card-body">
                        @if ($bindDocuments->count() > 0)
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
                                                @if ($item->is_mandatory == 1) required @endif
                                                accept="application/pdf" id="previewImage1" />
                                        </div>
                                    </div>
                                    <div class=" col-md-4"></div>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-danger" onclick="cancel();">Cancel</button>
                                </div>
                                <div class="mt-4 mb-3">
                                    <a href="{{ route('manufacturer-list') }}"><button type="button"
                                            class="btn btn-primary">Go to List</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Browser Default -->
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/manufacturemanagement/manufacture.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxSrT3mnTnRnbUSW1DGhTKAu2kGpdgm5Y&libraries=places">
</script>
<script src="{{ asset('assets/js/common/geolocation.js') }}"></script>
<script>
    @isset($man)
        @if ($man->is_thirdparty_tieup == '0')
            $("#chkIsThirdParty").prop("checked", true);
            $(".ThirdParty").show();
            //
        @else
            $("#chkIsThirdParty").prop("checked", false);
            $(".ThirdParty").hide();
        @endif
    @endisset
</script>
@endsection
