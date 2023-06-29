@extends('layouts.main_master') @section('content')
@section('title')
    Customer Summary | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Customer Summary
    </h4>
    <div class="row">
        <!-- Sales last year -->
        <div class="col-xl-6 col-md-6 col-6 mb-4">
            <input type="hidden" name="hduserid" id="hduserid" value="{{ $userid }}">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title mb-0">Customer Details</h4>
                </div>
                <div class="card-body mt-3">
                    <address>
                        <b>{{ $customers_details->customer_name }}</b><br>
                        Email : {{ $customers_details->email }}<br>
                        Mobile : {{ $customers_details->mobile }}<br>
                        Customer Type : {{ $customers_details->customer_type }} <br>
                    </address>
                </div>
            </div>
        </div>
        <!-- Sales Last month -->
        <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title mb-0">Address</h4>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        @foreach ($customer_address as $item)
                            <div class="col-md-6">
                                <address>
                                    <b>{{ $item->contact_person_name }}</b><br>
                                    {{ $item->building_no }}, {{ $item->street }},<br>
                                    {{ $item->landmark }}, {{ $item->area }},<br>
                                    {{ $item->city_name }}, {{ $item->state_name }} - {{ $item->pincode }}<br>
                                    Mobile: {{ $item->contact_person_mobile }}<br>
                                </address>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <!-- Cards with few info -->
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2 text-white">{{ $cansInHand }}</h5>
                        <small>Cans In Hand</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-primary rounded-pill p-2">
                            <i class="ti ti-bottle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($damagedCans) }}</h5>
                        <small>Damaged Cans</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-warning rounded-pill p-2">
                            <i class="ti ti-bottle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($rechargePoints) }}</h5>
                        <small>Recharge Points</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-warning rounded-pill p-2">
                            <i class="ti ti-currency-rupee ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($earnedPoints) }}</h5>
                        <small>Earned Points</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-success rounded-pill p-2">
                            <i class="ti ti-currency-rupee ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($usedPoints) }}</h5>
                        <small>Used Points</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-secondary rounded-pill p-2">
                            <i class="ti ti-currency-rupee ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($balancepoints) }}</h5>
                        <small>Balance Points</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-info rounded-pill p-2">
                            <i class="ti ti-currency-rupee ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($total_deposit_amount) }}</h5>
                        <small>Total Deposits</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-secondary rounded-pill p-2">
                            <i class="ti ti-currency-rupee ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($total_refund_amount) }}</h5>
                        <small>Total Refunds</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-secondary rounded-pill p-2">
                            <i class="ti ti-currency-rupee ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($refundableDeposit) }}</h5>
                        <small>Balance Deposits</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-secondary rounded-pill p-2">
                            <i class="ti ti-currency-rupee ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ $ordersCount }}</h5>
                        <small>Total Orders</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-dark rounded-pill p-2">
                            <i class="ti ti-shopping-cart ti-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ $cancelOrder }}</h5>
                        <small>Cancel Orders</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-danger rounded-pill p-2">
                            <i class="ti ti-alert-triangle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="card-title mb-0">
                        <h5 class="mb-0 me-2">{{ number_format($orderValue) }}</h5>
                        <small>Order Value</small>
                    </div>
                    <div class="card-icon">
                        <span class="badge bg-label-primary rounded-pill p-2">
                            <i class="ti ti-currency-rupee"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mt-3 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0 me-2">Recent Orders</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblRecentOrders" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>DATE</th>
                            <th>ORDER No</th>
                            {{-- <th>CUSTOMER NAME</th> --}}
                            <th>HUB NAME</th>
                            <th>QTY</th>
                            <th>RETURN QTY</th>
                            <th>AMOUNT</th>
                            <th>PAYMENT</th>
                            <th>ORDER STATUS</th>
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
<script src="{{ asset('assets/js/admin/customermanagement/customer_summary.js') }}"></script>
@endsection
