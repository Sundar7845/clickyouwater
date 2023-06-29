@extends('layouts.main_master')
@section('content')
@section('title')
    Reasons | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Reasons
    </h4>

    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('add.reasons') }}" method="POST" id="reasons" name="reasons">
                        @csrf
                        <input type="hidden" name="hdReasonId" id="hdReasonId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="ddlreasonType">Reason Type</label>
                                    <select name="ddlreasonType" id="ddlreasonType" class="select2 form-select"
                                        title="Select Reason Type" required>
                                        <option value="">Select Reason Type</option>
                                        @foreach ($resontypes as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('ddlreasonType') ? 'selected' : '' }}>{{ $item->reason_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlreasonType'))
                                        <div class="text-danger">{{ $errors->first('ddlreasonType') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtReson">Reason</label>
                                    <input type="text" name="txtReson" id="txtReson" class="form-control"
                                        placeholder="Enter Reasons" title="Enter Reasons" value="{{ old('txtReson') }}"
                                        required>
                                    @if ($errors->has('txtReson'))
                                        <div class="text-danger">{{ $errors->first('txtReson') }}</div>
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
                <h5 class="card-title m-0 me-2">Reasons List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblRecentTypeMasters" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Reason Type</th>
                            <th>Reasons</th>
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
<script src="{{ asset('assets/js/admin/masters/reasons.js') }}"></script>
@endsection
