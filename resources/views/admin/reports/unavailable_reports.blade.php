@extends('layouts.main_master') @section('content')
@section('title')
    Service Unavailable Report | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Service Unavailable Report
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form class="browser-default-validation">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <strong class="form-label" for="basic-default-name">State Name
                                    </strong>
                                    <select name="ddlState" id="ddlState" class="select2 form-select">
                                        <option value="">Select State</option>
                                        @foreach ($states as $item)
                                            <option value="{{ $item->id }}">{{ $item->state_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <strong class="form-label" for="basic-default-name">District Name
                                    </strong>
                                    <select name="ddlCity" id="ddlCity" class="select2 form-select">

                                    </select>
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
                <h5 class="card-title m-0 me-2">Service Unavailable List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblServiceUnavailableReport" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Customer Name</th>
                            <th>State Name</th>
                            <th>District Name</th>
                            <th>Address</th>
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
<script src="{{ asset('assets/js/admin/reports/serviceunavailablereport.js') }}"></script>
@endsection
