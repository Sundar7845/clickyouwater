@extends('layouts.main_master')
@section('content')
@section('title')
    Roles | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Roles
    </h4>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header">
                <h4 class="card-title">Role List</h4>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblRole" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Role NAME</th>
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
<!-- Modal -->
@foreach ($roles as $role)
    <div class="modal fade" id="addNewCCModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-simple">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <form action="{{ route('updaterole') }}" method="post">
                        @csrf
                        <input type="hidden" name="hdRoleName" value="{{ $role->role_name }}">
                        <input type="hidden" name="hdRoleId" id="hdRoleId" value="">
                        <div class="col-12">
                            <label class="form-label w-100" for="modalAddCard">Role Name</label>
                            <div class="input-group input-group-merge">
                                <input type="text" name="txtRoleName" id="txtRoleName" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 text-center mt-2">
                            <button type="submit" class="btn btn-success me-sm-3 me-1">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!--/Modal -->
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/masters/role.js') }}"></script>
@endsection
