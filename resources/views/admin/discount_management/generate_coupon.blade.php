@extends('layouts.main_master') @section('content')
@section('title')
    Generate Coupon | Clikc YOur Water | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Generate Coupon
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form name="generate_coupon" action="{{ route('add.generatecoupon') }}" method="POST">
                        @csrf
                        <input type="hidden" name="hdgeneratecouponId" id="hdgeneratecouponId" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-name">Coupon Type <span
                                                class="text-danger">*</span>
                                        </label>
                                        <select name="ddlCouponType" id="ddlCouponType" class="select2 form-select"
                                            required>
                                            <option value="">Select Coupon Type</option>
                                            @if (!empty($coupontypes))
                                                @foreach ($coupontypes as $coupontype)
                                                    <option value="{{ $coupontype->id }}">
                                                        {{ $coupontype->coupon_type }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('ddlCouponType'))
                                            <div class="text-danger">{{ $errors->first('ddlCouponType') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-name">Coupon Name<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="txtCouponName"
                                            id="txtCouponName" placeholder="Coupon Name" required />
                                        @if ($errors->has('txtCouponName'))
                                            <div class="text-danger">{{ $errors->first('txtCouponName') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-email">Coupon Code <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="txtCouponCode" name="txtCouponCode"
                                            class="form-control" placeholder="Enter Coupon Code" required />
                                        @if ($errors->has('txtCouponCode'))
                                            <div class="text-danger">{{ $errors->first('txtCouponCode') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-email">Start Date<span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" name="ddlStartDate" id="ddlStartDate"
                                            class="form-control" required min="<?php echo date('Y-m-d\TH:i'); ?>">
                                        @if ($errors->has('ddlStartDate'))
                                            <div class="text-danger">{{ $errors->first('ddlStartDate') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-email">End Date<span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" name="ddlEndDate" id="ddlEndDate"
                                            class="form-control" required min="<?php echo date('Y-m-d\TH:i'); ?>">
                                        @if ($errors->has('ddlEndDate'))
                                            <div class="text-danger">{{ $errors->first('ddlEndDate') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-name">Discount Type<span
                                                class="text-danger">*</span>
                                        </label>
                                        <select name="ddlDiscountType" id="ddlDiscountType" class="select2 form-select"
                                            required>
                                            <option value="">Select Discount Type</option>
                                            @if (!empty($discountTypes))
                                                @foreach ($discountTypes as $discountType)
                                                    <option value="{{ $discountType->id }}">
                                                        {{ $discountType->discount_type }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('ddlDiscountType'))
                                            <div class="text-danger">{{ $errors->first('ddlDiscountType') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-name">Discount Value <small
                                                class="text-muted">( ₹ or % )</small> <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="txtdiscount_value" id="txtdiscount_value"
                                            class="form-control" placeholder="Enter Discount Value" required>
                                        @if ($errors->has('txtdiscount_value'))
                                            <div class="text-danger">{{ $errors->first('txtdiscount_value') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-name">Max Discount<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="txtMaxDiscount" id="txtMaxDiscount"
                                            class="form-control" placeholder="Enter Max Discount" required>
                                        @if ($errors->has('txtMaxDiscount'))
                                            <div class="text-danger">{{ $errors->first('txtMaxDiscount') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-name">Min Order Qty<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="txtMinOrderQty" id="txtMinOrderQty"
                                            class="form-control" placeholder="Enter Min Order Qty" required>
                                        @if ($errors->has('txtMinOrderQty'))
                                            <div class="text-danger">{{ $errors->first('txtMinOrderQty') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-email">Same User Limit<span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="txtSameuserlimit" name="txtSameuserlimit"
                                            class="form-control" placeholder="Enter Same User Limit" required />
                                        @if ($errors->has('txtSameuserlimit'))
                                            <div class="text-danger">{{ $errors->first('txtSameuserlimit') }}</div>
                                        @endif
                                        <span class="error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button type="submit" id="btnSave" class="btn btn-success">Save</button>
                                <button type="button" onclick="cancel();" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0 me-2">Coupon List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblgeneratecoupon" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Coupon Type</th>
                            <th>Coupon Name</th>
                            <th>Coupon code</th>
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
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/discountmanagement/generatecoupon.js') }}"></script>
@endsection
