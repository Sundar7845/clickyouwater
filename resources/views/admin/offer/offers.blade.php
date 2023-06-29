@extends('layouts.main_master')
@section('content')
@section('title')
    @if ($type === 'all')
        All Offers
    @elseif ($type === 'today')
        Today's Offers
    @elseif ($type === 'thismonth')
        This Month's Offers
    @else
        Offers
    @endif | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        @if ($type === 'all')
            All Offers
        @elseif ($type === 'today')
            Today's Offers
        @elseif ($type === 'thismonth')
            This Month's Offers
        @else
            Offers
        @endif
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0" id="hdDivOffer">
            <form name="offers" action="{{ route('add.offers') }}" onsubmit="return validate();" method="POST"
                id="offers" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body" id="card1">
                        <input type="hidden" name="hdOfferId" id="hdOfferId" value="{{ $offer ? $offer->id : '' }}">
                        <input type="hidden" name="hdOfferImg" id="hdOfferImg"
                            value="{{ $offer->offer_image_path ?? '' }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlOfferType" class="form-label">Offer Type<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlOfferType" id="ddlOfferType" class="select2 form-select " required>
                                        <option value="">Select Offer Type</option>
                                        @foreach ($offerTypes as $offerType)
                                            <option value="{{ $offerType->id }}"
                                                @isset($offer)@if ($offer->offer_type_id == $offerType->id) {{ 'selected' }}@endif @endisset
                                                {{ old('ddlOfferType') ? 'selected' : '' }}>
                                                {{ $offerType->offer_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlOfferType'))
                                        <div class="text-danger">{{ $errors->first('ddlOfferType') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4" id="StateList" style="display: none;">
                                <div class="mb-3">
                                    <label for="ddlState" class="form-label">State Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlState[]" id="ddlState" class="select2 form-select" multiple
                                        required>
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}"
                                                @if (is_array($getStateName) && in_array($state->id, $getStateName)) selected @endif
                                                @if (!is_array($getStateName) && $state->id == $getStateName) selected @endif>
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
                                    <label for="txtOfferName" class="form-label">Offer Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="txtOfferName" name="txtOfferName"
                                        value="{{ old('txtOfferName') }}@isset($offer){{ $offer ? $offer->offer_name : '' }}@endisset"
                                        class="form-control" placeholder="Enter Offer Name" required />
                                    @if ($errors->has('txtOfferName'))
                                        <div class="text-danger">{{ $errors->first('txtOfferName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtStartDate" class="form-label">Start Date<span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" id="txtStartDate" name="txtStartDate"
                                        class="form-control"
                                        value="@isset($offer){{ $offer ? $offer->start_date : '' }}@endisset{{ old('txtStartDate') }}"
                                        placeholder="Enter Start Date" required min="<?php echo date('Y-m-d\TH:i'); ?>" required />
                                    @if ($errors->has('txtStartDate'))
                                        <div class="text-danger">{{ $errors->first('txtStartDate') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtEndDate" class="form-label">End Date<span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" id="txtEndDate" name="txtEndDate" class="form-control"
                                        placeholder="Enter End Date"
                                        value="@isset($offer){{ $offer ? $offer->end_date : '' }}@endisset{{ old('txtEndDate') }}"
                                        required min="<?php echo date('Y-m-d\TH:i'); ?>" required />
                                    @if ($errors->has('txtEndDate'))
                                        <div class="text-danger">{{ $errors->first('txtEndDate') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtOffertotalPoints" class="form-label">Total Points<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtOffertotalPoints" name="txtOffertotalPoints"
                                                class="form-control"
                                                value="@isset($offer){{ $offer ? $offer->offer_total_points : '' }}@endisset{{ old('txtOffertotalPoints') }}"
                                                placeholder="Enter Total Points" required />
                                            @if ($errors->has('txtOffertotalPoints'))
                                                <div class="text-danger">{{ $errors->first('txtOffertotalPoints') }}
                                                </div>
                                            @endif
                                            <span class="error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="txtOfferclaimPoints" class="form-label">Claim Points Per
                                                Order<span class="text-danger">*</span></label>
                                            <input type="text" id="txtOfferclaimPoints" name="txtOfferclaimPoints"
                                                class="form-control"
                                                value="@isset($offer){{ $offer ? $offer->offer_claim_points : '' }}@endisset{{ old('txtOfferclaimPoints') }}"
                                                placeholder="Enter Claim Points" required />
                                            @if ($errors->has('txtOfferclaimPoints'))
                                                <div class="text-danger">{{ $errors->first('txtOfferclaimPoints') }}
                                                </div>
                                            @endif
                                            <span class="error"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="OfferImage">Offer Image<span
                                            class="text-danger">*</span></label>
                                    <div class="upload__box">
                                        <div class="upload__btn-box">
                                            <input type="file" name="OfferImage" id="OfferImage"
                                                data-max_length="20" class="form-control" required>
                                            @if ($errors->has('OfferImage'))
                                                <div class="text-danger">{{ $errors->first('OfferImage') }}
                                                </div>
                                            @endif
                                            <span class="error"></span>
                                            <div class="img mt-2">
                                                @if ($offer)
                                                    <img src="{{ asset($offer->offer_image_path) }}"
                                                        id="previewImage1" width="100" height="100">
                                                @else
                                                    <img src="" id="previewImage1" width="100"
                                                        height="100">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="upload__img-wrap"></div>
                                        <div class="profilePic"><img src="" alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body" id="card2">
                        <div class="card-header p-0">
                            <h4>Offer Codes</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtOfferCode" class="form-label" for="">Offer Code<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtOfferCode" id="txtOfferCode" class="form-control"
                                        placeholder="Enter Offer Code" value="{{ old('txtOfferCode') }}" required>
                                    @if ($errors->has('txtOfferCode'))
                                        <div class="text-danger">{{ $errors->first('txtOfferCode') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtCodeType" class="form-label" for="">Offer Code Type<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtCodeType" id="txtCodeType" class="form-control"
                                        placeholder="Enter Offer Code Type" value="{{ old('txtCodeType') }}"
                                        required>
                                    @if ($errors->has('txtCodeType'))
                                        <div class="text-danger">{{ $errors->first('txtCodeType') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <img src="{{ asset('upload/common/add.png') }}" class="img-fluid"
                                        onclick="return addOfferCodes();" id="btnAdd" width="50px"
                                        height="50px" style="margin-top:18px; cursor:pointer;">
                                    <img src="{{ asset('upload/common/addgreen.png') }}" class="img-fluid"
                                        onclick="return addOfferCodes();" id="btnUpdate" width="40"
                                        style="margin-top:21px; cursor:pointer; display: none">
                                    <input type="hidden" id="hdEditOffercodesRowId" value="0">
                                </div>
                            </div>
                            <div class="card-datatable table-responsive pt-0">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>Offer Code</th>
                                        <th>Offer Code Type</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody id="tbodyOfferCodes">
                                        @if ($offercodes != null)
                                            @foreach ($offercodes as $key => $offercode)
                                                <tr id="troffercodes{{ $key + 1 }}"
                                                    OFC="{{ $offercode->offer_code }}"
                                                    OCT="{{ $offercode->offer_code_type }}">
                                                    <td><input type='hidden' class='offercode'
                                                            id="taboffercode_{{ $key + 1 }}"
                                                            name='tabOfferCodes[]'
                                                            value="{{ $offercode->offer_code }}"><span
                                                            id='spnOfferCodes'>{{ $offercode->offer_code }}</span>
                                                    </td>
                                                    <td><input type='hidden' class='offercode'
                                                            id="tabcodetype_{{ $key + 1 }}"
                                                            name='tabOfferCodeTypes[]'
                                                            value="{{ $offercode->offer_code_type }}"><span
                                                            id='spnOfferCodeType'>{{ $offercode->offer_code_type }}</span>
                                                    </td>
                                                    <td>
                                                        <a><i class='text-primary ti ti-pencil me-1'
                                                                onclick="return doEditOfferCodes({{ $key + 1 }});"></i></a>
                                                        <a><i class='text-danger ti ti-trash me-1'
                                                                onclick="return removeRow({{ $key + 1 }});"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-4 mb-3">
                                <button type="submit" id="btnsave" class="btn btn-success">Save</button>
                                <a href="{{ route('offers') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /Browser Default -->
            </form>
        </div>

        @if ($offer == null)
            <!-- DataTable with Buttons -->
            <div class="col-lg-12 mb-4 mb-lg-0 mt-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title m-0 me-2">Offers List</h5>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table id="tbloffers" class="table">
                            <thead class="border-bottom">
                                <tr>
                                    <th>S.No</th>
                                    <th>Offer Image</th>
                                    <th>Offer Type</th>
                                    <th>Offer Name</th>
                                    <th>Validity
                                        <div class="text-muted p-1">
                                            <small class="bg-light p-1">(DAYS)</small>
                                        </div>
                                    </th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ DataTable with Buttons -->
        @endif
    </div>
    <!-- / Content -->
@endsection
@section('footer')
    <script src="{{ asset('assets/js/admin/offers/offers.js') }}"></script>
@endsection
