@extends('layouts.main_master')
@section('content')
@section('title')
    Hub Orders
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Hub Orders
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
                            <label class="form-label" for="basic-default-email">Hub Name</label>
                            <select name="ddlHub" id="ddlHub" class="select2 form-select ">
                                <option value="">Select Hub</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-4 mt-3">
                        <button type="button" class="btn btn-flat btn-primary" id="btnDate" style="height: 36px;">
                            <i class="fa fa-calendar"></i>
                            <span id="spnDate" style="padding-left: 5px;">Today</span>
                            <i class="fa fa-caret-down" style="padding-left: 5px;"></i>
                        </button>
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mt-3 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblHubOrders" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>HUB NAME</th>
                            <th>MOBILE</th>
                            <th>EMAIL</th>
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
    </div>
    <!--/ DataTable with Buttons -->
</div>
<!-- / Content -->
<!--  Modal -->
{{-- <div class="modal fade" id="modalClose" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <form action="" method="post">
                    @csrf
                    <input type="hidden" name="hdRoleName" value="">
                    <input type="hidden" name="hdRoleId" id="hdRoleId" value="">
                    <div class="col-12">
                        <label class="form-label w-100" for="modalAddCard">Role Name</label>
                        <div class="input-group input-group-merge">
                            <input type="text" name="txtRoleName" id="txtRoleName" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 text-center mt-2">
                        <a href="" id="aModalClose" class="btn btn-success me-sm-3 me-1">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}
<!-- / Modal -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/orders/huborders/huborders.js') }}"></script>
@endsection
