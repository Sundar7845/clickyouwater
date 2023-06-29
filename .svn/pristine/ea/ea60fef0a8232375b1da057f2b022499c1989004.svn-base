@extends('layouts.main_master')
@section('content')
@section('title')
    State | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        State
    </h4>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="card-title m-0 me-2">State List</h5>
                </div>
                <div><a href="{{ route('syncState') }}" class="btn btn-success">Sync State</a></div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblState" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>STATE CODE</th>
                            <th>STATE NAME</th>
                            <th>STATUS</th>
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
<script src="{{ asset('assets/js/admin/masters/state.js') }}"></script>
@endsection
