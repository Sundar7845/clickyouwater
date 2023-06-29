@extends('layouts.main_master')
@section('content')
@section('title')
    Stock Outward | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Stock Outward
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <form action="{{ route('add.stockoutward') }}" method="POST" name="stockoutwardForm">
                @csrf
                <input type="hidden" id="hdStockOutwardId" value="0">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="ddlManufacturerName">Manufacturer Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlManufacturerName" id="ddlManufacturerName"
                                        class="select2 form-select" title="Select Manufacturer Name" required>
                                        <option value="">Select Manufacturer</option>
                                        @foreach ($manufacturer as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->manufacturer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlManufacturerName'))
                                        <div class="text-danger">{{ $errors->first('ddlManufacturerName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="stockOutwardNo" class="form-label"
                                        for="basic-default-name">&nbsp;</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon11">Outward No</span>
                                        <input type="text" class="form-control" name="stockOutwardNo"
                                            id="stockOutwardNo" readonly placeholder="EMP001"
                                            value="{{ $stockOutwardNo }}" aria-label=""
                                            aria-describedby="basic-addon11" title="Stock OutWard NO" required />
                                        @if ($errors->has('stockOutwardNo'))
                                            <div class="text-danger">{{ $errors->first('stockOutwardNo') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="dtOutwardDate">&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="dtOutwardDate">Outward Date</span>
                                    <input type="date" class="form-control" id="dtOutwardTodayDate" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="ddlProducts">Product Name</label>
                                    <select name="ddlProducts" id="ddlProducts" class="select2 form-select"
                                        title="Select Product Name">
                                        <option value="">Select Product Name</option>
                                        @foreach ($products as $item)
                                            <option value="{{ $item->product_id }}">
                                                {{ $item->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlProducts'))
                                        <div class="text-danger">{{ $errors->first('ddlProducts') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="btnQuantity">Quantity</label>
                                <div class="input-group">
                                    <input type="number" min="0" oninput="validity.valid||(value='');"
                                        class="form-control" name="txtProductQty" id="txtProductQty"
                                        placeholder="Enter Product Qty" title="Please Enter Qty" />
                                    <span class="" id="basic-addon11"></span>
                                    <button type="button" class="btn btn-primary"
                                        onclick="addStockOutward();">Add</button>
                                </div>
                                @if ($errors->has('txtProductQty'))
                                    <div class="text-danger">{{ $errors->first('txtProductQty') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <h5>Stock Outward Details</h5>
                                <!-- DataTable with Buttons -->
                                <div class="card-datatable table-responsive pt-0">
                                    <table class="table table-responsive">
                                        <thead>
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody id="tbodyStockOutward"></tbody>
                                    </table>
                                </div>
                                <!--/ DataTable with Buttons -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-danger" onclick="doCancel();">Cancel</button>
                                </div>
                                <div class="mt-4 mb-3">
                                    <a href="{{ route('stockoutwardlist') }}"><button type="button"
                                            class="btn btn-primary">Go to List</button></a>
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
<script src="{{ asset('assets/js/admin/stockmanagement/stockoutward.js') }}"></script>
@endsection
