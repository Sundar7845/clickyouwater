@extends('layouts.main_master')
@section('content')
@section('title')
    Designation | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4" id="designationTittle">
        Designation
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('add.designation') }}" method="POST" name="designation">
                        @csrf
                        <input type="hidden" name="hdDesignationId" id="hdDesignationId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Designation Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtDesignationName" id="txtDesignationName"
                                        placeholder="Enter Designation Name" title="Enter Designation Name"
                                        class="form-control" value="{{ old('txtDesignationName') }}" required>
                                </div>
                                @if ($errors->has('txtDesignationName'))
                                    <div class="text-danger">{{ $errors->first('txtDesignationName') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4 mb-3">
                                    <button type="submit" id="btnSave" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-danger" id="btnCancel"
                                        onclick="cancel();">Cancel</button>
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
                <h5 class="card-title m-0 me-2">Designation List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblDesignation" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>DESIGNATION NAME</th>
                            <th>STATUS</th>
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
<script src="{{ asset('assets/js/admin/masters/designation.js') }}"></script>
@endsection
