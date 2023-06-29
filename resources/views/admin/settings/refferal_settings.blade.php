@extends('layouts.main_master') @section('content')
@section('title')
    Referral Settings | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Referral Settings
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form name="referral_settings" action="{{ route('add.referralsettings') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hdfileReferralbanner" id="hdfileReferralbanner" value="@if(isset($refferalsettings)){{ $refferalsettings->referral_banner_path }}@endif">
                        <div class="row">
                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Points For Each Coin<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="hidden" name="id" id="id"
                                            value="@if (isset($refferalsettings)) {{ $refferalsettings->id ? $refferalsettings->id : '' }}@else{{ 'new' }} @endif">
                                    <input type="number" min="0" step=".01" oninput="validity.valid||(value='');"  class="form-control" id="txtReferralContent" name="txtReferralContent"
                                        placeholder="Enter Points" value="@if(isset($refferalsettings)){{ $refferalsettings->referral_content }}@endif" title="Enter Points for each coin" required />
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Referral Content<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="hidden" name="id" id="id"
                                            value="@if (isset($refferalsettings)) {{ $refferalsettings->id ? $refferalsettings->id : '' }}@else{{ 'new' }} @endif">
                                            <textarea rows="4" cols="50" class="form-control" id="txtReferralContent" name="txtReferralContent"
                                            placeholder="Enter Points" title="Enter Referral Content" required>@if(isset($refferalsettings)){{ $refferalsettings->referral_content }}@endif</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Points For Each Referral<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="number" min="0" step=".01" class="form-control" id="txtPointsforEachreferral" name="txtPointsforEachreferral"
                                        placeholder="Enter Referral Points" value="@if(isset($refferalsettings)){{ $refferalsettings->earnpoints_per_referral }}@endif" title="Enter Points for each referral" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Points For Each Referrer<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="number" min="0" step=".01" class="form-control" id="txtPointsforEachreferrer" name="txtPointsforEachreferrer"
                                        placeholder="Enter Referrer Points" value="@if(isset($refferalsettings)){{ $refferalsettings->earnpoints_per_referrer }}@endif" title="Enter Points for each referrer" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Referral Banner<span
                                        class="text-danger">*</span>
                                    </label>
                                        <input type="file" name="fileReferral_banner"
                                            id="fileReferral_banner" class="form-control"
                                            title="Select Referral Banner Image">
                                    <div class="img mt-2">
                                        <img src="@if(isset($refferalsettings)){{ $refferalsettings->referral_banner_path }}@endif"
                                            id="previewImage1" width="100" height="100">
                                        @if ($errors->has('fileReferral_banner'))
                                            <div class="text-danger">
                                                {{ $errors->first('fileReferral_banner') }}
                                            </div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="button" onclick="cancel();" class="btn btn-danger">Cancel</button>
                                </div>
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
    <script src="{{ asset('assets/js/admin/settings/refferal_settings.js') }}"></script>
@endsection