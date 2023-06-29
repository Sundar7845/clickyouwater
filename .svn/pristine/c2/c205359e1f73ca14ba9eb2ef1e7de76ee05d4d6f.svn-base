@extends('layouts.main_master')
@section('content')
@section('title')
    Roles & Menu Permission | Click Your Order | Dashboard
@endsection
<link rel="stylesheet" href="{{ asset('assets/js/admin/roles/ui.dynatree.css') }}">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4" id="roleTitle">
        Roles & Menu Permission
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('create-permission') }}" name="rolePermission" id="register-form"
                        enctype="multipart/form-data" method="post">
                        @csrf
                        <input type="hidden" name="hdPermission_id" id="hdPermission_id" value="">
                        <input type="hidden" name="hdRole_id" id="hdRole_id" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ddlRole" class="form-label">Role Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlRole" id="ddlRole" class="select2 form-select" required>
                                        <option value="">Select Role Name</option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->role_id }}">
                                                {{ $item->role_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlRole'))
                                        <div class="text-danger">{{ $errors->first('ddlRole') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mt-4 mb-3">
                                    <button type="submit" id="btnSave" class="btn btn-success">Save</button>
                                    <button type="button" id="btnCancel" class="btn btn-danger"
                                        onclick="cancel();">Cancel</button>
                                </div>
                            </div>
                            <div class="col-md-6" id="divMenuList"></div>
                            <input type="hidden" name="permission_id" id="permission_id" value="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
    <div class="col-md-12 mb-4 mb-md-0">
        <h5>Role List</h5>
        <div class="row">
            <div class="col-lg-12 mb-4 mb-lg-0">
                <div class="card h-100">
                    <div class="card-datatable table-responsive pt-0">
                        <table id="tblRole" class="table">
                            <thead class="border-bottom">
                                <tr>
                                    <th>S.No</th>
                                    <th>Permission Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/roles/roles.js') }}"></script>
<script src="{{ asset('assets/js/admin/roles/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/admin/roles/jquery.dynatree.js') }}"></script>
@endsection
