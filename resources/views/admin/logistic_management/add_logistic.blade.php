@extends('layouts.main_master')
@section('content')
@section('title')
    Add Logistic | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Add Logistic
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <form name="logistic" action="{{ route('logisticCreate') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="hdLogisticId" id="hdLogisticId" value="{{ $log->id ?? '' }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtLogisticId">Logistic Partner ID<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtLogisticId"
                                        value="{{ $logistic->logistic_partner_id ?? $logExample }}" class="form-control"
                                        id="txtLogisticId" placeholder="" readonly title="Logistic Partner ID" />
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtLogisticName">Logistic Partner Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtLogisticName" class="form-control"
                                        id="txtLogisticName" placeholder="Logistic Partner Name"
                                        value="{{ old('txtLogisticName') }}" title="Enter Logistic Partner Name"
                                        required title="Enter Logistic Partner Name" />
                                    @if ($errors->has('txtLogisticName'))
                                        <div class="text-danger">{{ $errors->first('txtLogisticName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="ddlManufacturerName">Manufacturer Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlManufacturerName" id="ddlManufacturerName"
                                        class="select2 form-select" title="Select Manufacturer Name" required>
                                        <option value="">Select Manufacturer</option>
                                        @foreach ($man as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('ddlManufacturerName') == $item->id ? 'selected' : '' }}>
                                                {{ $item->manufacturer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlManufacturerName'))
                                        <div class="text-danger">{{ $errors->first('ddlManufacturerName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="ddlHubName">Hub Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlHubName[]" id="ddlHubName" class="select2 form-select "
                                        title="Enter Hub Name" multiple="multiple" required title="Select Hub">
                                    </select>
                                    @if ($errors->has('ddlHubName'))
                                        <div class="text-danger">{{ $errors->first('ddlHubName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtYearsOfExperience" class="form-label">Years of Experience <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" name="txtYearsOfExperience" id="txtYearsOfExperience"
                                            min="0" oninput="validity.valid||(value='');"
                                            placeholder="Years of Eperience" class="form-control"
                                            value="{{ old('txtYearsOfExperience') }}" title="Enter Years of Experience"
                                            required title="Enter Years of Experience" />
                                    </div>
                                    @if ($errors->has('txtYearsOfExperience'))
                                        <div class="text-danger">{{ $errors->first('txtYearsOfExperience') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtMobile">Mobile<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtMobile" class="form-control mobilenumber"
                                        id="txtMobile" placeholder="Mobile" value="{{ old('txtMobile') }}"
                                        title="Enter Mobile number" required />

                                    @if ($errors->has('txtMobile'))
                                        <div class="text-danger">{{ $errors->first('txtMobile') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtEmail">Email<span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="txtEmail" class="form-control" id="txtEmail"
                                        placeholder="Email" value="{{ old('txtEmail') }}" title="Enter Email Id"
                                        required />
                                    @if ($errors->has('txtEmail'))
                                        <div class="text-danger">{{ $errors->first('txtEmail') }}</div>
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
                                        <input type="text" name="txtCreditPeriod" id="txtCreditPeriod"
                                            placeholder="Credit Period" class="form-control"
                                            value="{{ old('txtCreditPeriod') }}" title="Enter Credit Period" required
                                            title="Enter Credit Period" />
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
                                        <input type="text" name="txtSettlementPeriod" id="txtSettlementPeriod"
                                            placeholder="Settlement Period" class="form-control"
                                            value="{{ old('txtSettlementPeriod') }}" title="Enter Settlement Period"
                                            required title="Enter Settlement Period" />
                                    </div>
                                    @if ($errors->has('txtSettlementPeriod'))
                                        <div class="text-danger">{{ $errors->first('txtSettlementPeriod') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password{!! isset($log->id) ? '' : '<span class="text-danger">*</span>' !!}
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="******" {{ isset($log->id) ? '' : 'required' }}
                                            title="Enter Password" />
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('password'))
                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                    <span class="error"></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirm
                                        Password{!! isset($log->id) ? '' : '<span class="text-danger">*</span>' !!}
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" placeholder="******"
                                            {{ isset($log->id) ? '' : 'required' }} title="Enter Confirm Password" />
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
                                    @endif
                                    <span class="error"></span>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
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
                                    <label class="form-label" for="ddlState">State Name<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="ddlState" id="ddlState" class="select2 form-select " required
                                        title="Select State">
                                        <option value="">Select</option>
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
                                    <select name="ddlCity" id="ddlCity" class="select2 form-select "
                                        title="Select District Name" required>
                                        <option value="">Select District</option>

                                    </select>
                                    @if ($errors->has('ddlCity'))
                                        <div class="text-danger">{{ $errors->first('ddlCity') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlArea" class="form-label">Area Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlArea" id="ddlArea" class="select2 form-select "
                                        data-tags="true" required title="Select Area">
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
                                    <label class="form-label" for="txtAddress">Door No / Street / Landmark
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtAddress" id="txtAddress" class="form-control"
                                        placeholder="Enter Door No / Street / Landmark"
                                        value="{{ old('txtAddress') }}" required
                                        title="Enter Door No / Street / Landmark">

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
                                    <input type="text" name="txtPincode" id="txtPincode"
                                        class="form-control numvalidate" placeholder="Enter Pin Code"
                                        value="{{ old('txtPincode') }}" title="Enter Pin Code" required>

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
                                    <input type="text" name="txtProprietorName" id="txtProprietorName"
                                        class="form-control" placeholder="Enter Proprietor Name"
                                        value="{{ old('txtProprietorName') }}" title="Enter Proprietor Name"
                                        required />
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
                                        class="form-control mobilenumber" placeholder="Enter Proprietor Mobile"
                                        value="{{ old('txtProprietorMobile') }}"
                                        title="Enter Proprietor Mobile number" required />
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
                                        class="form-control" placeholder="Enter Proprietor Email"
                                        value="{{ old('txtProprietorEmail') }}" title="Enter Proprietor Email"
                                        required />
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
                                        class="form-control" placeholder="Enter Contact Person Name"
                                        value="{{ old('txtContactPersonName') }}" title="Enter Contact Person Name"
                                        required />
                                    @if ($errors->has('txtContactPersonName'))
                                        <div class="text-danger">{{ $errors->first('txtContactPersonName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtContactPersonMobile">Contact Person Mobile <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtContactPersonMobile" id="txtContactPersonMobile"
                                        class="form-control mobilenumber" placeholder="Enter Contact Person Number"
                                        value="{{ old('txtContactPersonMobile') }}"
                                        title="Enter Contact Person Mobile" required />
                                    @if ($errors->has('txtContactPersonMobile'))
                                        <div class="text-danger">{{ $errors->first('txtContactPersonMobile') }}</div>
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
                                        class="form-control" placeholder="Enter Contact Person Email"
                                        value="{{ old('txtContactPersonEmail') }}" title="Enter Contact Person Email"
                                        required />
                                    @if ($errors->has('txtContactPersonEmail'))
                                        <div class="text-danger">{{ $errors->first('txtContactPersonEmail') }}</div>
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
                                    <div class="col-md-4"></div>
                                @endforeach

                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="mt-4 mb-3">
                                    <button type="submit" id="btnsave" class="btn btn-success">
                                        @if (isset($log->id))
                                            Update
                                        @else
                                            Save
                                        @endif
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="cancel()">Cancel</button>
                                </div>
                                <div class="mt-4 mb-3">
                                    <a href="{{ route('logisticList') }}" class="btn btn-primary">Go To List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/logisticmanagement/logistic.js') }}"></script>
@endsection