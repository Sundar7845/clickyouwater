@extends('layouts.main_master')
@section('content')
@section('title')
    Employee List | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Employee List
    </h4>
    <!-- DataTable with Buttons -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblEmployee" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>EMP CODE</th>
                            <th>NAME</th>
                            <th>MOBILE</th>
                            <th>EMAIL</th>
                            {{-- <th>DEPARTMENT</th> --}}
                            <th>DESIGNATION</th>
                            <th>DOCUMENT</th>
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
<script src="{{ asset('assets/js/admin/masters/employee.js') }}"></script>
@endsection
