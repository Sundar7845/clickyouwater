@extends('layouts.main_master') @section('content')
@section('title')
    Manufacturer - Hub Orders
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="mb-3">
                <h4 class="fw-bold py-1 mb-4">
                    {{ $manufacturer_name }} - Hub Orders ({{ $hub_name }})
                </h4>
            </div>
            <div class="mb-3">
                <a href="{{ route('manufacturerorders') }}"><button type="button"
                        class="btn btn-primary">Back</button></a>
            </div>
        </div>
    </div>
    <input type="hidden" name="hdHubId" id="hdHubId" value="{{ $hub_id }}">
    {{-- <div class="card">
        <div class="card-body">
            <form class="browser-default-validation">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <strong class="form-label" for="basic-default-name">State Name</strong>
                            <select name="ddlState" id="ddlState" class="select2 form-select ">
                                <option value="">Select State</option>
                                @foreach ($state as $item)
                                    <option value="{{ $item->id }}">{{ $item->state_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <strong class="form-label" for="basic-default-email">District Name</strong>
                            <select name="ddlCity" id="ddlCity" class="select2 form-select ">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <button type="button" class="btn btn-flat btn-primary" id="btnDate" style="height: 36px;">
                            <i class="fa fa-calendar"></i>
                            <span id="spnDate" style="padding-left: 5px;">Today</span>
                            <i class="fa fa-caret-down" style="padding-left: 5px;"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblManufactureAllOrders" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>ORDER NO</th>
                            <th>ORDER DATE</th>
                            <th>CUSTOMER NAME</th>
                            <th>HUB NAME</th>
                            <th>QTY</th>
                            <th>AMOUNT</th>
                            <th>PAYMENT</th>
                            <th>ORDER STATUS</th>
                            <th>ACTION</th>
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
<script src="{{ asset('assets/js/admin/orders/manufacture_orders/manufacturer_details.js') }}"></script>
@endsection
