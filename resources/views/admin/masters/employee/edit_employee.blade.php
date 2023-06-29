@extends('layouts.main_master')
@section('content')
@section('title')
    Edit Employee | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Edit Employee
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <form method="post" action="{{ url('employee-update') }}" name="employee_edit" id="register-form"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="hdEmployeeUserId" id="hdEmployeeUserId"
                    value="{{ $employee_user_id }}">
                <input type="hidden" name="hdEmployeeId" id="hdEmployeeId"
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
                                    <label class="form-label">Name of the Employee<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtEmployeeName"
                                        name="txtEmployeeName" value="{{ $employees ? $employees->employee_name : '' }}"
                                        placeholder="Enter Employee Name" title="Enter Employee Name" required>
                                    @if ($errors->has('txtEmployeeName'))
                                        <div class="text-danger">{{ $errors->first('txtEmployeeName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Father’s / Spouse Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtFatherSpouseName"
                                        name="txtFatherSpouseName"
                                        value="{{ $employees ? $employees->father_spouse_name : '' }}"
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
                                    <label class="form-label">Gender<span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="radio" class="form-check-input" id="rdGender" name="rdGender"
                                            @if ($employees) @if ($employees->gender == 1) Checked @endif
                                            @endif value="1" title="Select gender" required/>
                                        Male
                                        <input type="radio" class="form-check-input" id="rdGender" name="rdGender"
                                            @if ($employees) @if ($employees->gender == 2) Checked @endif
                                            @endif value="2" title="Select gender" required/>
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
                                    <label class="form-label">Marital Status<span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="radio" class="form-check-input" id="rdMarital" name="rdMarital"
                                            @if ($employees) @if ($employees->marital_status == 1) Checked @endif
                                            @endif value="1" title="Select Marital Status"
                                        required/>
                                        Single
                                        <input type="radio" class="form-check-input" id="rdMarital" name="rdMarital"
                                            @if ($employees) @if ($employees->marital_status == 2) Checked @endif
                                            @endif value="2" title="Select Marital Status"
                                        required/>
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
                                    <label class="form-label">Date of birth<span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="date" name="dtdob" id="dtdob" class="form-control"
                                            value="{{ $employees ? $employees->dob : '' }}" placeholder="DD/MM/YYYY"
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
                                    <label class="form-label">Nationality<span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" name="txtNationality" id="txtNationality"
                                            class="form-control"
                                            value="{{ $employees ? $employees->nationality : '' }}"
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
                                    <label class="form-label">Status
                                        <sup>(Resident/Non-Resident/Foreign National)</sup> </label>
                                    <div class="form-group">
                                        <input type="text" name="txtNationalityStatus" id="txtNationalityStatus"
                                            class="form-control"
                                            value="{{ $employees ? $employees->nationality_status : '' }}"
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
                                    <label class="form-label">Personal Mobile<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="text" id="txtPerMobile" name="txtPerMobile"
                                            class="form-control mobilenumber"
                                            value="{{ $employees ? $employees->personal_mobile : '' }}"
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
                            {{-- 
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Official Mobile</label>
                                    <div class="form-group">
                                        <input type="text" id="txtOfficialMobile" name="txtOfficialMobile"
                                            class="form-control mobilenumber"
                                            value="{{ $employees ? $employees->official_mobile : '' }}"
                                            placeholder="Enter Official Mobile" title="Enter Official Mobile">
                                        @if ($errors->has('txtOfficialMobile'))
                                            <div class="text-danger">{{ $errors->first('txtOfficialMobile') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Personal Email<span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="email" name="email1" id="email1" class="form-control"
                                            value="{{ $employees ? $employees->email1 : '' }}"
                                            placeholder="Enter Personal Email" title="Personal Email" required>
                                        @if ($errors->has('email1'))
                                            <div class="text-danger">{{ $errors->first('email1') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Official Email<span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="email" name="email2" id="email2" class="form-control"
                                            value="{{ $employees ? $employees->email2 : '' }}"
                                            placeholder="Enter Official Email" title="Enter Official Email" required>
                                        @if ($errors->has('email2'))
                                            <div class="text-danger">{{ $errors->first('email2') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Employee Image<span class="text-danger">*</span></label>
                                    <input type="file" name="fileProfileImg" id="fileProfileImg"
                                        class="form-control" title="upload Employee Image">
                                    <div class="img mt-2">
                                        @if ($employees)
                                            <img src="{{ asset($employees->profile_img) }}" id="previewImage1"
                                                width="100" height="100">
                                        @else
                                            <img src="{{ asset('assets\img\avatars\14.png') }}" id="previewImage1"
                                                width="100" height="100">
                                        @endif
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
                                    <label class="form-label">State<span class="text-danger">*</span></label>
                                    <select name="ddlCommState" id="ddlCommState"
                                        class="select2 form-select  state_change" title="Select State" required>
                                        <option value="">Select State</option>
                                        @isset($states)
                                            @foreach ($states as $comm_states)
                                                <option value="{{ $comm_states->id }}"
                                                    @if ($employees) {{ $employees->comm_state_id == $comm_states->id ? 'selected' : '' }} @endif>
                                                    {{ $comm_states->state_name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if ($errors->has('ddlCommState'))
                                        <div class="text-danger">{{ $errors->first('ddlCommState') }}</div>
                                    @endif

                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">District<span class="text-danger">*</span></label>
                                    <select name="ddlCommCity" id="ddlCommCity"
                                        class="select2 form-select  city_change" title="Select District" required>
                                        <option value="">Select District</option>
                                        @isset($comm_city)
                                            @foreach ($comm_city as $comm_citys)
                                                <option value="{{ $comm_citys->id }}"
                                                    @if ($employees) {{ $employees->comm_city_id == $comm_citys->id ? 'selected' : '' }} @endif>
                                                    {{ $comm_citys->city_name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if ($errors->has('ddlCommCity'))
                                        <div class="text-danger">{{ $errors->first('ddlCommCity') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Area<span class="text-danger">*</span></label>
                                    <select name="ddlCommArea" id="ddlCommArea" class="select2 form-select "
                                        data-tags="true" title="Select Area" required>
                                        <option value="">Select Area</option>
                                        @isset($comm_area)
                                            @foreach ($comm_area as $comm_areas)
                                                <option value="{{ $comm_areas->id }}"
                                                    @if ($employees) {{ $employees->comm_area_id == $comm_areas->id ? 'selected' : '' }} @endif>
                                                    {{ $comm_areas->area_name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @if ($errors->has('ddlCommArea'))
                                        <div class="text-danger">{{ $errors->first('ddlCommArea') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Door No/Street/Landmark<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="txtCommAddress"
                                        id="txtCommAddress" value="{{ $employees ? $employees->comm_address : '' }}"
                                        placeholder="Enter Door No/Street/Landmark"
                                        title="Enter Door No/Street/Landmark" required>
                                    @if ($errors->has('txtCommAddress'))
                                        <div class="text-danger">{{ $errors->first('txtCommAddress') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pin Code<span class="text-danger">*</span></label>
                                    <input type="text" name="txtCommPincode" id="txtCommPincode"
                                        class="form-control" value="{{ $employees ? $employees->comm_pincode : '' }}"
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
                                        <label class="form-label">State<span class="text-danger">*</span></label>
                                        <select name="ddlPermState" id="ddlPermState"
                                            class="select2 form-select  state_change" title="Select State" required>
                                            <option value="">Select State</option>
                                            @isset($states)
                                                @foreach ($states as $permanent_states)
                                                    <option value="{{ $permanent_states->id }}"
                                                        @if ($employees) {{ $employees->permanent_state_id == $permanent_states->id ? 'selected' : '' }} @endif>
                                                        {{ $permanent_states->state_name }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        @if ($errors->has('ddlPermState'))
                                            <div class="text-danger">{{ $errors->first('ddlPermState') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">District<span class="text-danger">*</span></label>
                                        <select name="ddlPermCity" id="ddlPermCity"
                                            class="select2 form-select  city_change" title="Select District" required>
                                            <option value="">Select District</option>
                                            @isset($permanent_city)
                                                @foreach ($permanent_city as $permanent_citys)
                                                    <option value="{{ $permanent_citys->id }}"
                                                        @if ($employees) {{ $employees->permanent_city_id == $permanent_citys->id ? 'selected' : '' }} @endif>
                                                        {{ $permanent_citys->city_name }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        @if ($errors->has('ddlPermCity'))
                                            <div class="text-danger">{{ $errors->first('ddlPermCity') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Area<span class="text-danger">*</span></label>
                                        <select name="ddlPermArea" id="ddlPermArea" class="select2 form-select "
                                            data-tags="true" title="Select Area" required>
                                            <option value="">Select Area</option>
                                            @isset($permanent_area)
                                                @foreach ($permanent_area as $permanent_areas)
                                                    <option value="{{ $permanent_areas->id }}"
                                                        @if ($employees) {{ $employees->permanent_area_id == $permanent_areas->id ? 'selected' : '' }} @endif>
                                                        {{ $permanent_areas->area_name }}
                                                    </option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        @if ($errors->has('ddlPermArea'))
                                            <div class="text-danger">{{ $errors->first('ddlPermArea') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Door No/Street/Landmark<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="txtPermAddress" id="txtPermAddress"
                                            class="form-control"
                                            value="{{ $employees ? $employees->permanent_address : '' }}"
                                            placeholder="Enter Door No/Street/Landmark"
                                            title="Enter Door No/Street/Landmark" required>
                                        @if ($errors->has('txtPermAddress'))
                                            <div class="text-danger">{{ $errors->first('txtPermAddress') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pin Code<span class="text-danger">*</span></label>
                                        <input type="text" name="txtPermPincode" id="txtPermPincode"
                                            class="form-control"
                                            value="{{ $employees ? $employees->permanent_pincode : '' }}"
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
                                    <label class="form-label">Mobile 1<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control mobilenumber" id="txtMobile1"
                                        name="txtMobile1" value="{{ $employees ? $employees->mobile1 : '' }}"
                                        placeholder="Enter Mobile 1" title="Mobile 1" required>
                                    @if ($errors->has('txtMobile1'))
                                        <div class="text-danger">{{ $errors->first('txtMobile1') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Relationship 1<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtRelation1" name="txtRelation1"
                                        value="{{ $employees ? $employees->relationship1 : '' }}"
                                        placeholder="Enter Relationship 1" title="Relationship 1" required>
                                    @if ($errors->has('txtRelation1'))
                                        <div class="text-danger">{{ $errors->first('txtRelation1') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Mobile 2<span class="text-danger">*</span></label>
                                    <input type="text" name="txtMobile2" id="txtMobile2"
                                        class="form-control mobilenumber"
                                        value="{{ $employees ? $employees->mobile2 : '' }}"
                                        placeholder="Enter Mobile" title="Enter Mobile 2" required>
                                    @if ($errors->has('txtMobile2'))
                                        <div class="text-danger">{{ $errors->first('txtMobile2') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Relationship 2<span class="text-danger">*</span></label>
                                    <input type="text" id="txtRelation2" name="txtRelation2" class="form-control"
                                        value="{{ $employees ? $employees->relationship2 : '' }}"
                                        placeholder="Enter Relationship 2" title="Enter Relationship 2" required>
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
                                    <label class="form-label">Previous company experience
                                        years</label>
                                    <input type="number" class="form-control" id="numPrevCompanyExp"
                                        name="numPrevCompanyExp" min="0" oninput="validity.valid||(value='');"
                                        value="{{ $employees ? $employees->prev_company_exp_yrs : '' }}"
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
                                    <label class="form-label">Previous company Name</label>
                                    <input type="text" class="form-control"
                                        id="txtPrevCompanyName"name="txtPrevCompanyName"
                                        value="{{ $employees ? $employees->prev_company_name : '' }}"
                                        placeholder="Enter Previous company Name" title="Enter Previous company Name">
                                    @if ($errors->has('txtPrevCompanyName'))
                                        <div class="text-danger">{{ $errors->first('txtPrevCompanyName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Ref By</label>
                                    <input type="text" class="form-control" id="txtPrevCompanyRef"
                                        name="txtPrevCompanyRef"
                                        value="{{ $employees ? $employees->prev_company_ref_by : '' }}"
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
                                    <label class="form-label">Name (As printed in
                                        passbook)<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtAccountName"
                                        name="txtAccountName"
                                        value="{{ $employees ? $employees->account_name : '' }}"
                                        placeholder="Enter Name" title="Enter Name (As printed in passbook" required>
                                    @if ($errors->has('txtAccountName'))
                                        <div class="text-danger">{{ $errors->first('txtAccountName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Account Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control acc_no" id="txtAccountNumber"
                                        name="txtAccountNumber"
                                        value="{{ $employees ? $employees->account_number : '' }}"
                                        placeholder="Enter Account Number" title="Enter Account Number" required>
                                    @if ($errors->has('txtAccountNumber'))
                                        <div class="text-danger">{{ $errors->first('txtAccountNumber') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Bank Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtBankName" name="txtBankName"
                                        value="{{ $employees ? $employees->bank_name : '' }}"
                                        placeholder="Enter Bank Name" title="Enter Bank Name" required>
                                    @if ($errors->has('txtBankName'))
                                        <div class="text-danger">{{ $errors->first('txtBankName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Branch Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtBranchName"
                                        name="txtBranchName" value="{{ $employees ? $employees->branch_name : '' }}"
                                        placeholder="Enter Branch Name" title="Enter Branch Name" required>
                                    @if ($errors->has('txtBranchName'))
                                        <div class="text-danger">{{ $errors->first('txtBranchName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">IFSC Code<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="txtBranchIfsc"
                                        name="txtBranchIfsc" value="{{ $employees ? $employees->ifsc_code : '' }}"
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
                @if (isset($bindDocuments) && $bindDocuments->count() > 0)
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
                                                value="{{ isset($employees) ? $item->document_number : '' }}">
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
                                                value="{{ isset($employees) ? $item->documenttype_name : '' }}">
                                            <input type="hidden" id="hddocumentNum_{{ $item->id }}"
                                                name="hddocumentNum_{{ $item->id }}"
                                                value="{{ isset($employees) ? $item->document_number : '' }}">
                                            <input id="file_{{ $item->id }}" name="file_{{ $item->id }}"
                                                type="file" class="form-control"
                                                @if ($employees == null ? '' : !$employees->id) @if ($item->is_mandatory == 1) required @endif
                                                @endif
                                            accept="application/pdf" id="previewImage1" />
                                            <input type="hidden" name="hdDocumentImg_{{ $item->id }}"
                                                id="hdDocumentImg_{{ $item->id }}"
                                                value="{{ isset($employees) ? $item->document_path : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        @if (isset($employees) && $item->document_path)
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
                                    <label class="form-label" for="basic-default-name">&nbsp;</label>
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
                                    <label class="form-label">Department<span class="text-danger">*</span></label>
                                    <select name="ddlDepartment" id="ddlDepartment" class="select2 form-select "
                                        title="Select Department" required>
                                        <option value="">Select</option>
                                        @if (!empty($departments))
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    @if ($employees) {{ $employees->department_id == $department->id ? 'selected' : '' }} @endif>
                                                    {{ $department->department_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlDepartment'))
                                        <div class="text-danger">{{ $errors->first('ddlDepartment') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Desingation<span class="text-danger">*</span></label>
                                    <select name="ddlDesignation" id="ddlDesignation" class="select2 form-select "
                                        title="Select Desingation" required>
                                        <option value="">Select</option>
                                        @if (!empty($designation))
                                            @foreach ($designation as $designations)
                                                <option value="{{ $designations->id }}"
                                                    @if ($employees) {{ $employees->designation_id == $designations->id ? 'selected' : '' }} @endif>
                                                    {{ $designations->designation_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlDesignation'))
                                        <div class="text-danger">{{ $errors->first('ddlDesignation') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Reporting To</label>
                                    <select name="ddlReportingTo" id="ddlReportingTo" class="select2 form-select "
                                        title="select Reporting To">
                                        <option value="">Select</option>
                                        @if (!empty($user))
                                            @foreach ($user as $users)
                                                <option value="{{ $users->id }}"
                                                    @if ($employees) {{ $employees->reporting_to == $users->id ? 'selected' : '' }} @endif>
                                                    {{ $users->display_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlReportingTo'))
                                        <div class="text-danger">{{ $errors->first('ddlReportingTo') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Role Name<span class="text-danger">*</span></label>
                                    <select name="ddlRoleName" id="ddlRoleName" class="select2 form-select "
                                        title="Select Role Name" required>
                                        <option value="">Select</option>
                                        @if (!empty($roles))
                                            @foreach ($roles as $rolename)
                                                <option value="{{ $rolename->id }}"
                                                    @if ($employees) {{ $employees->role_id == $rolename->id ? 'selected' : '' }} @endif>
                                                    {{ $rolename->role_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlRoleName'))
                                        <div class="text-danger">{{ $errors->first('ddlRoleName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Package<span class="text-danger">*</span></label>
                                    <input type="text" name="txtPackage" id="txtPackage" class="form-control"
                                        value="{{ $employees ? $employees->package : '' }}"
                                        placeholder="Enter Package" title="Enter Package" required>
                                    @if ($errors->has('txtPackage'))
                                        <div class="text-danger">{{ $errors->first('txtPackage') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Date of joining<span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="dtDateOfJoin" id="dtDateOfJoin" class="form-control"
                                        value="{{ $employees ? $employees->date_of_join : '' }}"
                                        title="Enter Date of joining" required>
                                    @if ($errors->has('dtDateOfJoin'))
                                        <div class="text-danger">{{ $errors->first('dtDateOfJoin') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Company Mail ID</label>
                                    <input type="text" name="CompanyMailId" id="CompanyMailId"
                                        class="form-control"
                                        value="{{ $employees ? $employees->company_mail_id : '' }}"
                                        placeholder="Company Mail ID" title="Enter Company Mail ID">
                                    @if ($errors->has('CompanyMailId'))
                                        <div class="text-danger">{{ $errors->first('CompanyMailId') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Company Phone Number</label>
                                    <input type="text" name="txtCompanyMobile" id="txtCompanyMobile"
                                        class="form-control mobilenumber"
                                        value="{{ $employees ? $employees->company_mobile_no : '' }}"
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
                                        class="form-control"
                                        value="{{ $employees ? $employees->originals_given_by : '' }}"
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
                                        @if (!empty($user))
                                            @foreach ($user as $users)
                                                <option value="{{ $users->id }}"
                                                    @if ($employees) {{ $employees->authorised_by == $users->id ? 'selected' : '' }} @endif>
                                                    {{ $users->display_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlOriginalReceived'))
                                        <div class="text-danger">{{ $errors->first('ddlOriginalReceived') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Originals verified by</label>
                                    <select name="ddlOriginalsVerified" id="ddlOriginalsVerified"
                                        class="select2 form-select " title="Enter Originals verified by">
                                        <option value="">Select</option>
                                        @if (!empty($user))
                                            @foreach ($user as $users)
                                                <option value="{{ $users->id }}"
                                                    @if ($employees) {{ $employees->originals_verified_by == $users->id ? 'selected' : '' }} @endif>
                                                    {{ $users->display_name }}
                                                </option>
                                            @endforeach
                                        @endif
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
                                    <label class="form-label">Asset Type<span class="text-danger">*</span></label>
                                    <select name="ddlAssetType" id="ddlAssetType" class="select2 form-select "
                                        title="Select Asset Type">
                                        <option value="">Select</option>
                                        @if (!empty($assettype))
                                            @foreach ($assettype as $assettypes)
                                                <option value="{{ $assettypes->id }}">
                                                    {{ $assettypes->asset_type }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlAssetType'))
                                        <div class="text-danger">{{ $errors->first('ddlAssetType') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Asset Name<span class="text-danger">*</span></label>
                                    <select name="ddlAsset" id="ddlAsset" class="select2 form-select "
                                        title="Select Asset Name">
                                        <option value="">Select</option>
                                    </select>
                                    @if ($errors->has('ddlAsset'))
                                        <div class="text-danger">{{ $errors->first('ddlAsset') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Issued by</label>
                                    <select name="ddlIssuedBy" id="ddlIssuedBy" class="select2 form-select "
                                        title="select Issued by">
                                        <option value="">Select</option>
                                        @if (!empty($user))
                                            @foreach ($user as $users)
                                                <option value="{{ $users->id }}">
                                                    {{ $users->display_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlIssuedBy'))
                                        <div class="text-danger">{{ $errors->first('ddlIssuedBy') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Authorised by</label>
                                    <select name="ddlAuthorisedBy" id="ddlAuthorisedBy" class="select2 form-select "
                                        title="Select Authorised by">
                                        <option value="">Select</option>
                                        @if (!empty($user))
                                            @foreach ($user as $users)
                                                <option value="{{ $users->id }}">
                                                    {{ $users->display_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('ddlAuthorisedBy'))
                                        <div class="text-danger">{{ $errors->first('ddlAuthorisedBy') }}
                                        </div>
                                    @endif
                                    <span class="error"></span>
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
                                    @if ($officeassets != null)
                                        @foreach ($officeassets as $key => $offassets)
                                            <tr id="trasset{{ $key + 1 }}"
                                                ATV="{{ $offassets->asset_type_id }}"
                                                ATT="{{ $offassets->asset_type }}"
                                                ASV="{{ $offassets->asset_id }}"
                                                AST="{{ $offassets->asset_name }}"
                                                ISB="{{ $offassets->issued_by }}"
                                                AUB="{{ $offassets->authorised_by }}">
                                                <td><input type='hidden' class='officeassets'
                                                        id="tabassettypename_{{ $key + 1 }}"
                                                        name='tabAssetTypeName[]'
                                                        value="{{ $offassets->asset_type_id }}"><span
                                                        id='spnAssetType'>{{ $offassets->asset_type }}</span>
                                                </td>
                                                <td><input type='hidden' class='officeassets'
                                                        id="tabassetname_{{ $key + 1 }}" name='tabAssetName[]'
                                                        value="{{ $offassets->asset_id }}"><span
                                                        id='spnAssetName'>{{ $offassets->asset_name }}</span>
                                                </td>
                                                <td><input type='hidden' class='officeassets'
                                                        id="tabissuedby_{{ $key + 1 }}" name='tabIssuedBy[]'
                                                        value="{{ $offassets->issued_by == 0 ? '' : $offassets->issued_by }}"><span
                                                        id='spnIssuedBy'>{{ $offassets->issued_by == 0 ? '' : $offassets->issued_by }}</span>
                                                </td>
                                                <td><input type='hidden' class='officeassets'
                                                        id="tabauthorisedby_{{ $key + 1 }}"
                                                        name='tabAuthorisedBy[]'
                                                        value="{{ $offassets->authorised_by == 0 ? '' : $offassets->issued_by }}"><span
                                                        id='spnAuthorisedBy'>{{ $offassets->authorised_by == 0 ? '' : $offassets->authorised_by }}</span>
                                                </td>
                                                <td>
                                                    <a><i class='text-primary ti ti-pencil me-1'
                                                            onclick="return doEdit({{ $key + 1 }});"></i></a>
                                                    <a><i class='text-danger ti ti-trash me-1'
                                                            onclick="return removeRow({{ $key + 1 }});"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('employee-list') }}" class="btn btn-danger">Cancel</a>
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
