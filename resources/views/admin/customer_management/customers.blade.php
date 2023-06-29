@extends('layouts.main_master') @section('content')
@section('title')
    @if ($type === 'all')
        All Customers
    @elseif ($type === 'today')
        Today's Customers
    @elseif ($type === 'thismonth')
        This Month's Customers
    @else
        Customers List
    @endif | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-1 mb-4">
        Customers
    </h4> --}}
    <h4 class="fw-bold py-1 mb-4">
        @if ($type === 'all')
            All Customers
        @elseif ($type === 'today')
            Today's Customers
        @elseif ($type === 'thismonth')
            This Month's Customers
        @else
            Customers
        @endif
    </h4>

    <div class="card mb-2">
        <div class="card-body">
            <form class="browser-default-validation">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Customer Type</label>
                            <select name="ddlcustomerType" id="ddlcustomerType" class="form-select">
                                @foreach ($customer_types as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == 1 ? 'selected' : '' }}>
                                        {{ $item->customer_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-name">Status</label>
                            <select name="ddlstatus" id="ddlstatus" class="form-select">
                                @php
                                    $value = 1;
                                @endphp
                                <option value="1" {{ $value == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0">InActive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">State Name</label>
                            <select name="ddlState" id="ddlState" class="select2 form-select ">
                                <option value="">Select</option>
                                @foreach ($states as $item)
                                    <option value="{{ $item->id }}">{{ $item->state_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">District Name</label>
                            <select name="ddlCity" id="ddlCity" class="select2 form-select ">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">Area Name</label>
                            <select name="ddlArea" id="ddlArea" class="select2 form-select ">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Hub Name</label>
                            <select name="ddlHub" id="ddlHub" class="select2 form-select ">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0 me-2">Customer List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblcustomer" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>CUSTOMER NAME</th>
                            <th>CUSTOMER TYPE</th>
                            <th>MOBILE</th>
                            <th>DATE OF REG</th>
                            <th>STATUS</th>
                            {{-- <th>DEPOSIT HISTORY</th> --}}
                            <th>SUMMARY</th>
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
<script src="{{ asset('assets/js/admin/customermanagement/customer.js') }}"></script>
@endsection
