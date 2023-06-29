@extends('layouts.main_master')
@section('content')
@section('title')
    Employee | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Add Employee
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <form method="post" action="{{ url('employee-create') }}" name="employee" id="register-form"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="hdEmployeeId" name="hdEmployeeId"
                    value="{{ $employees ? $employees->id : 0 }}">
                <input type="hidden" name="hdEmployeeImg" id="hdEmployeeImg"
                    value="{{ $employees ? $employees->profile_img : '' }}">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header p-0">
                            <h4>Identity Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtEmployeeName" class="form-label">Name of the Employee<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtEmployeeName"
                                        name="txtEmployeeName" value="{{ old('txtEmployeeName') }}"
                                        placeholder="Enter Employee Name" title="Enter Employee Name" required>
                                    @if ($errors->has('txtEmployeeName'))
                                        <div class="text-danger">{{ $errors->first('txtEmployeeName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtFatherSpouseName" class="form-label">Father’s / Spouse Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtFatherSpouseName"
                                        name="txtFatherSpouseName" value="{{ old('txtFatherSpouseName') }}"
                                        placeholder="Enter Father’s / Spouse Name" title="Enter Father’s / Spouse Name"
                                        required>
                                    @if ($errors->has('txtFatherSpouseName'))
                                        <div class="text-danger">{{ $errors->first('txtFatherSpouseName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rdGender" class="form-label">Gender<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="radio" class="form-check-input" id="rdGender" name="rdGender"
                                            value="1" {{ old('rdGender') == 1 ? 'selected' : '' }}
                                            title="Select gender" required />
                                        Male
                                        <input type="radio" class="form-check-input" id="rdGender" name="rdGender"
                                            value="2" {{ old('rdGender') == 2 ? 'selected' : '' }}
                                            title="Select gender" required />
                                        Female
                                    </div>
                                    @if ($errors->has('rdGender'))
                                        <div class="text-danger">{{ $errors->first('rdGender') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rdMarital" class="form-label">Marital Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="radio" class="form-check-input" id="rdMarital" name="rdMarital"
                                            value="1" {{ old('rdMarital') == 1 ? 'selected' : '' }}
                                            title="Select Marital Status" required />
                                        Single
                                        <input type="radio" class="form-check-input" id="rdMarital" name="rdMarital"
                                            value="2" {{ old('rdMarital') == 2 ? 'selected' : '' }}
                                            title="Select Marital Status" required />
                                        Married
                                    </div>
                                    @if ($errors->has('rdMarital'))
                                        <div class="text-danger">{{ $errors->first('rdMarital') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dtdob" class="form-label">Date of birth<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="date" name="dtdob" id="dtdob" class="form-control"
                                            value="{{ old('dtdob') }}" placeholder="DD/MM/YYYY"
                                            title="Enter Date of birth" required>
                                        @if ($errors->has('dtdob'))
                                            <div class="text-danger">{{ $errors->first('dtdob') }}</div>
                                        @endif
                                        <span class="error"></span>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtNationality" class="form-label">Nationality<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" name="txtNationality" id="txtNationality"
                                            class="form-control" value="{{ old('txtNationality') }}"
                                            placeholder="Enter Nationality" title="Enter Nationality" required>
                                        @if ($errors->has('txtNationality'))
                                            <div class="text-danger">{{ $errors->first('txtNationality') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtNationalityStatus" class="form-label">Status
                                        <sup>(Resident/Non-Resident/Foreign National)</sup> </label>
                                    <div class="form-group">
                                        <input type="text" name="txtNationalityStatus" id="txtNationalityStatus"
                                            class="form-control" value="{{ old('txtNationalityStatus') }}"
                                            placeholder="Enter Status" title="Enter Status">
                                        @if ($errors->has('txtNationalityStatus'))
                                            <div class="text-danger">{{ $errors->first('txtNationalityStatus') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtPerMobile" class="form-label">Personal Mobile<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" id="txtPerMobile" name="txtPerMobile"
                                            class="form-control mobilenumber" value="{{ old('txtPerMobile') }}"
                                            placeholder="Enter Personal Mobile" title="Enter Personal Mobile"
                                            required>
                                        @if ($errors->has('txtPerMobile'))
                                            <div class="text-danger">{{ $errors->first('txtPerMobile') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email1" class="form-label">Personal Email<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="email" name="email1" id="email1" class="form-control"
                                            value="{{ old('email1') }}" placeholder="Enter Personal Email"
                                            title="Personal Email" required>
                                        @if ($errors->has('email1'))
                                            <div class="text-danger">{{ $errors->first('email1') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email2" class="form-label">Official Email<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="email" name="email2" id="email2" class="form-control"
                                            value="{{ old('email2') }}" placeholder="Enter Official Email"
                                            title="Enter Official Email" required>
                                        @if ($errors->has('email2'))
                                            <div class="text-danger">{{ $errors->first('email2') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fileProfileImg" class="form-label">Employee Image<span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="fileProfileImg" id="fileProfileImg"
                                        class="form-control" title="upload Employee Image">
                                    <div class="img mt-2">
                                        <img src="{{ asset('assets/img/avatars/14.png') }}" id="previewImage1"
                                            width="100" height="100">
                                    </div>
                                    @if ($errors->has('fileProfileImg'))
                                        <div class="text-danger">{{ $errors->first('fileProfileImg') }}</div>
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
                            <h4>Address Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong class="form-label">Communication Address</strong>
                                </div>
                                <div class="mb-3">
                                    <label for="ddlCommState" class="form-label">State<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlCommState" id="ddlCommState"
                                        class="select2 form-select  state_change" title="Select State" required>
                                        <option value="">Select State</option>
                                        @foreach ($states as $comm_states)
                                            <option value="{{ $comm_states->id }}"
                                                {{ old('ddlCommState') == $comm_states->id ? 'selected' : '' }}>
                                                {{ $comm_states->state_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlCommState'))
                                        <div class="text-danger">{{ $errors->first('ddlCommState') }}</div>
                                    @endif

                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="ddlCommCity" class="form-label">District<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlCommCity" id="ddlCommCity"
                                        class="select2 form-select  city_change" title="Select District" required>
                                        <option value="">Select District</option>
                                    </select>
                                    @if ($errors->has('ddlCommCity'))
                                        <div class="text-danger">{{ $errors->first('ddlCommCity') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="ddlCommArea" class="form-label">Area<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlCommArea" id="ddlCommArea" class="select2 form-select "
                                        data-tags="true" title="Select Area" required>
                                        <option value="">Select Area</option>
                                    </select>
                                    @if ($errors->has('ddlCommArea'))
                                        <div class="text-danger">{{ $errors->first('ddlCommArea') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="txtCommAddress" class="form-label">Door No/Street/Landmark<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="txtCommAddress"
                                        id="txtCommAddress" value="{{ old('txtCommAddress') }}"
                                        placeholder="Enter Door No/Street/Landmark"
                                        title="Enter Door No/Street/Landmark" required>
                                    @if ($errors->has('txtCommAddress'))
                                        <div class="text-danger">{{ $errors->first('txtCommAddress') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="txtCommPincode" class="form-label">Pin Code<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtCommPincode" id="txtCommPincode"
                                        class="form-control" value="{{ old('txtCommPincode') }}"
                                        placeholder="Enter Pin Code" title="Enter PinCode" required>
                                    @if ($errors->has('txtCommPincode'))
                                        <div class="text-danger">{{ $errors->first('txtCommPincode') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong class="form-label">Permanent Address</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <input type="checkbox" id="chkSameAddress"> Same as Communication
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="ddlPermState" class="form-label">State<span
                                                class="text-danger">*</span></label>
                                        <select name="ddlPermState" id="ddlPermState"
                                            class="select2 form-select  state_change" title="Select State" required>
                                            <option value="">Select State</option>
                                            @foreach ($states as $permanent_states)
                                                <option value="{{ $permanent_states->id }}"
                                                    {{ old('ddlPermState') == $permanent_states->id ? 'selected' : '' }}>
                                                    {{ $permanent_states->state_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('ddlPermState'))
                                            <div class="text-danger">{{ $errors->first('ddlPermState') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ddlPermCity" class="form-label">District<span
                                                class="text-danger">*</span></label>
                                        <select name="ddlPermCity" id="ddlPermCity"
                                            class="select2 form-select  city_change" title="Select District" required>
                                            <option value="">Select District</option>
                                        </select>
                                        @if ($errors->has('ddlPermCity'))
                                            <div class="text-danger">{{ $errors->first('ddlPermCity') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ddlPermArea" class="form-label">Area<span
                                                class="text-danger">*</span></label>
                                        <select name="ddlPermArea" id="ddlPermArea" class="select2 form-select "
                                            data-tags="true" title="Select Area" required>
                                            <option value="">Select Area</option>
                                        </select>
                                        @if ($errors->has('ddlPermArea'))
                                            <div class="text-danger">{{ $errors->first('ddlPermArea') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtPermAddress" class="form-label">Door No/Street/Landmark<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="txtPermAddress" id="txtPermAddress"
                                            class="form-control" value="{{ old('txtPermAddress') }}"
                                            placeholder="Enter Door No/Street/Landmark"
                                            title="Enter Door No/Street/Landmark" required>
                                        @if ($errors->has('txtPermAddress'))
                                            <div class="text-danger">{{ $errors->first('txtPermAddress') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="txtPermPincode" class="form-label">Pin Code<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="txtPermPincode" id="txtPermPincode"
                                            class="form-control" value="{{ old('txtPermPincode') }}"
                                            placeholder="Enter Pin Code" title="Enter Pin Code" required>
                                        @if ($errors->has('txtPermPincode'))
                                            <div class="text-danger">{{ $errors->first('txtPermPincode') }}
                                            </div>
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
                            <h4>Emergency Contact Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="txtMobile1" class="form-label">Mobile 1<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control mobilenumber" id="txtMobile1"
                                        name="txtMobile1" value="{{ old('txtMobile1') }}"
                                        placeholder="Enter Mobile 1" title="Mobile 1" required>
                                    @if ($errors->has('txtMobile1'))
                                        <div class="text-danger">{{ $errors->first('txtMobile1') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="txtRelation1" class="form-label">Relationship 1<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtRelation1" name="txtRelation1"
                                        value="{{ old('txtRelation1') }}" placeholder="Enter Relationship 1"
                                        title="Relationship 1" required>
                                    @if ($errors->has('txtRelation1'))
                                        <div class="text-danger">{{ $errors->first('txtRelation1') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="txtMobile2" class="form-label">Mobile 2<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtMobile2" id="txtMobile2"
                                        class="form-control mobilenumber" value="{{ old('txtMobile2') }}"
                                        placeholder="Enter Mobile" title="Enter Mobile 2" required>
                                    @if ($errors->has('txtMobile2'))
                                        <div class="text-danger">{{ $errors->first('txtMobile2') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="txtRelation2" class="form-label">Relationship 2<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="txtRelation2" name="txtRelation2" class="form-control"
                                        value="{{ old('txtRelation2') }}" placeholder="Enter Relationship 2"
                                        title="Enter Relationship 2" required>
                                    @if ($errors->has('txtRelation2'))
                                        <div class="text-danger">{{ $errors->first('txtRelation2') }}</div>
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
                            <h4>Previous Company Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="numPrevCompanyExp" class="form-label">Previous company experience
                                        years</label>
                                    <input type="number" class="form-control" id="numPrevCompanyExp"
                                        name="numPrevCompanyExp" min="0" oninput="validity.valid||(value='');"
                                        value="{{ old('numPrevCompanyExp') }}"
                                        placeholder="Enter Previous company experience years"
                                        title="Enter Previous company experience years">
                                    @if ($errors->has('numPrevCompanyExp'))
                                        <div class="text-danger">{{ $errors->first('numPrevCompanyExp') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtPrevCompanyName" class="form-label">Previous company Name</label>
                                    <input type="text" class="form-control"
                                        id="txtPrevCompanyName"name="txtPrevCompanyName"
                                        value="{{ old('txtPrevCompanyName') }}"
                                        placeholder="Enter Previous company Name" title="Enter Previous company Name">
                                    @if ($errors->has('txtPrevCompanyName'))
                                        <div class="text-danger">{{ $errors->first('txtPrevCompanyName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtPrevCompanyRef" class="form-label">Ref By</label>
                                    <input type="text" class="form-control" id="txtPrevCompanyRef"
                                        name="txtPrevCompanyRef" value="{{ old('txtPrevCompanyRef') }}"
                                        placeholder="Enter Ref By" title="Enter Ref By">
                                    @if ($errors->has('txtPrevCompanyRef'))
                                        <div class="text-danger">{{ $errors->first('txtPrevCompanyRef') }}</div>
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
                            <h4>Bank Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtAccountName" class="form-label">Name (As printed in
                                        passbook)<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtAccountName"
                                        name="txtAccountName" value="{{ old('txtAccountName') }}"
                                        placeholder="Enter Name" title="Enter Name (As printed in passbook" required>
                                    @if ($errors->has('txtAccountName'))
                                        <div class="text-danger">{{ $errors->first('txtAccountName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtAccountNumber" class="form-label">Account Number<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control acc_no" id="txtAccountNumber"
                                        name="txtAccountNumber" value="{{ old('txtAccountNumber') }}"
                                        placeholder="Enter Account Number" title="Enter Account Number" required>
                                    @if ($errors->has('txtAccountNumber'))
                                        <div class="text-danger">{{ $errors->first('txtAccountNumber') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtBankName" class="form-label">Bank Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtBankName" name="txtBankName"
                                        value="{{ old('txtBankName') }}" placeholder="Enter Bank Name"
                                        title="Enter Bank Name" required>
                                    @if ($errors->has('txtBankName'))
                                        <div class="text-danger">{{ $errors->first('txtBankName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtBranchName" class="form-label">Branch Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtBranchName"
                                        name="txtBranchName" value="{{ old('txtBranchName') }}"
                                        placeholder="Enter Branch Name" title="Enter Branch Name" required>
                                    @if ($errors->has('txtBranchName'))
                                        <div class="text-danger">{{ $errors->first('txtBranchName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtBranchIfsc" class="form-label">IFSC Code<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtBranchIfsc"
                                        name="txtBranchIfsc" value="{{ old('txtBranchIfsc') }}"
                                        placeholder="Enter IFSC Code" title="Enter IFSC Code" required>
                                    @if ($errors->has('txtBranchIfsc'))
                                        <div class="text-danger">{{ $errors->first('txtBranchIfsc') }}</div>
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
                                                @if ($item->is_mandatory == 1) required @endif
                                                accept="application/pdf" id="previewImage1" />
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
                            <h4>For Office Use Only</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtEmployeeCode" class="form-label"
                                        for="basic-default-name">&nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon11">Employee ID</span>
                                        <input type="text" class="form-control" name="txtEmployeeCode"
                                            id="txtEmployeeCode" readonly placeholder="EMP001"
                                            value="{{ $manExample }}" aria-label=""
                                            aria-describedby="basic-addon11" title="Enter Employee ID" required />
                                        @if ($errors->has('txtEmployeeCode'))
                                            <div class="text-danger">{{ $errors->first('txtEmployeeCode') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlDepartment" class="form-label">Department<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlDepartment" id="ddlDepartment" class="select2 form-select "
                                        title="Select Department" required>
                                        <option value="">Select</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('ddlDepartment') == $department->id ? 'selected' : '' }}>
                                                {{ $department->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlDepartment'))
                                        <div class="text-danger">{{ $errors->first('ddlDepartment') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlDesignation" class="form-label">Desingation<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlDesignation" id="ddlDesignation" class="select2 form-select "
                                        title="Select Desingation" required>
                                        <option value="">Select</option>
                                        @foreach ($designation as $designations)
                                            <option value="{{ $designations->id }}"
                                                {{ old('ddlDesignation') == $designations->id ? 'selected' : '' }}>
                                                {{ $designations->designation_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlDesignation'))
                                        <div class="text-danger">{{ $errors->first('ddlDesignation') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlReportingTo" class="form-label">Reporting To</label>
                                    <select name="ddlReportingTo" id="ddlReportingTo" class="select2 form-select "
                                        title="select Reporting To">
                                        <option value="">Select</option>
                                        @foreach ($user as $users)
                                            <option value="{{ $users->id }}"
                                                {{ old('ddlReportingTo') == $users->id ? 'selected' : '' }}>
                                                {{ $users->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlReportingTo'))
                                        <div class="text-danger">{{ $errors->first('ddlReportingTo') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlRoleName" class="form-label">Role Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlRoleName" id="ddlRoleName" class="select2 form-select "
                                        title="Select Role Name" required>
                                        <option value="">Select</option>
                                        @foreach ($roles as $rolename)
                                            <option value="{{ $rolename->id }}"
                                                {{ old('ddlRoleName') == $rolename->id ? 'selected' : '' }}>
                                                {{ $rolename->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlRoleName'))
                                        <div class="text-danger">{{ $errors->first('ddlRoleName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtPackage" class="form-label">Package<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtPackage" id="txtPackage" class="form-control"
                                        value="{{ old('txtPackage') }}" placeholder="Enter Package"
                                        title="Enter Package" required>
                                    @if ($errors->has('txtPackage'))
                                        <div class="text-danger">{{ $errors->first('txtPackage') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dtDateOfJoin" class="form-label">Date of joining<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="dtDateOfJoin" id="dtDateOfJoin" class="form-control"
                                        value="{{ old('dtDateOfJoin') }}" title="Enter Date of joining" required>
                                    @if ($errors->has('dtDateOfJoin'))
                                        <div class="text-danger">{{ $errors->first('dtDateOfJoin') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="CompanyMailId" class="form-label">Company Mail ID</label>
                                    <input type="text" name="CompanyMailId" id="CompanyMailId"
                                        class="form-control" value="{{ old('CompanyMailId') }}"
                                        placeholder="Company Mail ID" title="Enter Company Mail ID">
                                    @if ($errors->has('CompanyMailId'))
                                        <div class="text-danger">{{ $errors->first('CompanyMailId') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtCompanyMobile" class="form-label">Company Phone Number</label>
                                    <input type="text" name="txtCompanyMobile" id="txtCompanyMobile"
                                        class="form-control mobilenumber" value="{{ old('txtCompanyMobile') }}"
                                        placeholder="Enter Phone Number" title="Enter Company Phone Number">
                                    @if ($errors->has('txtCompanyMobile'))
                                        <div class="text-danger">{{ $errors->first('txtCompanyMobile') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtOriginalGiven" class="form-label">Originals given by</label>
                                    <input type="text" name="txtOriginalGiven" id="txtOriginalGiven"
                                        class="form-control" value="{{ old('txtOriginalGiven') }}"
                                        placeholder="Enter originals given by" title="Enter originals given by">
                                    @if ($errors->has('txtOriginalGiven'))
                                        <div class="text-danger">{{ $errors->first('txtOriginalGiven') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Originals received by</label>
                                    <select name="ddlOriginalReceived" id="ddlOriginalReceived"
                                        class="select2 form-select " title="Enter Originals received by">
                                        <option value="">Select</option>
                                        @foreach ($user as $users)
                                            <option value="{{ $users->id }}"
                                                {{ old('ddlOriginalReceived') == $users->id ? 'selected' : '' }}>
                                                {{ $users->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlOriginalReceived'))
                                        <div class="text-danger">{{ $errors->first('ddlOriginalReceived') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlOriginalsVerified" class="form-label">Originals verified by</label>
                                    <select name="ddlOriginalsVerified" id="ddlOriginalsVerified"
                                        class="select2 form-select " title="Enter Originals verified by">
                                        <option value="">Select</option>
                                        @foreach ($user as $users)
                                            <option value="{{ $users->id }}"
                                                {{ old('ddlOriginalReceived') == $users->id ? 'selected' : '' }}>
                                                {{ $users->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlOriginalsVerified'))
                                        <div class="text-danger">{{ $errors->first('ddlOriginalsVerified') }}
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
                        <div class="card-header p-0">
                            <h4>Office Assets</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="ddlAssetType" class="form-label">Asset Type</label>
                                    <select name="ddlAssetType" id="ddlAssetType" class="select2 form-select "
                                        title="Select Asset Type">
                                        <option value="">Select Asset Type</option>
                                        @foreach ($assettype as $assettypes)
                                            <option value="{{ $assettypes->id }}"
                                                {{ old('ddlAssetType') == $assettypes->id ? 'selected' : '' }}>
                                                {{ $assettypes->asset_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlAssetType'))
                                        <div class="text-danger">{{ $errors->first('ddlAssetType') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="ddlAsset" class="form-label">Asset Name</label>
                                    <select name="ddlAsset" id="ddlAsset" class="select2 form-select "
                                        title="Select Asset Name">
                                        <option value="">Select Asset Name</option>
                                    </select>
                                    @if ($errors->has('ddlAsset'))
                                        <div class="text-danger">{{ $errors->first('ddlAsset') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="ddlIssuedBy" class="form-label">Issued by</label>
                                    <select name="ddlIssuedBy" id="ddlIssuedBy" class="select2 form-select "
                                        title="Select Issued By">
                                        <option value="">Select Issued By</option>
                                        @foreach ($user as $users)
                                            <option value="{{ $users->id }}"
                                                {{ old('ddlIssuedBy') == $users->id ? 'selected' : '' }}>
                                                {{ $users->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlIssuedBy'))
                                        <div class="text-danger">{{ $errors->first('ddlIssuedBy') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="ddlAuthorisedBy" class="form-label">Authorised by</label>
                                    <select name="ddlAuthorisedBy" id="ddlAuthorisedBy" class="select2 form-select "
                                        title="Select Authorised By">
                                        <option value="">Select Authorised By</option>
                                        @if (!empty($user))
                                            @foreach ($user as $users)
                                                <option value="{{ $users->id }}"
                                                    {{ old('ddlAuthorisedBy') == $users->id ? 'selected' : '' }}>
                                                    {{ $users->display_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlAuthorisedBy'))
                                        <div class="text-danger">{{ $errors->first('ddlAuthorisedBy') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <img src="{{ asset('upload/common/add.png') }}" class="img-fluid"
                                        onclick="return addOfficeAsset();" id="btnAddOfficeAsset"
                                        width="50px"height="50px" style="margin-top:18px; cursor:pointer;">
                                    <img src="{{ asset('upload/common/addgreen.png') }}" class="img-fluid"
                                        onclick="return addOfficeAsset();" id="btnUpdateOfficeAsset" width="40"
                                        style="margin-top:21px; cursor:pointer; display: none">
                                    <input type="hidden" id="hdEditOfficeAssetRowId" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable table-responsive pt-0">
                            <table class="table table-responsive">
                                <thead>
                                    <th>Asset Type</th>
                                    <th>Asset Name</th>
                                    <th>Issued by</th>
                                    <th>Authorised by</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="tbodyOfficeAssets">

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" onclick="cancel();"
                                        class="btn btn-danger btnSave">Cancel</button></a>
                                </div>
                                <div class="mt-4 mb-3">
                                    <a href="{{ route('employee-list') }}" class="btn btn-primary">Go To List</a>
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
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script src="{{ asset('assets/js/admin/masters/employee.js') }}"></script>

<script>
    var state_id = 0;
    var selected = '';

    $('.state_change').change(function(e) {
        $("#pageloader").fadeIn();
        e.preventDefault();
        if ($(this).attr('id') != 'ddlPermState') {
            var stateid = 'ddlCommCity';

        } else {
            var stateid = 'ddlPermCity';

        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get-city') }}",
            type: "POST",
            data: {
                id: $(this).val()
            },
            success: function(data) {
                var selOpts = "<option>Select District</option>";
                $.each(data, function(k, v) {
                    var id = data[k].id;
                    var val = data[k].city_name;

                    selOpts += "<option value='" + id + "'" + selected + ">" + val +
                        "</option>";
                });
                $('#' + stateid).html(selOpts);
                // city();
                $("#pageloader").fadeOut();
            }
        });

    });

    $('.city_change').change(function(e) {
        $("#pageloader").fadeIn();
        e.preventDefault();
        if ($(this).attr('id') != 'ddlPermCity') {
            var stateid = 'ddlCommArea';

        } else {
            var stateid = 'ddlPermArea';

        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('getareabycity') }}",
            type: "POST",
            data: {
                city_id: $(this).val()
            },
            success: function(data) {
                var selOpts = "<option>Select Area</option>";
                if (data.length == 0) {
                    selOpts += "<option value='0'>Select</option>";
                }
                $.each(data, function(k, v) {
                    var id = data[k].id;
                    var val = data[k].area_name;

                    selOpts += "<option value='" + id + "'" + selected + ">" + val +
                        "</option>";
                });
                $('#' + stateid).html(selOpts);
                $("#pageloader").fadeOut();
            }
        });
    });
</script>

@if ($employees != '')
    <script>
        $(function() {
            var $radios = $('input:radio[name=gender]');
            if ($radios.is(':checked') === false) {
                $radios.filter('[value={!! isset($employees->gender) !!}]').prop('checked', true);
            }
        });
    </script>
@endif
@endsection
