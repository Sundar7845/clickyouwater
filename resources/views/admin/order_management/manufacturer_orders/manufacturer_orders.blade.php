@extends('layouts.main_master')
@section('content')
@section('title')
    Manufacturer Orders | Dashboard | Click Your Order
@endsection
@section('header')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}" />
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Manufacturer Orders
    </h4>
    <div class="card">
        <div class="card-body">
            <form class="browser-default-validation">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-name">State Name</label>
                            <select name="ddlState" id="ddlState" class="select2 form-select ">
                                <option value="">Select State</option>
                                @foreach ($states as $item)
                                    <option value="{{ $item->id }}">{{ $item->state_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">District Name</label>
                            <select name="ddlCity" id="ddlCity" class="select2 form-select ">
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Area Name</label>
                            <select name="" id="" class="select2 form-select ">
                                <option value="">SELECT Area</option>
                                <option value="1">saravanampatti</option>
                                <option value="2">hopes</option>
                                <option value="3">perur</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Manufacture Name</label>
                            <select name="ddlManufacture" id="ddlManufacture" class="select2 form-select ">
                                <option value="">Select Manufacture</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                            <label class="form-label" for="basic-default-email">Filter By Date</label>
                            <button type="button" class="btn btn-flat btn-primary" id="btnDate"
                                style="height: 36px;">
                                <i class="fa fa-calendar"></i>
                                <span id="spnDate" style="padding-left: 5px;">Today</span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                        </div> --}}
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-datatable table-responsive pt-0">
            <table id="tblManufactureOrders" class="table">
                <thead class="border-bottom">
                    <tr>
                        <th>S.No</th>
                        <th>MF.CODE</th>
                        <th>MANUFACTURER NAME</th>
                        <th>MOBILE</th>
                        <th>HUB NAME</th>
                        <th>DISTRICT</th>
                        <th>STATE</th>                        
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ DataTable with Buttons -->
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/orders/manufacture_orders/manufactureorders.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-rowgroup/datatables.rowgroup.js') }}"></script>
@endsection
