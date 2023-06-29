@extends('layouts.main_master')
@section('content')
@section('title')
     Department | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4" id="departmentTittle">
        Department
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('add.department') }}" method="POST" name="department"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hdDepartmentId" id="hdDepartmentId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtDepartmentName">Department Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('txtDepartmentName') }}"
                                        name="txtDepartmentName" id="txtDepartmentName"
                                        placeholder="Enter Department Name" class="form-control"
                                        title="Enter Department Name" required>
                                </div>
                                @if ($errors->has('txtDepartmentName'))
                                    <div class="text-danger" id="errors">{{ $errors->first('txtDepartmentName') }}
                                    </div>
                                @endif
                                <span class="error"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success" id="btnSave">Save</button>
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
                <h5 class="card-title m-0 me-2">Department List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblDepartmentList" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>DEPARTMENT NAME</th>
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
<script src="{{ asset('assets/js/admin/masters/department.js') }}"></script>
@endsection
