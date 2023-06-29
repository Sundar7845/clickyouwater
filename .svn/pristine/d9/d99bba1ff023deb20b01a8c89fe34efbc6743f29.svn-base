@extends('layouts.main_master')
@section('content')
@section('title')
    Expense Group | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4" id="expenseGroupTitle">
        Expense Group
    </h4>

    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form class="browser-default-validation" name="expenseGroup" action="{{ route('addexpensegroup') }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="hdExpensegroupId" id="hdExpensegroupId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtExpense">Expense Group Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtExpense" id="txtExpense" class="form-control"
                                        placeholder="Expense Group Name" title="Enter Expense Group Name"
                                        value="{{ old('txtExpense') }}" required />
                                    @if ($errors->has('txtExpense'))
                                        <div class="text-danger">{{ $errors->first('txtExpense') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-4 mb-3">
                                <button type="submit" id="btnSave" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-danger" onclick="cancel();">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0 me-2">Expense Group List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblExpenseGroupList" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Expense Group Name</th>
                            <th>Status</th>
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
<script src="{{ asset('assets/js/admin/masters/expensegroup.js') }}"></script>
@endsection
