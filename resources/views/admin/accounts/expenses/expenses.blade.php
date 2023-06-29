@extends('layouts.main_master')
@section('content')
@section('title')
    Expense | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Expense
    </h4>

    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('expensecreate') }}" id="expensesubmit"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- RADIO BUTTONS -->
                            <div class="d-flex mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="rounded-circle form-check-input option-input checkbox" type="radio"
                                        name="flexRadioDefault" id="radioGenral" name="radioGenral" checked>
                                    <label class="form-label" for="radioGenral">General Expense</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="rounded-circle form-check-input option-input checkbox" type="radio"
                                        name="flexRadioDefault" id="radioEmployee" name="radioEmployee">
                                    <label class="form-label" for="radioEmployee">Employee Expense</label>
                                </div>
                                <input type="hidden" name="txtExpenseType" id="txtExpenseType" value="0">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Entry Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="ddlDate" id="ddlDate"
                                            max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Expense Detail<span class="text-danger">*</span></label>
                                    <input type="text" tabindex="-1" class="form-control" id="txtExpenseDetail"
                                        name="txtExpenseDetail" placeholder="Enter Expense Detail">
                                    <span class="mb-3 text-danger" id="emptydetail"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4 col-sm-4 col-md-4" id="ledDiv">
                                <div class="mb-3">
                                    <label class="form-label">Expense Ledger<span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="ddlExpenselVendor" id="ddlExpenselVendor">
                                        <option value="">Select Ledger</option>
                                        @foreach ($expenseVendor as $item)
                                            <option value="{{ $item->id }}">{{ $item->ledger_name }}</option>
                                        @endforeach
                                    </select>
                                    <h6 class="card-title mt-2"> Closing Balance ₹
                                        <span id="closinglVendor">0.00</span>
                                    </h6>
                                    <span class="mb-3 text-danger" id="emptyvenledger"></span>
                                </div>
                                <input type="hidden" name="hdclosinglVendor" id="hdclosinglVendor" value="0">
                            </div><!-- Col -->

                            <div class="form-group col-lg-4 col-sm-4 col-md-4" id="empDiv" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Expense Employee<span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="ddlExpenselEmployee"
                                        id="ddlExpenselEmployee">
                                        <option value="">Select Employee</option>
                                        @foreach ($employeeLeger as $item)
                                            <option value="{{ $item->id }}">{{ $item->display_name }}</option>
                                        @endforeach
                                    </select>
                                    <h6 class="card-title mt-2"> Pending Balance ₹
                                        <span id="pendingemployee">0.00</span>
                                    </h6>
                                    <span class="mb-3 text-danger" id="emptyemployeeId"></span>
                                    <input type="hidden" name="hdPendingEmployee" id="hdPendingEmployee">
                                </div>

                            </div><!-- Col -->
                            <div class="form-group col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label" for="">Amount<span class="text-danger">*</span></label>
                                    <input type="text" id="txtAmount" name="txtAmount" class="form-control"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        control="numeric" maxlength="15" autocomplete="off"
                                        placeholder="Enter Amount">
                                    <span class="mb-3 text-danger" id="emptyamount"></span>
                                </div>

                            </div><!-- Col -->
                            <div class="form-group col-md-4 col-lg-4">
                                <div class="mb-3">
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="form-group col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Expense Group<span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="ddlExpenseGroup" id="ddlExpenseGroup">
                                        <option value="">Select Expense Group</option>
                                        @foreach ($expenseGroup as $item)
                                            <option value="{{ $item->id }}">{{ $item->expensegroup_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="mb-3 text-danger" id="emptygrp"></span>
                                </div>

                                <div class="mb-3" id="empFile" style="display: none;">
                                    <label class="form-label">
                                        File Attachment</label>
                                    <div class="input-group">
                                        <input id="txtfileattachment" name="txtfileattachment" type="file"
                                            class="form-control" tabindex="-1"
                                            accept="application/pdf,.png, .jpg, .jpeg">
                                    </div>
                                </div>
                            </div><!-- Col -->


                            <input type="hidden" name="isPaid" id="isPaid">
                            <div class="form-group col-md-4 col-lg-4" id="PayNowdiv" style="display:none;">
                                <div class="mb-2">
                                    <label class="form-label">
                                        <input type="checkbox" class="form-check-input mt-0" name="txtCheckBox"
                                            id="txtCheckBox">
                                        Paid</label>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">From Company Ledger<span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="ddlExpenselCompany"
                                        id="ddlExpenselCompany">
                                        <option value="0">Select Company Ledger</option>
                                        @foreach ($companyLedger as $item)
                                            <option value="{{ $item->id }}">{{ $item->ledger_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <h6 class="card-title mt-2"> Closing Balance ₹
                                        <span id="closinglCompany">0.00</span>
                                    </h6>
                                    <span class="mb-3 text-danger" id="emptycompany"></span>
                                    <input type="hidden" name="hdClosinglCompany" id="hdClosinglCompany"
                                        value="0">
                                </div>


                            </div><!-- Col -->
                            <div class="form-group col-md-4 col-lg-4" id="NotPaydiv">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <input type="checkbox" class="form-check-input mt-0" name="txtNotPay"
                                            id="txtNotPay"> Not Paid</label>
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-lg-4">
                                <div class="mb-3">
                                </div>
                            </div><!-- Col -->
                            <div class="form-group col-md-4 col-lg-4">
                                <div class="mb-3">
                                </div>
                            </div><!-- Col -->
                            <div class="form-group col-md-4 col-lg-4">
                                <div class="mb-3">
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="clearData()">Cancel</button>
                                </div>
                                <div class="mt-4 mb-3">
                                    <a href="{{ route('expenselist') }}" class="btn btn-primary">Go To List</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->
@endsection

@section('footer')
<script src="{{ asset('assets/js/admin/accounts/expense/expense.js') }}"></script>
@endsection
