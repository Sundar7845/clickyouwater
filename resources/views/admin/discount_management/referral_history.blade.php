@extends('layouts.main_master')
@section('content')
@section('title')
    @if ($type === 'all')
        Referral History
    @elseif ($type === 'today')
        Today's Referral History
    @elseif ($type === 'thismonth')
        This Month's Referral History
    @else
        Referral History
    @endif | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        @if ($type === 'all')
            All Referral History
        @elseif ($type === 'today')
            Today's Referral History
        @elseif ($type === 'thismonth')
            This Month's Referral History
        @else
            Referral History
        @endif
    </h4>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblrefferalhistory" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Customer Name</th>
                            <th>Refferal Code</th>
                            <th>No Of Refferals</th>
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
<script src="{{ asset('assets/js/admin/discountmanagement/refferalhistory.js') }}"></script>
@endsection
