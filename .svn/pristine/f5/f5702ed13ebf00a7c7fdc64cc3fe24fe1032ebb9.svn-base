@extends('layouts.main_master')
@section('content')
@section('title')
    Logistics Stocks | Click Your Order
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Logistics Stocks
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
                        <label class="form-label" for="ddlLogistics">Select Logistics <span class="text-danger">*</span>
                        </label>
                        <select name="ddlLogistics" id="ddlLogistics" class="select2 form-select" title="Select Logistics"
                            required>
                            <option value="">Select Logistics</option>
                            @foreach ($logistics as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('ddlLogistics') == $item->id ? 'selected' : '' }}>
                                    {{ $item->logistic_partner_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('ddlLogistics'))
                            <div class="text-danger">{{ $errors->first('ddlLogistics') }}</div>
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
                <table id="tblLogisticsStockList" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Category Name</th>
                            <th>Product Name</th>
                            <th>Filled Qty</th>
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
<script src="{{ asset('assets/js/admin/reports/logistics_stock.js') }}"></script>
@endsection