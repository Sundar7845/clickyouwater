@extends('layouts.main_master')
@section('content')
@section('title')
    Logistic Stock | Dashboard | Click Your Order
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Product Wise Stock Report - {{ $product_name }}</h4>
    <input type="hidden" name="hdProductId" id="hdProductId" value="{{ $product_id }}">
    <input type="hidden" name="hdDriverId" id="hdDriverId" value="{{ $driver_id }}">
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="nav-align-top nav-tabs-shadow mb-4">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-empty" aria-controls="navs-justified-empty"
                            aria-selected="true">
                            Empty
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-filled" aria-controls="navs-justified-filled"
                            aria-selected="false">
                            Filled
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-justified-empty" role="tabpanel">
                        <div class="card-datatable table-responsive pt-0">
                            <table id="tblLogisticEmptyCans" class="table">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Inward From Hub</th>
                                        <th>Outward to Manufacturer</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-justified-filled" role="tabpanel">
                        <div class="card-datatable table-responsive pt-0">
                            <table id="tblLogisticFilledCans" class="table">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Outward Return Damaged</th>
                                        <th>Inward From Manufacturer</th>
                                        <th>Inward Return</th>
                                        <th>Outward to Hub</th>
                                        <th>Outward Return From Hub</th>
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
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/logistic/stock/stock.js') }}"></script>
@endsection
