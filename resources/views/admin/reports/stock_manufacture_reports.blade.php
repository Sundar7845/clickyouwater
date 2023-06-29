@extends('layouts.main_master')
@section('content')
@section('title')
    Manufacturer Stocks | Click Your Order
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Manufacturer Stocks
    </h4>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label" for="ddlCategory">Select Category <span class="text-danger">*</span>
                        </label>
                        <select name="ddlCategory" id="ddlCategory" class="select2 form-select" title="Select Category"
                            required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('ddlCategory') == $item->id ? 'selected' : '' }}>
                                    {{ $item->category_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('ddlCategory'))
                            <div class="text-danger">{{ $errors->first('ddlCategory') }}</div>
                        @endif
                        <span class="error"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label" for="ddlManufacturer">Select Manufacturer <span
                                class="text-danger">*</span>
                        </label>
                        <select name="ddlManufacturer" id="ddlManufacturer" class="select2 form-select"
                            title="Select Manufacturer" required>
                            <option value="">Select Manufacturer</option>
                            @foreach ($manufactures as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('ddlManufacturer') == $item->id ? 'selected' : '' }}>
                                    {{ $item->manufacturer_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('ddlManufacturer'))
                            <div class="text-danger">{{ $errors->first('ddlManufacturer') }}</div>
                        @endif
                        <span class="error"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTable -->
    <div class="col-lg-12 mt-2 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblManufacturerStockList" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Category Name</th>
                            <th>Product Name</th>
                            <th>Filled Qty</th>
                            <th>In Production</th>
                            <th>Empty Qty</th>
                            <th>Damaged Qty</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- End DataTable -->

</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/reports/manufacture_stock.js') }}"></script>
@endsection
