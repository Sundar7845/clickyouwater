@extends('layouts.main_master')
@section('content')
@section('title')
    Overall Stocks | Click Your Order
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center mb-0 mb-md-2">
            <h4 class="fw-bold mb-4">
                Overall Stocks
            </h4>
        </div>
        <div class="d-flex align-items-center mb-0 mb-md-2">
            <a href="">
                <i class="ti ti-rotate-clockwise rotate-180 scaleX-n1-rtl cursor-pointer email-refresh me-2 mt-1"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <!-- DataTable -->
        <div class="col-lg-12 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive py-0">
                    <table id="tblProductStockList" class="table text-center">
                        <thead class="border-bottom">
                            <tr>
                                <th>Total</th>
                                <th>Manufacturer</th>
                                <th>Logistics</th>
                                <th>Hub</th>
                                <th>Delivery Person</th>
                                <th>Customer</th>
                                <th class="alert alert-danger">Damage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $total_stocks_count ?? 0 }}</td>
                                <td><a
                                        href='{{ route('stock_manufacture_reports') }}'>{{ $manufacturer_total_stock ?? 0 }}</a>
                                </td>
                                <td><a
                                        href='{{ route('stock_logistics_reports') }}'>{{ $logistic_total_stock ?? 0 }}</a>
                                </td>
                                <td><a href='{{ route('stock_hub_reports') }}'>{{ $hub_total_stock ?? 0 }}</a></td>
                                <td><a
                                        href='{{ route('stock_deliveryperson_reports') }}'>{{ $delivery_person_total_stock ?? 0 }}</a>
                                </td>
                                <td><a
                                        href='{{ route('stock_customer_reports') }}'>{{ $customer_total_stock ?? 0 }}</a>
                                </td>
                                <td class="alert alert-danger">{{ $total_damaged_stock ?? 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- End DataTable -->
        <div class="col-lg-3 mt-4 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive py-0">
                    <table id="tblProductStockList" class="table">
                        <thead class="border-bottom text-center">
                            <tr class="bg bg-light">
                                <th colspan="2">Manufacturer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>In Stock</td>
                                <td>{{ $manufacturer_stocks->filled_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Empty</td>
                                <td>{{ $manufacturer_stocks->empty_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>In Production</td>
                                <td>{{ $manufacturer_production_stocks ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Damage</td>
                                <td>{{ $manufacturer_stocks->damaged_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr class="alert alert-danger">
                                <td>Total</td>
                                <td><a
                                        href='{{ route('stock_manufacture_reports') }}'>{{ $manufacturer_total_stock ?? 0 }}</a>
                                </td>
                            </tr>
                            <tr class="alert alert-warning">
                                <td>Order</td>
                                <td>{{ $manufacturer_stocks->order_qty ?? 0 }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mt-4 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive py-0">
                    <table id="tblProductStockList" class="table">
                        <thead class="border-bottom text-center">
                            <tr class="bg bg-light">
                                <th colspan="2">Logistics</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>In Stock</td>
                                <td>{{ $logistic_stocks->filled_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Empty</td>
                                <td>{{ $logistic_stocks->empty_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Damage</td>
                                <td>{{ $logistic_stocks->damaged_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr class="alert alert-danger">
                                <td>Total</td>
                                <td><a
                                        href='{{ route('stock_logistics_reports') }}'>{{ $logistic_total_stock ?? 0 }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mt-4 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive py-0">
                    <table id="tblProductStockList" class="table">
                        <thead class="border-bottom text-center">
                            <tr class="bg bg-light">
                                <th colspan="2">Hub</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>In Stock</td>
                                <td>{{ $hub_stocks->filled_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Empty</td>
                                <td>{{ $hub_stocks->empty_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Damage</td>
                                <td>{{ $hub_stocks->damaged_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr class="alert alert-danger">
                                <td>Total</td>
                                <td><a href='{{ route('stock_hub_reports') }}'>{{ $hub_total_stock ?? 0 }}</a>
                                </td>
                            </tr>
                            <tr class="alert alert-warning">
                                <td>Order</td>
                                <td>{{ $hub_stocks->order_qty ?? 0 }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mt-4 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive py-0">
                    <table id="tblProductStockList" class="table">
                        <thead class="border-bottom text-center">
                            <tr class="bg bg-light">
                                <th colspan="2">Delivery Person</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>In Stock</td>
                                <td>{{ $delivery_person_stocks->filled_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Empty</td>
                                <td>{{ $delivery_person_stocks->empty_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Damage</td>
                                <td>{{ $delivery_person_stocks->damaged_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Extra</td>
                                <td>{{ $delivery_person_stocks->extra_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr class="alert alert-danger">
                                <td>Total</td>
                                <td><a
                                        href='{{ route('stock_deliveryperson_reports') }}'>{{ $delivery_person_total_stock ?? 0 }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mt-4 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive py-0">
                    <table id="tblProductStockList" class="table">
                        <thead class="border-bottom text-center">
                            <tr class="bg bg-light">
                                <th colspan="2">Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Empty</td>
                                <td>{{ $customer_stocks->empty_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Damage</td>
                                <td>{{ $customer_stocks->damaged_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Extra</td>
                                <td>{{ $customer_stocks->extra_qty ?? 0 }}
                                </td>
                            </tr>
                            <tr class="alert alert-danger">
                                <td>Total</td>
                                <td><a
                                        href='{{ route('stock_customer_reports') }}'>{{ $customer_total_stock ?? 0 }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mt-4 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-datatable table-responsive py-0">
                    <table id="tblProductStockList" class="table">
                        <thead class="border-bottom text-center">
                            <tr class="bg bg-danger">
                                <th colspan="2" class="text-white">Damage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Manufacturer</td>
                                <td>{{ $manufacturer_damaged ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Logistics</td>
                                <td>{{ $logistic_damaged ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Hub</td>
                                <td>{{ $hub_damaged ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Delivery Person</td>
                                <td>{{ $delivery_person_damaged ?? 0 }}
                                </td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>{{ $customer_damaged ?? 0 }}
                                </td>
                            </tr>
                            <tr class="alert alert-danger">
                                <td>Total</td>
                                <td>{{ $total_damaged_stock ?? 0 }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
