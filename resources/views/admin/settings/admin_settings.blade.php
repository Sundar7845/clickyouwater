@extends('layouts.main_master') @section('content')
@section('title')
    Admin Settings | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Admin Settings
    </h4>
    <div class="card-body">
        {{-- <form class="browser-default-validation"> --}}
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="nav-align-top mb-4">
                    <div class="card tab-content">
                        <form method="post" action="{{ route('adminsettingscreate') }}" name="admin_settings"
                            id="register-form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 d-flex justify-content-start">
                                    <i class="menu-icon tf-icons ti ti-settings"></i>Maintenance Mode
                                </div>

                                <div class="col-md-3  d-flex justify-content-start">
                                    <label class="switch">
                                        <input onclick="doMaintenanceMode(1);" id="chkmaintenance1" type="checkbox"
                                            class="switch-input" name="chkmaintenance"
                                            @if (isset($adminsettings)) {{ $adminsettings->is_maintenace_mode == 1 ? 'checked' : '' }} @endif />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- </form> --}}
    </div>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            {{-- <div class="card"> --}}
            <div class="card-body">
                {{-- <form class="browser-default-validation"> --}}
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-home"
                                        aria-controls="navs-pills-justified-home" aria-selected="true">
                                        <i class="tf-icons ti ti-user ti-xs me-1"></i> Admin
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-profile"
                                        aria-controls="navs-pills-justified-profile" aria-selected="false">
                                        <i class="tf-icons ti ti-message-dots ti-xs me-1"></i> SMS
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-messages"
                                        aria-controls="navs-pills-justified-messages" aria-selected="false">
                                        <i class="tf-icons ti ti-world ti-xs me-1"></i> GeoAPI
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-paymentgateway"
                                        aria-controls="navs-pills-justified-paymentgateway" aria-selected="false">
                                        <i class="menu-icon tf-icons ti ti-xs ti-file-dollar"></i> Payment Gateway
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="navs-pills-justified-home" role="tabpanel">
                                    <form method="post" action="{{ route('adminsettingscreate') }}"
                                        name="admin_settings" id="register-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">OTP Length<span class="text-danger">*</span>
                                                    <span></span>
                                                </label>
                                                <input type="hidden" name="id" id="id"
                                                    value="@if (isset($adminsettings)) {{ $adminsettings->id ? $adminsettings->id : '' }}@else{{ 'new' }} @endif">
                                                <input type="hidden" name="hdAdmin_logo" id="hdAdmin_logo"
                                                    value="@if (isset($adminsettings)) {{ $adminsettings->company_logo }} @endif">
                                                <input type="hidden" name="hdApp_logo" id="hdApp_logo"
                                                    value="@if (isset($adminsettings)) {{ $adminsettings->app_logo }} @endif">
                                                <input type="number" class="form-control" name="otp_length"
                                                    id="otp_length" min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="{{ $adminsettings->otp_length }}" placeholder="OTP Length">
                                                @if ($errors->has('otp_length'))
                                                    <span class="text-danger">{{ $errors->first('otp_length') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">OTP Expiry Duration <small
                                                        class="text-muted">(mins)</small><span
                                                        class="text-danger">*</span> <span></span>
                                                </label>

                                                <input type="number" class="form-control" name="otp_expiry_duration"
                                                    id="otp_expiry_duration" min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="{{ $adminsettings->otp_expiry_duration }}"
                                                    placeholder="OTP Expiry Duration">
                                                @if ($errors->has('otp_expiry_duration'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('otp_expiry_duration') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Referral Code Length<span
                                                        class="text-danger">*</span>
                                                    <span></span>
                                                </label>
                                                <input type="number" class="form-control"
                                                    name="referral_code_length" id="referral_code_length"
                                                    min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="{{ $adminsettings->referral_code_length }}"
                                                    placeholder="Referral Code Length">
                                                @if ($errors->has('referral_code_length'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('referral_code_length') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Additional Delivery Charge <small
                                                        class="text-muted">(₹)</small><span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control"
                                                    name="additional_delivery_charge" id="additional_delivery_charge"
                                                    min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="{{ $adminsettings->additional_delivery_charge }}"
                                                    placeholder="Additional delivery charges">
                                                @if ($errors->has('additional_delivery_charge'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('additional_delivery_charge') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Show Orders to Manufacturer After <small
                                                        class="text-muted">(hrs)</small><span
                                                        class="text-danger">*</span> <span></span>
                                                </label>

                                                <input type="number" class="form-control" name="show_orders_to_manufacturer"
                                                    id="show_orders_to_manufacturer" min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="{{ $adminsettings->show_orders_to_manufacturer }}"
                                                    placeholder="Show Orders to Manufacturer After">
                                                @if ($errors->has('show_orders_to_manufacturer'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('show_orders_to_manufacturer') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Company Name<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="company_name"
                                                    id="company_name"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->company_name }}@endif"
                                                    placeholder="Enter Company Name">
                                                @if ($errors->has('company_name'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('company_name') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Company Address<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="company_address"
                                                    id="company_address"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->company_address }}@endif"
                                                    placeholder="Enter Company Address">
                                                @if ($errors->has('company_address'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('company_address') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Company Contact Number<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control mobilenumber"
                                                    name="company_contactno" id="company_contactno"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->company_contactno }}@endif"
                                                    placeholder="Enter Company Contact Number">
                                                @if ($errors->has('company_contactno'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('company_contactno') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Company Email<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="email" class="form-control" name="company_email"
                                                    id="company_email"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->company_email }}@endif"
                                                    placeholder="Enter Company Email">
                                                @if ($errors->has('company_email'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('company_email') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">GST No<span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="gstin"
                                                    id="gstin"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->gstin }}@endif"
                                                    placeholder="Enter Privacy Policy URL">
                                                @if ($errors->has('gstin'))
                                                    <span class="text-danger">{{ $errors->first('gstin    ') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Privacy Policy URL<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="privacy_policy_url"
                                                    id="privacy_policy_url"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->privacy_policy_url }}@endif"
                                                    placeholder="Enter Privacy Policy URL">
                                                @if ($errors->has('privacy_policy_url'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('privacy_policy_url') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Terms & Condition URL<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="terms_conditions_url" id="terms_conditions_url"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->terms_conditions_url }}@endif"
                                                    placeholder="Enter Terms & Condition URL">
                                                @if ($errors->has('terms_conditions_url'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('terms_conditions_url') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Cancellation & Refund Policy URL<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="cancellation_refund_url" id="cancellation_refund_url"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->cancellation_refund_url }}@endif"
                                                    placeholder="Enter Cancellation & Refund Policy URL">
                                                @if ($errors->has('cancellation_refund_url'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('cancellation_refund_url') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Shipping & Delivery Policy URL<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="shipping_delivery_url" id="shipping_delivery_url"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->shipping_delivery_url }}@endif"
                                                    placeholder="Enter Shipping & Delivery Policy URL">
                                                @if ($errors->has('shipping_delivery_url'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('shipping_delivery_url') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Play Store URL<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="play_store_url" id="play_store_url"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->play_store_url }}@endif"
                                                    placeholder="Enter Play Store URL">
                                                @if ($errors->has('play_store_url'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('play_store_url') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">App Store URL<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="app_store_url" id="app_store_url"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->app_store_url }}@endif"
                                                    placeholder="Enter App Store URL">
                                                @if ($errors->has('app_store_url'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('app_store_url') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Company Website<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="company_website"
                                                    id="company_website"
                                                    value="@if(isset($adminsettings)){{ $adminsettings->company_website }}@endif"
                                                    placeholder="Enter Company Website">
                                                @if ($errors->has('company_website'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('company_website') }}</span>
                                                @endif
                                            </div>
                                            {{-- <div class="col-md-4 mb-3">
                                                <label class="form-label">Order Cancel Thrashold Duration<small
                                                    class="text-muted">(mins)</small><span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control"
                                                    name="order_cancel_threshold_duration"
                                                    id="order_cancel_threshold_duration" min="0"
                                                    step=".01" oninput="validity.valid||(value='');"
                                                    value="@if (isset($adminsettings)) {{ $adminsettings->order_cancel_threshold_duration }} @endif"
                                                    placeholder="Enter Order Cancel Thrashold Duration">
                                                @if ($errors->has('order_cancel_thrashold_duration'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('order_cancel_thrashold_duration') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Notify Expire days<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control" name="notify_expire_days"
                                                    id="notify_expire_days" min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="@if (isset($adminsettings)) {{ $adminsettings->notify_expire_days }} @endif"
                                                    placeholder="Enter Notify Expire days">
                                                @if ($errors->has('notify_expire_days'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('notify_expire_days') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Manufacture Order Delay<small
                                                    class="text-muted">(mins)</small><span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control"
                                                    name="manufacture_order_delay" id="manufacture_order_delay"
                                                    min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="@if (isset($adminsettings)) {{ $adminsettings->manufacture_order_delay }} @endif"
                                                    placeholder="Enter Manufacture Order Delay">
                                                @if ($errors->has('manufacture_order_delay'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('manufacture_order_delay') }}</span>
                                                @endif
                                            </div> --}}
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Company Logo<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <div class="upload__box">
                                                    <div class="upload__btn-box">

                                                        <input type="file" name="company_logo" id="company_logo"
                                                            data-max_length="20" class="form-control">
                                                    </div>
                                                    <div class="upload__img-wrap"></div>
                                                    @if (isset($adminsettings->company_logo))
                                                        <div class="logo"><img
                                                                src="{{ asset($adminsettings->company_logo) }}"
                                                                alt="" width="200px">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">App Logo<span class="text-danger">*</span>
                                                </label>
                                                <div class="upload__box">
                                                    <div class="upload__btn-box">

                                                        <input type="file" name="app_logo" id="app_logo"
                                                            data-max_length="20" class="form-control">
                                                    </div>
                                                    <div class="upload__img-wrap"></div>
                                                    @if (isset($adminsettings->app_logo))
                                                        <div class="app_logo"><img
                                                                src="{{ asset($adminsettings->app_logo) }}"
                                                                alt="" width="200px">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mt-3">
                                                    <button type="submit"
                                                        class="btn btn-success me-1 submit">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                    <form method="post" action="{{ route('smssettingscreate') }}"
                                        name="admin_settings" id="register-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">API Url<span
                                                            class="text-danger">*</span>
                                                        <span></span>
                                                    </label>
                                                    <input type="hidden" name="id"
                                                        value="@if (isset($smssettings)) {{ $smssettings->id ? $smssettings->id : '' }}@else{{ 'new' }} @endif">
                                                    <input type="text" class="form-control" name="api_url"
                                                        id="api_url"
                                                        value="@if (isset($smssettings)) {{ $smssettings->api_url }} @endif"
                                                        placeholder="API Url">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">UID<span class="text-danger">*</span>
                                                        <span></span>
                                                    </label>
                                                    <input type="text" class="form-control" name="uid"
                                                        id="uid"
                                                        value="@if (isset($smssettings)) {{ $smssettings->uid }} @endif"
                                                        placeholder="UID">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">PWD<span class="text-danger">*</span>
                                                        <span></span>
                                                    </label>
                                                    <input type="text" class="form-control" name="pwd"
                                                        id="pwd"
                                                        value="@if (isset($smssettings)) {{ $smssettings->pwd }} @endif"
                                                        placeholder="PWD">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Sender Id<span
                                                            class="text-danger">*</span> <span></span>
                                                    </label>
                                                    <input type="text" class="form-control" name="senderid"
                                                        id="senderid"
                                                        value="@if (isset($smssettings)) {{ $smssettings->senderid }} @endif"
                                                        placeholder="Sender ID">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Entity Id<span
                                                            class="text-danger">*</span> <span></span>
                                                    </label>
                                                    <input type="text" class="form-control" name="entityid"
                                                        id="entityid"
                                                        value="@if (isset($smssettings)) {{ $smssettings->entityid }} @endif"
                                                        placeholder="Entity ID">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">OTP Message Temp Id<span
                                                            class="text-danger">*</span> <span></span>
                                                    </label>
                                                    <input type="text" class="form-control" name="otp_msg_tempid"
                                                        id="otp_msg_tempid"
                                                        value="@if (isset($smssettings)) {{ $smssettings->otp_msg_tempid }} @endif"
                                                        placeholder="OTP Message Temp ID">
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label class="form-label">OTP Message<span
                                                            class="text-danger">*</span> <span></span>
                                                    </label>
                                                    <input type="text" class="form-control" name="otp_msg"
                                                        id="otp_msg"
                                                        value="@if (isset($smssettings)) {{ $smssettings->otp_msg }} @endif"
                                                        placeholder="OTP Messsage">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mt-3">
                                                    <button type="submit"
                                                        class="btn btn-success me-1 submit">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                                    <form method="post" action="{{ route('geoapisettingscreate') }}"
                                        name="admin_settings" id="register-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">API Url<span class="text-danger">*</span>
                                                </label>
                                                <input type="hidden" name="id"
                                                    value="@if (isset($geoapisettings)) {{ $geoapisettings->id ? $geoapisettings->id : '' }}@else{{ 'new' }} @endif">
                                                <input type="text" class="form-control" name="api_url"
                                                    id="api_url"
                                                    value="@if (isset($geoapisettings)) {{ $geoapisettings->api_url }} @endif"
                                                    placeholder="API Url" required>
                                            </div>
                                            <div class="col-md-4  mb-3">
                                                <label class="form-label">API Key<span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="api_key"
                                                    id="api_key"
                                                    value="@if (isset($geoapisettings)) {{ $geoapisettings->api_key }} @endif"
                                                    placeholder="API Key" required>
                                            </div>
                                            <div class="col-md-4  mb-3">
                                                <label class="form-label">Firebase Key<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="firebase_key"
                                                    id="firebase_key"
                                                    value="@if (isset($geoapisettings)) {{ $geoapisettings->firebase_key }} @endif"
                                                    placeholder="Firebase Key" required>
                                            </div>
                                            <div class="col-md-4  mb-3">
                                                <label class="form-label">FCM Send ID<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" name="fcm_sender_id"
                                                    id="fcm_sender_id"
                                                    value="@if (isset($geoapisettings)) {{ $geoapisettings->fcm_sender_id }} @endif"
                                                    placeholder="FCM Send ID" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4  mb-3">
                                            <div class="mt-3">
                                                <button type="submit"
                                                    class="btn btn-success me-1 submit">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-paymentgateway" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @isset($paymentmethodRazorpay)
                                                <form method="post"
                                                    action="{{ route('paymentGatewaterazorpaycreate', [$paymentmethodRazorpay->id]) }}"
                                                    name="admin_setting_razorpay" id="register-form"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <h6>{{ $paymentmethodRazorpay->payment_method }}</h6>
                                                    <input type="hidden" name="hdpaymentMethodid" id="hdpaymentMethodid"
                                                        value="{{ $paymentmethodRazorpay->id }}">
                                                    <small class="text-light fw-semibold d-block">Status</small>
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input" type="radio" name="rdrazorpay"
                                                            id="rdrazorpay" value="1"
                                                            @foreach ($decodedDatarazorpay as $item)
                                                            {{ $item->status == 1 ? 'checked' : '' }} @endforeach />
                                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="rdrazorpay"
                                                            id="rdrazorpay" value="0"
                                                            @foreach ($decodedDatarazorpay as $item)
                                                            {{ $item->status == 0 ? 'checked' : '' }} @endforeach />
                                                        <label class="form-check-label"
                                                            for="inlineRadio2">InActive</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label">RazorPay ID<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="txtrazorpayid" id="txtrazorpayid"
                                                                title="Enter RazorPay ID"
                                                                value="@foreach ($decodedDatarazorpay as $item){{ $item->razor_key }} @endforeach"
                                                                placeholder="RazorPay ID" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">RazorPay Key<span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="txtrazorpaykey" id="txtrazorpaykey"
                                                                value="@foreach ($decodedDatarazorpay as $item) {{ $item->razor_secret }} @endforeach"
                                                                placeholder="RazorPay Key" title="Enter RazorPay Key"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mt-3">
                                                                <button type="submit"
                                                                    class="btn btn-success me-1 submit">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endisset
                                        </div>
                                        <div class="col-md-4">
                                            @isset($paymentmethodCashondelivery)
                                                <form method="post"
                                                    action="{{ route('paymentGatewateCashonDeliveryCreate', [$paymentmethodCashondelivery->id]) }}"
                                                    name="" id="register-form" enctype="multipart/form-data">
                                                    @csrf
                                                    <h6>{{ $paymentmethodCashondelivery->payment_method }}</h6>
                                                    <input type="hidden" name="hdpaymentMethodid" id="hdpaymentMethodid"
                                                        value="{{ $paymentmethodCashondelivery->id }}">
                                                    <small class="text-light fw-semibold d-block">Status</small>
                                                    <div class="form-check form-check-inline mt-3">
                                                        <input class="form-check-input" type="radio"
                                                            name="rdcashondelivery" id="rdcashondelivery" value="1"
                                                            @foreach ($decodedDatacashondelivery as $item) 
                                                            {{ $item->status == 1 ? 'Checked' : '' }} @endforeach />
                                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="rdcashondelivery" id="rdcashondelivery"
                                                            value="0"@foreach ($decodedDatacashondelivery as $item) {{ $item->status == 0 ? 'Checked' : '' }} @endforeach />
                                                        <label class="form-check-label"
                                                            for="inlineRadio2">InActive</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 mt-3">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
        </div>
        {{-- </div> --}}
    </div>
    <!-- /Browser Default -->
</div>
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/settings/admin_settings.js') }}"></script>
@endsection
