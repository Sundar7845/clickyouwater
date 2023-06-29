@extends('layouts.main_master')
@section('content')
@section('title')
    Vehicle Brands | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4" id="vehicleBrandsTitle">
        Vehicle Brands
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('add.vehiclebrands') }}" method="POST" name="vehiclebrands">
                        @csrf
                        <input type="hidden" name="hdVehicleBrandId" id="hdVehicleBrandId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Fuel Type<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlFuelType" id="ddlFuelType" class="select2 form-select"
                                        title="Select Fuel Type" required>
                                        <option value="">Select Fuel Type</option>
                                        @foreach ($fuelTypes as $item)
                                            <option value="{{ $item->id }}"  {{ old('ddlFuelType') == $item->id ? 'selected' : '' }} >{{ $item->fuel_type }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlFuelType'))
                                        <div class="text-danger">{{ $errors->first('ddlFuelType') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Brand Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtBrandName" id="txtBrandName" value="{{ old('txtBrandName') }}"
                                        placeholder="Enter Brand Name" title="Enter Brand Name" class="form-control"
                                        required>

                                    @if ($errors->has('txtBrandName'))
                                        <div class="text-danger">{{ $errors->first('txtBrandName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4 mb-3">
                                    <button type="submit" id="btnSave" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-danger" id="btnCancel"
                                        onclick="cancel();">Cancel</button>
                                </div>
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
                <h5 class="card-title m-0 me-2">Vehicle Brands List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblVehicleBrands" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Fuel Type Name</th>
                            <th>Brand Name</th>
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
<script src="{{ asset('assets/js/admin/masters/vehicle_brands.js') }}"></script>
@endsection
