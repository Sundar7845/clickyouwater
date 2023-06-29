@extends('layouts.main_master')
@section('content')
@section('title')
    Dashboard | Profile Update
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Profile Update
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card pl-30 col-md-12 d-flex justify-content-center">
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" name="profile" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hdProfileId" id="hdProfileId"
                            value="{{ $profiledetails->id ?? '' }}">
                        <input type="hidden" name="hdProfileImg" id="hdProfileImg"
                            value="{{ $profiledetails->user_img_path ?? '' }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtUserName">Name
                                    </label>
                                    <input type="text" name="txtUserName" id="txtUserName" class="form-control"
                                        id="txtUserName" value="{{ $profiledetails->display_name }}"
                                        placeholder="Enter Name" title="Enter UserName" />
                                    @if ($errors->has('txtUserName'))
                                        <div class="text-danger">{{ $errors->first('txtUserName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtMobile">Mobile Number
                                    </label>
                                    <input type="text" name="txtMobile" id="txtMobile"
                                        class="form-control mobilenumber" id="txtMobile"
                                        value="{{ $profiledetails->mobile }}" placeholder="Enter Mobile Number" required
                                        title="Enter Mobile Number" />
                                    @if ($errors->has('txtMobile'))
                                        <div class="text-danger">{{ $errors->first('txtMobile') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="txtPassword" id="txtPassword"
                                            placeholder="******" />
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('txtPassword'))
                                        <div class="text-danger">{{ $errors->first('txtPassword') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirm Password
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="txtConfirmPassword"
                                            id="txtConfirmPassword" placeholder="******" />
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('txtConfirmPassword'))
                                        <div class="text-danger">{{ $errors->first('txtConfirmPassword') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Profile Image
                                    </label>
                                    <input type="file" name="ProfileImage" id="ProfileImage" class="form-control" />
                                    <div class="img mt-2">
                                        @if ($profiledetails->user_img_path)
                                            <img src="{{ asset($profiledetails->user_img_path) }}" id="previewImage1"
                                                width="100" height="100">
                                        @else
                                            <img src="{{ asset('assets\img\avatars\14.png') }}" id="previewImage1"
                                                width="100" height="100">
                                        @endif
                                    </div>
                                    @if ($errors->has('ProfileImage'))
                                        <div class="text-danger">{{ $errors->first('ProfileImage') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="mt-4 mb-3 d-flex justify-content-start">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->


@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/admindashboard/profile.js') }}"></script>
@endsection
