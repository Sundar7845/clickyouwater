@extends('layouts.main_master')
@section('content')
@section('title')
    @if (Auth::user()->role_id != \app\Enums\RoleTypes::Manufacturer &&
            Auth::user()->role_id != \app\Enums\RoleTypes::Hub &&
            Auth::user()->role_id != \app\Enums\RoleTypes::LogisticPartner)
        Dashboard | Click Your Order
    @elseif(Auth::user()->role_id == \app\Enums\RoleTypes::Manufacturer)
        Manufacturer Dashboard | Click Your Order
    @elseif(Auth::user()->role_id == \app\Enums\RoleTypes::Hub)
        Hub Dashboard | Click Your Order
    @elseif(Auth::user()->role_id == \app\Enums\RoleTypes::LogisticPartner)
        Logistic Dashboard | Click Your Order
    @elseif(Auth::user()->role_id != \app\Enums\RoleTypes::SuperAdmin &&
            Auth::user()->role_id != \app\Enums\RoleTypes::Manufacturer &&
            Auth::user()->role_id != \app\Enums\RoleTypes::Hub &&
            Auth::user()->role_id != \app\Enums\RoleTypes::LogisticPartner)
        Dashboard | Click Your Order
    @endif
@endsection

{{-- Admin Dashboard Content --}}
@if (Auth::user()->role_id != \app\Enums\RoleTypes::Manufacturer &&
        Auth::user()->role_id != \app\Enums\RoleTypes::Hub &&
        Auth::user()->role_id != \app\Enums\RoleTypes::LogisticPartner)
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Statistics -->
            <div class="col-xl-6 mb-4 col-lg-6 col-12">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="card-title mb-0">Sales Reports</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-primary me-3 p-2"><i
                                            class="ti ti-currency-rupee ti-sm"></i></div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ number_format($todayEarnings / 1000, 0) . 'k' }}</h5>
                                        <small>Today</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-info me-3 p-2"><i
                                            class="ti ti-currency-rupee ti-sm"></i></div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ number_format($thisWeekEarnings / 1000, 0) . 'k' }}</h5>
                                        <small>Week</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2"><i
                                            class="ti ti-currency-rupee ti-sm"></i></div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ number_format($thisMonthEarnings / 1000, 0) . 'k' }}</h5>
                                        <small>Month</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2"><i
                                            class="ti ti-currency-rupee ti-sm"></i></div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ number_format($totalEarnings / 1000, 0) . 'k' }}</h5>
                                        <small>Total</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics -->
            <!-- Revenue Growth -->
            <div class="col-xl-6 col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="card-title mb-auto">
                                    <h5 class="mb-1 text-nowrap">Current Week Sales</h5>
                                    <small>Weekly Report</small>
                                </div>
                                <div class="chart-statistics">
                                    <h3 class="card-title">₹{{ number_format($thisWeekEarnings) }}</h3>
                                </div>
                            </div>
                            <div id="revenueGrowth"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earning Reports Tabs-->
            <div class="col-12 col-xl-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Earning Reports</h5>
                            <small class="text-muted">Yearly Earnings Overview</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs widget-nav-tabs pb-3 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
                            {{-- <li class="nav-item">
                                <a href="javascript:void(0);"
                                    class="nav-link btn active d-flex flex-column align-items-center justify-content-center"
                                    role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id"
                                    aria-controls="navs-orders-id" aria-selected="true">
                                    <div class="badge bg-label-secondary rounded p-2">
                                        <i class="ti ti-shopping-cart ti-sm"></i>
                                    </div>
                                    <h6 class="tab-widget-title mb-0 mt-2">Purchase</h6>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="javascript:void(0);"
                                    class="nav-link btn active d-flex flex-column align-items-center justify-content-center"
                                    role="tab" data-bs-toggle="tab" data-bs-target="#navs-sales-id"
                                    aria-controls="navs-sales-id" aria-selected="false">
                                    <div class="badge bg-label-secondary rounded p-2">
                                        <i class="ti ti-activity-heartbeat ti-sm"></i>
                                    </div>
                                    <h6 class="tab-widget-title mb-0 mt-2">Sales</h6>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0);"
                                    class="nav-link btn d-flex flex-column align-items-center justify-content-center"
                                    role="tab" data-bs-toggle="tab" data-bs-target="#navs-income-id"
                                    aria-controls="navs-income-id" aria-selected="false">
                                    <div class="badge bg-label-danger rounded p-2">
                                        <i class="ti ti-currency-rupee ti-sm"></i>
                                    </div>
                                    <h6 class="tab-widget-title mb-0 mt-2">Expenses</h6>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content p-0 ms-0 ms-sm-2">
                            {{-- <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
                                <div id="earningReportsTabsOrders"></div>
                            </div> --}}
                            <div class="tab-pane fade show active" id="navs-sales-id" role="tabpanel">
                                <div id="earningReportsTabsSales"></div>
                            </div>
                            <div class="tab-pane fade" id="navs-income-id" role="tabpanel">
                                <div id="earningReportsTabsIncome"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales last 6 months -->
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">Sales & Expenses</h5>
                            <small class="text-muted">Last 6 Months</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="salesLastMonth"></div>
                    </div>
                </div>
            </div>
            <!-- Registered Customers -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Registered Customers</h6>
                            <i class="text-primary ti ti-users ti-xl"></i>
                        </div>
                        @if ($totalUserCount > 0)
                            <a href="{{ route('customers', ['type' => '']) }}">
                                <h4 class="card-title mb-1">{{ $totalUserCount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $totalUserCount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($todayCount > 0)
                                    <a href="{{ route('customers', ['type' => 'today']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $todayCount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $todayCount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($thisMonthCount > 0)
                                    <a href="{{ route('customers', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $thisMonthCount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $thisMonthCount }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Registered Users -->
            <!-- Refferal Users -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Refferal Users</h6>
                            <i class="text-primary ti ti-barcode ti-xl"></i>
                        </div>
                        @if ($refferalUserCount > 0)
                            <a href="{{ route('referral-history', ['type' => '']) }}" class="active">
                                <h4 class="card-title mb-1">{{ $refferalUserCount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $refferalUserCount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($refferalTodayCount > 0)
                                    <a href="{{ route('referral-history', ['type' => 'today']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $refferalTodayCount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $refferalTodayCount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($refferalthisMonthCount > 0)
                                    <a href="{{ route('referral-history', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                                            {{ $refferalthisMonthCount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $refferalthisMonthCount }}
                                    </h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Refferal Users -->
            <!-- Manufactures -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Manufactures</h6>
                            <i class="text-primary menu-icon tf-icons ti ti-building-factory ti-xl"></i>
                        </div>
                        @if ($manutotalcount > 0)
                            <a href="{{ route('manufacturer-list', ['type' => '']) }}">
                                <h4 class="card-title mb-1">{{ $manutotalcount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $manutotalcount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($mantodaycount > 0)
                                    <a href="{{ route('manufacturer-list', ['type' => 'today']) }}" class="active">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $mantodaycount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $mantodaycount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($manThisMonthCount > 0)
                                    <a href="{{ route('manufacturer-list', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $manThisMonthCount }}
                                        </h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $manThisMonthCount }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Manufactures -->
            <!-- Hubs -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Hubs</h6>
                            <i class="text-primary menu-icon tf-icons ti ti-bolt ti-xl"></i>
                        </div>
                        @if ($totalhubcount > 0)
                            <a href="{{ route('hub-list', ['type' => '']) }}">
                                <h4 class="card-title mb-1">{{ $totalhubcount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $totalhubcount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($hubtodaycount > 0)
                                    <a href="{{ route('hub-list', ['type' => 'today']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $hubtodaycount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $hubtodaycount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($hubThisMonthCount > 0)
                                    <a href="{{ route('hub-list', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $hubThisMonthCount }}
                                        </h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $hubThisMonthCount }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Hubs -->

            <!-- Delivery Persons -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Delivery Persons</h6>
                            <i class="text-primary menu-icon tf-icons ti ti-truck ti-xl"></i>
                        </div>
                        @if ($totaldeliverypersoncount > 0)
                            <a href="{{ route('deliverypersonlist', ['type' => '']) }}">
                                <h4 class="card-title mb-1">{{ $totaldeliverypersoncount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $totaldeliverypersoncount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($deliverypersontodaycount > 0)
                                    <a href="{{ route('deliverypersonlist', ['type' => 'today']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $deliverypersontodaycount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $deliverypersontodaycount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($deliverypersonThisMonthCount > 0)
                                    <a href="{{ route('deliverypersonlist', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                                            {{ $deliverypersonThisMonthCount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                                        {{ $deliverypersonThisMonthCount }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Delivery Persons -->
            <!-- Logistic Partners -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Logistic Partners</h6>
                            <i class="text-primary menu-icon tf-icons ti ti-packge-export ti-xl"></i>
                        </div>
                        @if ($totallogisticpartnercount > 0)
                            <a href="{{ route('logisticList', ['type' => '']) }}" class="active">
                                <h4 class="card-title mb-1">{{ $totallogisticpartnercount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $totallogisticpartnercount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($logisticpartnertodaycount > 0)
                                    <a href="{{ route('logisticList', ['type' => 'today']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $logisticpartnertodaycount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $logisticpartnertodaycount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($logisticpartnerThisMonthCount > 0)
                                    <a href="{{ route('logisticList', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                                            {{ $logisticpartnerThisMonthCount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                                        {{ $logisticpartnerThisMonthCount }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Logistic Partners -->
            <!-- Drivers -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Drivers</h6>
                            <i class="text-primary menu-icon tf-icons ti ti-user ti-xl"></i>
                        </div>
                        @if ($totallogisticdrivercount > 0)
                            <a href="{{ route('logisticDriverInfo', ['type' => '']) }}">
                                <h4 class="card-title mb-1">{{ $totallogisticdrivercount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $totallogisticdrivercount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($logisticdrivertodaycount > 0)
                                    <a href="{{ route('logisticDriverInfo', ['type' => 'today']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $logisticdrivertodaycount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $logisticdrivertodaycount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($logisticdriverThisMonthCount > 0)
                                    <a href="{{ route('logisticDriverInfo', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                                            {{ $logisticdriverThisMonthCount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                                        {{ $logisticdriverThisMonthCount }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Drivers -->
            <!-- Delayed Delivery Cans -->
            {{-- <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6 class="d-block mb-1 card-title">Delayed Delivery Cans</h6>
                        <i class="text-primary ti ti-droplet-filled-2 ti-xl"></i>
                    </div>
                    <h4 class="card-title mb-1">16</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <p class="mb-0">Today</p>
                            </div>
                            <h5 class="mb-0 pt-1 text-nowrap">2</h5>
                        </div>
                        <div class="col-2">
                            <div class="divider divider-vertical"></div>
                        </div>
                        <div class="col-5 text-end">
                            <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                <p class="mb-0">This Month</p>
                            </div>
                            <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">16</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
            <!--/ Delayed Delivery Cans -->
            <!-- Free Cans -->
            {{-- <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6 class="d-block mb-1 card-title">Free Cans</h6>
                        <i class="text-primary ti ti-droplet ti-xl"></i>
                    </div>
                    <h4 class="card-title mb-1">23</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <p class="mb-0">Today</p>
                            </div>
                            <h5 class="mb-0 pt-1 text-nowrap">3</h5>
                        </div>
                        <div class="col-2">
                            <div class="divider divider-vertical"></div>
                        </div>
                        <div class="col-5 text-end">
                            <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                <p class="mb-0">This Month</p>
                            </div>
                            <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">23</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
            <!--/ Free Cans -->
            <!-- Offers -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Offers</h6>
                            <i class="text-primary ti ti-discount-2 ti-xl"></i>
                        </div>
                        @if ($totaloffercount > 0)
                            <a href="{{ route('offers', ['type' => 'all']) }}">
                                <h4 class="card-title mb-1">{{ $totaloffercount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $totaloffercount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($todayoffercount > 0)
                                    <a href="{{ route('offers', ['type' => 'today']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $todayoffercount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $todayoffercount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($offerThisMonthCount > 0)
                                    <a href="{{ route('offers', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $offerThisMonthCount }}
                                        </h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $offerThisMonthCount }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Offers -->
            <!-- Orders -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Orders</h6>
                            <i class="text-primary ti ti-arrows-sort ti-xl"></i>
                        </div>
                        @if ($totalOrdersCount > 0)
                            <a href="{{ route('customerorders', ['type' => 'all']) }}">
                                <h4 class="card-title mb-1">{{ $totalOrdersCount }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">{{ $totalOrdersCount }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($todayOrdersCount > 0)
                                    <a href="{{ route('customerorders', ['type' => 'today']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">{{ $todayOrdersCount }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">{{ $todayOrdersCount }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($thisMonthOrdersCount > 0)
                                    <a href="{{ route('customerorders', ['type' => 'thismonth']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $thisMonthOrdersCount }}
                                        </h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">{{ $thisMonthOrdersCount }}
                                    </h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Orders -->

            <!-- Today Earnings -->
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Total Earnings</h6>
                            <i class="text-primary ti ti-currency-rupee ti-xl"></i>
                        </div>
                        @if ($totalEarnings > 0)
                            <a href="{{ route('customerorders', ['type' => 'totalearnings']) }}">
                                <h4 class="card-title mb-1">₹ {{ $totalEarnings }}</h4>
                            </a>
                        @else
                            <h4 class="card-title mb-1">₹ {{ $totalEarnings }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Today</p>
                                </div>
                                @if ($todayEarnings > 0)
                                    <a href="{{ route('customerorders', ['type' => 'todayearnings']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap">₹ {{ $todayEarnings }}</h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap">₹ {{ $todayEarnings }}</h5>
                                @endif
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">This Month</p>
                                </div>
                                @if ($thisMonthEarnings > 0)
                                    <a href="{{ route('customerorders', ['type' => 'thismonthearnings']) }}">
                                        <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">₹ {{ $thisMonthEarnings }}
                                        </h5>
                                    </a>
                                @else
                                    <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">₹ {{ $thisMonthEarnings }}</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Today Earnings -->

            <!-- Today Earnings -->
            <div class="col-lg-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h6 class="d-block mb-1 card-title">Company Closing Amount <br> <small class="text-muted">(Order + Deposit)</small></h6>
                            <i class="text-primary ti ti-currency-rupee ti-xl"></i>
                        </div>
                        <h4 class="card-title mb-1">₹ {{ $companyClosing }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <p class="mb-0">Order</p>
                                </div>
                                <h5 class="mb-0 pt-1 text-nowrap">₹ {{ $orderValue }}</h5>
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-2 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">Deposit</p>
                                </div>
                                <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">₹ {{ $totDeposit }}
                                </h5>
                            </div>
                            <div class="col-2">
                                <div class="divider divider-vertical"></div>
                            </div>
                            <div class="col-3 text-end">
                                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                    <p class="mb-0">Wallet</p>
                                </div>
                                <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">₹ {{ $totWallet }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Today Earnings -->

            {{-- <!-- Queries Attended -->
        <div class="col-lg-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h6 class="d-block mb-1 card-title">Pending Queries</h6>
                        <i class="text-primary ti ti-brand-messenger ti-xl"></i>
                    </div>
                    <h4 class="card-title mb-1">18</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <p class="mb-0">Attended</p>
                            </div>
                            <h5 class="mb-0 pt-1 text-nowrap">20</h5>
                            <small class="text-muted">6%</small>
                        </div>
                        <div class="col-2">
                            <div class="divider divider-vertical"></div>
                        </div>
                        <div class="col-5 text-end">
                            <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                <p class="mb-0">Raised</p>
                            </div>
                            <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">13</h5>
                            <small class="text-muted">12%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Queries Attended --> --}}
            <!-- Recent Orders -->
            <div class="col-lg-12 mb-4 mb-lg-0">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-header pb-0">
                            <h5 class="card-title m-0 me-2">Recent Orders</h5>
                            <small class="text-muted">Last 10 Orders</small>
                        </div>
                    </div>
                    <div class="card-datatable table-responsive pt-0">
                        <table id="tblAdminDashboardOrders" class="table">
                            <thead class="border-bottom">
                                <tr>
                                    <th>S.NO</th>
                                    <th>DATE</th>
                                    <th>ORDER NO</th>
                                    <th>CUSTOMER NAME</th>
                                    <th>HUB NAME</th>
                                    <th>QTY</th>
                                    <th>AMOUNT</th>
                                    <th>PAYMENT</th>
                                    <th>ORDER STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($totalorders as $item)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y h:i A') }}</td>
                                        {{-- {{ $item->created_at->format('h:i A') }} --}}
                                        <td>{{ $item->order_no }}</td>
                                        <td>{{ $item->customer_name }}
                                        </td>
                                        <td>{{ $item->hub_name }}</td>
                                        <td>{{ $item->total_qty }}</td>
                                        <td>₹{{ $item->grand_total }}</td>
                                        <td><span
                                                class="badge bg-label-{{ $item->payment_through === 'Razorpay' ? 'success' : 'warning' }}">{{ $item->payment_through }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-label-{{ $item->status_color_css }}">{{ $item->status }}</span>
                                        </td>
                                        <td><a href="{{ route('orderdetail', $item->id) }}"
                                                class="btn btn-xs btn-primary">View</a></td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Admin Dashboard Content --}}


    {{-- Manufacture Dashboard Content --}}
@elseif(Auth::user()->role_id == \app\Enums\RoleTypes::Manufacturer)
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-3">
            <div class="col-lg-8 col-md-8">
                <h3>Pending Orders</h3>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card ">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-title mb-0">
                                    <h5 class="mb-0 me-2">{{ $mantodayOrdersCount }}</h5>
                                    <small>Cans</small>
                                </div>
                                <div class="card-icon">
                                    <span class="badge bg-label-primary rounded-pill p-2">
                                        <i class="ti ti-shopping-cart ti-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="card-title mb-0">
                                    <h5 class="mb-0 me-2">{{ $manthisMonthOrdersCount }}</h5>
                                    <small>Others</small>
                                </div>
                                <div class="card-icon">
                                    <span class="badge bg-label-warning rounded-pill p-2">
                                        <i class="ti ti-shopping-cart ti-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <h3>In Production</h3>
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ $mantotalOrdersCount }}</h5>
                            <small>Total Cans</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded-pill p-2">
                                <i class="ti ti-shopping-cart ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-xl-12">
                <h3>Orders</h3>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-cans" aria-controls="navs-justified-cans"
                                aria-selected="true">
                                Cans
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-others" aria-controls="navs-justified-others"
                                aria-selected="false">
                                Others
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-justified-cans" role="tabpanel">
                            <div class="card-datatable table-responsive pt-0">
                                <table id="tblCans" class="table">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Product Type Name</th>
                                            <th>Product Name</th>
                                            <th>Order Qty</th>
                                            <th>Filled Qty</th>
                                            <th>Empty Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-justified-others" role="tabpanel">
                            <div class="card-datatable table-responsive pt-0">
                                <table id="tblOthers" class="table">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Product Type Name</th>
                                            <th>Product Name</th>
                                            <th>Order Qty</th>
                                            <th>Filled Qty</th>
                                            <th>Empty Qty</th>
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

        <div class="row mt-3">
            <div class="col-xl-12">
                <h3>Production</h3>
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-production" aria-controls="navs-justified-production"
                                aria-selected="false">
                                In Production
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-instock" aria-controls="navs-justified-instock"
                                aria-selected="false">
                                In Stock
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-emptycans" aria-controls="navs-justified-emptycans"
                                aria-selected="false">
                                Empty Cans
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-justified-damagedcans"
                                aria-controls="navs-justified-damagedcans" aria-selected="false">
                                Damaged Cans
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-justified-production" role="tabpanel">
                            <div class="card-datatable table-responsive pt-0">
                                <table id="tblInProduction" class="table">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Product Type Name</th>
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-justified-instock" role="tabpanel">
                            <div class="card-datatable table-responsive pt-0">
                                <table id="tblInStock" class="table">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Product Type Name</th>
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-justified-emptycans" role="tabpanel">
                            <div class="card-datatable table-responsive pt-0">
                                <table id="tblEmptyCans" class="table">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Product Type Name</th>
                                            <th>Product Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-justified-damagedcans" role="tabpanel">
                            <div class="card-datatable table-responsive pt-0">
                                <table id="tblDamagedCans" class="table">
                                    <thead class="border-bottom">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Category Name</th>
                                            <th>Product Type Name</th>
                                            <th>Product Name</th>
                                            <th>Qty</th>
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

    </div>
    {{-- End Manufacture Dashboard Content --}}


    {{-- Hub Dashboard Content --}}
@elseif(Auth::user()->role_id == \app\Enums\RoleTypes::Hub)
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <h3>Dashboard</h3>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card ">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ $hubTodayOrders }}</h5>
                            <small>Today's Orders</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded-pill p-2">
                                <i class="ti ti-shopping-cart ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ $hubthisMonthOrders }}</h5>
                            <small>This Month Orders</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-warning rounded-pill p-2">
                                <i class="ti ti-shopping-cart ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ $hubTotalOrders }}</h5>
                            <small>Total Orders</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded-pill p-2">
                                <i class="ti ti-shopping-cart ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Hub Dashboard Content --}}

    {{-- Logistic Dashboard Content --}}
@elseif(Auth::user()->role_id == \app\Enums\RoleTypes::LogisticPartner)
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <h3>Dashboard</h3>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card ">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ $logisticTotalVehicles }}</h5>
                            <small>Total Vehicles</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded-pill p-2">
                                <i class="ti ti-truck ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="mb-0 me-2">{{ $logisticTotalDrivers }}</h5>
                            <small>Total Drivers</small>
                        </div>
                        <div class="card-icon">
                            <span class="badge bg-label-warning rounded-pill p-2">
                                <i class="ti ti-users ti-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Logistic Dashboard Content --}}
@elseif(Auth::user()->role_id != \app\Enums\RoleTypes::SuperAdmin &&
        Auth::user()->role_id != \app\Enums\RoleTypes::Manufacturer &&
        Auth::user()->role_id != \app\Enums\RoleTypes::Hub &&
        Auth::user()->role_id != \app\Enums\RoleTypes::LogisticPartner)
    Dashboard | Click Your Order
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3>Dashboard</h3>
    </div>
@endif
@endsection
@section('footer')
<script src="{{ asset('assets/js/dashboards-crm.js') }}"></script>
<script src="{{ asset('assets/js/admin/admindashboard/dashboard.js') }}"></script>
<script>
    var weeklySales = {!! json_encode($weeklySales) !!};
    var weekDays = {!! json_encode($weekDays) !!};
    var lastSixMonthorders = {!! json_encode($lastSixMonthorders) !!};
    var lastSixMonthExpenses = {!! json_encode($lastSixMonthExpenses) !!};
    var lastSixMonths = {!! json_encode($lastSixMonths) !!};
</script>
@endsection
