@extends('layouts.main_master') @section('content')
@section('title')
    Edit Manufacturer | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Edit Manufacturer
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            @isset($man)
                <form method="post" action="{{ url('manufacture-update', $man->id) }}" name="manufacture_edit" id="register-form"
                    enctype="multipart/form-data">
                @endisset
                @csrf
                <input type="hidden" name="hdMFId" id="hdMFId" value="{{ $man ? $man->id : '' }}">
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
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="txtManufacturerName" maxlength="255"
                                        value="@isset($man){{ $man ? $man->manufacturer_name : '' }}@endisset"
                                        id="txtManufacturerName" placeholder="Manufacturer Name" required/>
                                    @if ($errors->has('txtManufacturerName'))
                                        <div class="text-danger">{{ $errors->first('txtManufacturerName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtMobile">Official Mobile <span
                                            class="text-danger ">*</span>
                                    </label>
                                    <input type="text" id="txtMobile" name="txtMobile"
                                        class="form-control mobilenumber"
                                        value="@isset($man){{ $man ? $man->mobile : '' }}@endisset"
                                        placeholder="Mobile" required/>
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
                                        value="@isset($man){{ $man ? $man->official_email : '' }}@endisset"
                                        placeholder="Email" required/>
                                    @if ($errors->has('txtOffEmail'))
                                        <div class="text-danger">{{ $errors->first('txtOffEmail') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Credit Period (Days) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtCreditPeriod" placeholder="Credit Period"
                                            value="@isset($man){{ $man ? $man->credit_period : '' }}@endisset"
                                            name="txtCreditPeriod" class="form-control" required/>

                                    </div>
                                    @if ($errors->has('txtCreditPeriod'))
                                        <div class="text-danger">{{ $errors->first('txtCreditPeriod') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Settlement Period (Days) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtSettlementPeriod" placeholder="Settlement Period"
                                            value="@isset($man){{ $man ? $man->settlement_period : '' }}@endisset"
                                            name="txtSettlementPeriod" class="form-control" required/>

                                    </div>
                                    @if ($errors->has('txtSettlementPeriod'))
                                        <div class="text-danger">{{ $errors->first('txtSettlementPeriod') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Years of Experience <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" id="yearOfExp" placeholder="Years of Eperience"
                                            min="0" oninput="validity.valid||(value='');"
                                            value="@isset($man){{ $man ? $man->years_of_experience : '' }}@endisset"
                                            name="yearOfExp" class="form-control" required/>

                                    </div>
                                    @if ($errors->has('yearOfExp'))
                                        <div class="text-danger">{{ $errors->first('yearOfExp') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3" id="">
                                    <label class="form-label">No of Brands <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtNoOfBrands" placeholder="No of Brands"
                                            value="@isset($man){{ $man ? $man->no_of_brands : '' }}@endisset"
                                            name="txtNoOfBrands" class="form-control" required/>

                                    </div>
                                    @if ($errors->has('txtNoOfBrands'))
                                        <div class="text-danger">{{ $errors->first('txtNoOfBrands') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Annual Turn Over (Lakhs) <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtAnnualTurnOver" placeholder="Annual Turn Over"
                                            value="@isset($man){{ $man ? $man->annual_turn_over : '' }}@endisset"
                                            name="txtAnnualTurnOver" class="form-control" required/>

                                    </div>
                                    @if ($errors->has('txtAnnualTurnOver'))
                                        <div class="text-danger">{{ $errors->first('txtAnnualTurnOver') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Security Deposit (₹) <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="txtSecurityDeposit" placeholder="Security Deposit"
                                            value="@isset($man){{ $man ? $man->security_deposit : '' }}@endisset"
                                            name="txtSecurityDeposit" class="form-control" required/>
                                    </div>
                                    @if ($errors->has('txtSecurityDeposit'))
                                        <div class="text-danger">{{ $errors->first('txtSecurityDeposit') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="******" title="Enter Password" />
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('password'))
                                        <div class="text-danger">{{ $errors->first('password') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirm
                                        Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" placeholder="******"
                                            title="Confirm Password" />
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
                                    <label class="form-label">Third Party Tie-Up<span class="text-danger">*</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <label class="switch">
                                            <input type="checkbox" id="chkIsThirdParty" name="chkThirdpartyTieup"
                                                value="{{ $man->is_thirdparty_tieup }}" {{ $man->is_thirdparty_tieup ? 'checked' : '' }} class="switch-input" />
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
                                            value="@isset($man->no_of_thirdparty_brands){{ $man->no_of_thirdparty_brands != 0 ? $man->no_of_thirdparty_brands : '' }}@endisset"
                                            name="txtThirdpartyBrands" class="form-control" title="Enter Third Party Brands" required/>
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
                                            placeholder="Third Party Brand Name" title="Enter Thirty Party Brand Name"
                                            value="@isset($man->thirdparty_brand_name){{ $man->thirdparty_brand_name != 0 ? $man->thirdparty_brand_name : '' }}@endisset"
                                            name="txtThirdpartyBrandName" class="form-control" required/>
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
                                        <input type="text" id="txtThirdPartyTurnover"
                                            placeholder="Third Party Turn Over" title="Enter Third Party Turn Over"
                                            value="@isset($man->thirdparty_turnover){{ $man->thirdparty_turnover != 0 ? $man->thirdparty_turnover : '' }}@endisset"
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
                                        <input type="text" id="txtTotalTurnover" placeholder="Total Turn Over"
                                            value="@isset($man->total_turnover){{ $man->total_turnover != 0 ? $man->total_turnover : '' }}@endisset"
                                            name="txtTotalTurnover" class="form-control" readonly/>
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
                                            class="form-control"
                                            value="@isset($man){{ $man ? $man->latitude : '' }}@endisset"
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
                                            value="@isset($man){{ $man ? $man->longtitude : '' }}@endisset"
                                            class="form-control" placeholder="Longtitude" readonly />
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
                                            value="@isset($man){{ $man ? $man->geo_location : '' }}@endisset"
                                            class="form-control" placeholder="Geo Location" readonly />
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
                                        class="select2 form-select " required>
                                        <option value="">Select</option>
                                        @if (!empty($states))
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    @isset($man)@if ($man->state_id == $state->id) {{ 'selected' }}@endif @endisset>
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
                                    <label class="form-label" for="basic-default-name">District Name<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="ddlCity" id="ddlCity" class="select2 form-select"
                                        title="Select District Name" required>
                                            @if (!empty($cities))
                                                @foreach ($cities as $city) 
                                                    <option value="{{ $city->id }}"
                                                        @isset($man)@if ($man->city_id == $city->id) {{ 'selected' }}@endif @endisset>
                                                        {{ $city->city_name }}
                                                    </option>
                                                @endforeach
                                            @endif
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
                                    <select name="ddlArea" id="ddlArea" class="select2 form-select "
                                        data-tags="true" title="Select Area Name" required>
                                        @isset($man)
                                            @if (!empty($areas))
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}"
                                                        @isset($man)@if ($man->area_id == $area->id) {{ 'selected' }}@endif @endisset>
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
                                    <label class="form-label" for="txtAddress">Door No / Street /
                                        Landmark<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="txtAddress" name="txtAddress"
                                        value="@isset($man){{ $man ? $man->address : '' }}@endisset"
                                        placeholder="Enter Door No / Street / Landmark" required>
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
                                        placeholder="Enter Pin Code"
                                        value="@isset($man){{ $man ? $man->pincode : '' }}@endisset"
                                        name="txtPincode" id="txtPincode" required>
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
                                        value="@isset($man){{ $man ? $man->proprietor_name : '' }}@endisset"
                                        name="txtProprietorName" placeholder="Enter Proprietor Name" required/>
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
                                        value="@isset($man){{ $man ? $man->proprietor_mobile : '' }}@endisset"
                                        name="txtProprietorMobile" placeholder="Enter Proprietor Mobile" required/>
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
                                        value="@isset($man){{ $man ? $man->proprietor_email : '' }}@endisset"
                                        name="txtProprietorEmail" placeholder="Enter Proprietor Email" required/>
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
                                        value="@isset($man){{ $man ? $man->contact_person_name : '' }}@endisset"
                                        name="txtContactPersonName" placeholder="Enter Contact Person Name" required/>
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
                                        value="@isset($man){{ $man ? $man->contact_person_mobile : '' }}@endisset"
                                        name="txtContactPersonMobile" placeholder="Enter Contact Person Number" required/>
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
                                        value="@isset($man){{ $man ? $man->contact_person_email : '' }}@endisset"
                                        name="txtContactPersonEmail" placeholder="Enter Contact Person Email" required/>
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
                                                value="{{ isset($man) ? $item->document_number : '' }}">
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
                                                value="{{ isset($man) ? $item->documenttype_name : '' }}">
                                            <input type="hidden" id="hddocumentNum_{{ $item->id }}"
                                                name="hddocumentNum_{{ $item->id }}"
                                                value="{{ isset($man) ? $item->document_number : '' }}">
                                            <input id="file_{{ $item->id }}" name="file_{{ $item->id }}"
                                                type="file" class="form-control"
                                                @if ($man == null ? '' : !$man->id) @if ($item->is_mandatory == 1) required @endif
                                                @endif
                                            accept="application/pdf" id="previewImage1" />
                                            <input type="hidden" name="hdDocumentImg_{{ $item->id }}"
                                                id="hdDocumentImg_{{ $item->id }}"
                                                value="{{ isset($man) ? $item->document_path : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        @if (isset($man) && $item->document_path)
                                            <div class="mb-3">
                                                <label class="form-label">View Uploaded Document</label>
                                                <div>
                                                    <a href="{{ asset($item->document_path) }}"
                                                        class="btn btn-primary" target="_blank"><i
                                                            class="ti ti-eye"></i>View</a>
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
                                    <a href="{{ route('manufacturer-list') }}" class="btn btn-danger">Cancel</a>
                                </div>
                                <div class="mt-4 mb-3">
                                    <a href="{{ route('manufacturer-list') }}" class="btn btn-primary">Go To List</a>
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
{{-- <script>
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
</script> --}}
@endsection
