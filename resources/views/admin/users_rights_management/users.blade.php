@extends('layouts.main_master') @section('content')
@section('title')
    Users | Click Your Order | Dashboard
@endsection
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
@endif
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4" id="rolePermissionTitle">
        Users
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <form action="{{ route('create-user') }}" id="permissionList" method="post" name="permissionList" style="display: flex;">
            <div class="col-md-12 mb-4 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <input type="hidden" name="hdUserId" id="hdUserId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlRoleName" class="form-label">Role Name<span
                                            class="text-danger">*</span></label>
                                    <select name="ddlRoleName" id="ddlRoleName" class="select2 form-select" required>
                                        <option value="">Select Role Name</option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->role_id }}">
                                                {{ $item->role_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlRoleName'))
                                        <div class="text-danger">{{ $errors->first('ddlRoleName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="txtUserName">Login Mobile<span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="txtUserName" id="txtUserName"
                                        placeholder="Login Mobile" required />
                                        @if ($errors->has('txtUserName'))
                                        <div class="text-danger">{{ $errors->first('txtUserName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="txtDisplayName">Display Name <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="txtDisplayName" id="txtDisplayName"
                                        placeholder="Display Name" required />
                                        @if ($errors->has('txtDisplayName'))
                                        <div class="text-danger">{{ $errors->first('txtDisplayName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="txtUserEmail">Email <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" name="txtUserEmail" id="txtUserEmail"
                                        placeholder="Email" required />
                                        @if ($errors->has('txtUserEmail'))
                                        <div class="text-danger">{{ $errors->first('txtUserEmail') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                {{-- <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="******" required />
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}
                                {{-- <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirm Password <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="password_confirmation" placeholder="******" required />
                                        <span class="input-group-text cursor-pointer">
                                            <i class="ti ti-eye-off"></i>
                                        </span>
                                    </div>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}
                                <div class="mt-4 mb-3">
                                    <button type="submit" id="btnSave" class="btn btn-success">Update</button>
                                    <button type="button" id="btnCancel" class="btn btn-danger"
                                        onclick="Cancel();">Cancel</button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <h6>List of Menu Permissions <span class="text-danger">*</span>
                                        <span class="d-flex justify-content-end">
                                            <label class="switch switch-primary">
                                                <input type="checkbox" id="chkall" class="switch-input" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="ti ti-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="ti ti-x"></i>
                                                    </span>
                                                </span>
                                                <span class="switch-label">Select All</span>
                                            </label>
                                        </span>
                                    </h6>
                                    <div class="card-datatable table-responsive pt-0 scrollUser">
                                        <table class="table">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Menu</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                    <th>Print</th>
                                                    <th>View</th>
                                                    <th>Approval</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyMenuList">
                                                <tr>
                                                    <td colspan="7" class="text-center">Please Choose Role Name
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- /Browser Default -->
    </div>
    <div class="col-md-12 mb-4 mb-md-0">
        <h5>Users List</h5>
        <div class="row">
            <div class="col-lg-12 mb-4 mb-lg-0">
                <div class="card h-100">
                    <div class="card-datatable table-responsive pt-0">
                        <table id="tblUsers" class="table">
                            <thead class="border-bottom">
                                <tr>
                                    <th>S.No</th>
                                    <th>LOGIN MOBILE</th>
                                    <th>ROLE NAME</th>
                                    <th>DISPLAY NAME</th>
                                    <th>EMAIL</th>
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
        </div>
    </div>
</div>
<!-- / Content -->

@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/roles/assignrole.js') }}"></script>
@endsection