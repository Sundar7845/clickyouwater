@extends('layouts.main_master')
@section('content')
@section('title')
    Delivery Person List | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Delivery Person List
    </h4>
    <input type="hidden" name="hdAuthUserRoleId" id="hdAuthUserRoleId" value="{{ Auth::user()->role_id }}">
    @if (Auth::user()->id == 1)
        <!-- s -->
        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-name">State Name</label>
                            <select name="ddlState" id="ddlState" class="select2 form-select ">
                                <option value="0">Select State</option>
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
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-name">District Name</label>
                            <select name="ddlCity" id="ddlCity" class="select2 form-select ">
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-name">Area Name</label>
                            <select name="ddlArea" id="ddlArea" class="select2 form-select ">
                                <option value="">Select Area</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-name">Hub Name</label>
                            <select name="ddlhub" id="ddlhub" class="select2 form-select ">
                                <option value="">Select Hub</option>
                                @if (!empty($hubs))
                                    @foreach ($hubs as $hub)
                                        <option value="{{ $hub->id }}">
                                            {{ $hub->hub_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0 mt-3">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblDeliveryPerson" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Delivery Person Code</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Hub Name</th>
                            <th>Rating</th>
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
<script src="{{ asset('assets/js/admin/deliverypersonmanagement/deliveryperson_list.js') }}"></script>
@endsection
