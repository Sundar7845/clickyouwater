@extends('layouts.main_master')
@section('content')
@section('title')
    Expense List | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Expense List
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5 me-0">
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-tabs border-0" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home"
                                            aria-controls="navs-top-home" aria-selected="true">
                                            General
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-justified-profile"
                                            aria-controls="navs-top-profile" aria-selected="false" id="btnEmployee"
                                            onclick="employeeExpenseList();">
                                            Employee
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-sm-3 mb-3">
                            <select class="form-select select2" id="ddlFilterExpensegroup" name="ddlFilterExpensegroup">
                                <option value="0">Select Expense Group</option>
                                @foreach ($expenseGroup as $item)
                                    <option value="{{ $item->id }}">{{ $item->expensegroup_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-sm-4 mb-3">
                            <div class="d-flex justify-content-lg-end">
                                {{-- <a href="{{ route('expenses.export') }}" class="btn btn-outline-primary me-3">Export</a> --}}
                                <button type="button" class="btn btn-flat btn-primary" id="btnDate"
                                    style="height: 36px;">
                                    <i class="fa fa-calendar"></i>
                                    <span id="spnDate" style="padding-left: 5px;">Today</span>
                                    <i class="fa fa-caret-down" style="padding-left: 5px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Expense List</h5>
                            <div class="card-datatable table-responsive pt-0">
                                <div class="tab-content p-0">
                                    <div class="tab-pane active" id="navs-pills-justified-home" role="tabpanel">
                                        <div class="col-4">
                                            <select class="form-select select2" id="ddlExpenseCompany"
                                                name="ddlExpenseCompany">
                                                <option value="0">Select Ledger</option>
                                                @foreach ($companyLedger as $item)
                                                    <option value="{{ $item->id }}">{{ $item->ledger_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <table id="tblExpense" class="table">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Expense Date</th>
                                                    <th>Expense Ledger</th>
                                                    <th>Expense Group</th>
                                                    <th>Expense Detail</th>
                                                    <th id="balance_amount">Amount</th>
                                                    <th id="paid_amount">Paid Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyList">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" style="font-weight: bolder;">TOTAL</th>
                                                    <th id="total_amount"></th>
                                                    <th id="total_paid"></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="navs-pills-justified-profile" role="tabpanel">
                                        <div class="col-4">
                                            <select class="form-select select2" id="ddlExpenseEmployee"
                                                name="ddlExpenseEmployee">
                                                <option value="0">Select Employee</option>
                                                @foreach ($employeeLedger as $item)
                                                    <option value="{{ $item->id }}">{{ $item->display_name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <table id="tblEmployeeExpense" class="table">
                                            <thead>
                                                <tr class='header'>
                                                    <th>S.No</th>
                                                    <th>Expense Date</th>
                                                    <th>Expense Employee</th>
                                                    <th>Expense Group</th>
                                                    <th>Expense Detail</th>
                                                    <th>Expense File</th>
                                                    <th id="emp_balance_amount">Amount</th>
                                                    <th id="emp_paid_amount">Paid Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyList">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="6" style="font-weight: bolder;">TOTAL</th>
                                                    <th id="emp_total_amount"></th>
                                                    <th id="emp_total_paid"></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/accounts/expense/expenselist.js') }}"></script>
@endsection
