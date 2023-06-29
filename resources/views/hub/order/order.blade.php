@extends('layouts.main_master')
@section('content')
@section('title')
    Dashboard | Orders
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Orders List
    </h4>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0 mt-3">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblOrder" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>ORDER NO</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>Order Value</th>
                            <th>Assign To</th>
                            <th>Status</th>
                            <th>View</th>
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
<script src="{{ asset('assets/js/hub/order/order.js') }}"></script>
@endsection
