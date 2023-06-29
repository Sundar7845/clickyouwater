@extends('layouts.main_master')
@section('content')
@section('title')
    Admin Order List | Click Your Order | Dashboard
@endsection
@section('header')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}" />
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Admin Order List
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label" for="ddlHubName">Hub Name<span
                                        class="text-danger">*</span></label>
                                <select name="ddlHubName" id="ddlHubName" class="select2 form-select"
                                    title="Select Hub Name" required>
                                    <option value="">Select Hub</option>
                                    @foreach ($hubs as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->hub_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('ddlHubName'))
                                    <div class="text-danger">{{ $errors->first('ddlHubName') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="card-datatable table-responsive pt-0">
                                <table id="tblAdminOrdersList" class="table display"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Order No</th>
                                            <th>Hub Name</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/adminorders/admin_orders_list.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-rowgroup/datatables.rowgroup.js') }}"></script>
@endsection
