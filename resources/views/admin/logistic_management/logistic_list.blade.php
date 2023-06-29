@extends('layouts.main_master')
@section('content')
@section('title')
    @if ($type === 'all')
        All Logistic
    @elseif ($type === 'today')
        Today's Logistic
    @elseif ($type === 'thismonth')
        This Month's Logistic
    @else
        Logistic List
    @endif | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        @if ($type === 'all')
            All Logistic
        @elseif ($type === 'today')
            Today's Logistic
        @elseif ($type === 'thismonth')
            This Month's Logistic
        @else
            Logistic List
        @endif
    </h4>
    <!-- Filters -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">State Name</label>
                        <select name="ddlState" id="ddlState" class="select2 form-select ">
                            <option value="">Select State</option>
                            @if (!empty($states))
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->state_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">District Name</label>
                        <select name="ddlCity" id="ddlCity" class="select2 form-select ">
                            <option value="">Select District</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Area Name</label>
                        <select name="ddlArea" id="ddlArea" class="select2 form-select ">
                            <option value="">Select Area</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0 mt-3">
            <div class="card">
                <div class="card-body">
                    <form class="browser-default-validation">
                        <div class="row">
                            <!-- DataTable with Buttons -->
                            <div class="col-lg-12 mb-4 mb-lg-0">
                                <div class="card-datatable table-responsive pt-0">
                                    <table id="tbllogistic" class="table">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Logistic Code</th>
                                                <th>Logistic Name</th>
                                                <th>Manufacturer Name</th>
                                                <th>Propreitor Name</th>
                                                <th>No of Vehicle</th>
                                                <th>No of Drivers</th>
                                                <th>Document</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/ DataTable with Buttons -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/logisticmanagement/logistic_list.js') }}"></script>
@endsection
