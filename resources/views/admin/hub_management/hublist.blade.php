@extends('layouts.main_master') @section('content')
@section('title')
    @if ($type === 'all')
        All Hubs
    @elseif ($type === 'today')
        Today's Hubs
    @elseif ($type === 'thismonth')
        This Month's Hubs
    @else
        Hub List
    @endif | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        @if ($type === 'all')
            All Hubs
        @elseif ($type === 'today')
            Today's Hubs
        @elseif ($type === 'thismonth')
            This Month's Hubs
        @else
            Hub List
        @endif
    </h4>
    <!-- Filters -->
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label" for="">State Name</label>
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
                        <label class="form-label" for="">District Name</label>
                        <select name="ddlCity" id="ddlCity" class="select2 form-select ">
                            <option value="">Select District</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label" for="">Area Name</label>
                        <select name="ddlArea" id="ddlArea" class="select2 form-select ">
                            <option value="">Select Area</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTable with Buttons -->

    <div class="col-lg-12 mb-4 mb-lg-0 mt-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblHub" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Hub Code</th>
                            <th>Hub Name</th>
                            <th>Manufacturer Name</th>
                            <th>Proprietor Name</th>
                            <th>No of Delivery Persons</th>
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
    </div>
    <!--/ DataTable with Buttons -->
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/hubmanagement/hub_list.js') }}"></script>
@endsection
