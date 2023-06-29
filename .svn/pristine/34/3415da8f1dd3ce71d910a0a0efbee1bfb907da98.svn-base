@extends('layouts.main_master') @section('content')
@section('title')
    Product Type | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        <span id="heading">Product Type</span> 
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('add.prodctType') }}" name="producttype" method="POST">
                        @csrf
                        <input type="hidden" name="hdProductTypeId" id="hdProductTypeId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ddlCategory">Category<span class="text-danger">*</span>
                                    </label>
                                    <select name="ddlCategory" id="ddlCategory" class="select2 form-select"
                                        data-rule-required="true" title="Select Category">
                                        <option value="">Select Category</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('ddlCategory') == $item->id ? 'selected' : '' }}>
                                                {{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('txtProductTypeName'))
                                        <div class="text-danger">{{ $errors->first('txtProductTypeName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="txtProductType">Product Type Name<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="txtProductTypeName" id="txtProductTypeName"
                                        class="form-control" placeholder="Enter Product Type Name"
                                        title="Enter Product Type Name" value="{{ old('txtProductTypeName') }}">
                                    @if ($errors->has('txtProductTypeName'))
                                        <div class="text-danger">{{ $errors->first('txtProductTypeName') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Delivery Charge <span class="text-muted">(₹)</span><span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="txtDeliveryCharge" name="txtDeliveryCharge"
                                        class="form-control" placeholder="Enter Delivery Charge" min="0"
                                        oninput="validity.valid||(value='');" title="Enter delivery charge"
                                        value="{{ old('txtDeliveryCharge') }}" required />

                                    @if ($errors->has('txtDeliveryCharge'))
                                        <div class="text-danger">{{ $errors->first('txtDeliveryCharge') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Delivery Duration <span class="text-muted">(hrs)</span><span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="txtDeliveryDuration" name="txtDeliveryDuration"
                                        class="form-control" placeholder="Enter Delivery Duration" min="0"
                                        oninput="validity.valid||(value='');" title="Enter delivery duration"
                                        value="{{ old('txtDeliveryDuration') }}" required />

                                    @if ($errors->has('txtDeliveryDuration'))
                                        <div class="text-danger">{{ $errors->first('txtDeliveryDuration') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="flatpickr-basic">Order Before <span class="text-danger">*</span></label>
                                    <input type="time" id="timeOrderBefore" name="timeOrderBefore"
                                        class="form-control" title="Enter Order Before"
                                        value="{{ old('timeOrderBefore') }}" required />

                                    @if ($errors->has('timeOrderBefore'))
                                        <div class="text-danger">{{ $errors->first('timeOrderBefore') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>New Can Deposit <span class="text-muted">(₹)</span> <span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="txtNewCanDeposit" name="txtNewCanDeposit"
                                        class="form-control" placeholder=" Enter New Can Deposit Amount" min="0"
                                        oninput="validity.valid||(value='');" title="Enter New Can Deposit"
                                        value="{{ old('txtNewCanDeposit') }}" required />

                                    @if ($errors->has('txtNewCanDeposit'))
                                        <div class="text-danger">{{ $errors->first('txtNewCanDeposit') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Order Qty <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon11">Min</span>
                                    <input type="number" class="form-control" id="txtMinQty" name="txtMinQty"
                                        min="0" oninput="validity.valid||(value='');" title="Enter Order Qty"
                                        value="{{ old('txtMinQty') }}" required />

                                    <span class="input-group-text" id="basic-addon11">Max</span>
                                    <input type="number" class="form-control" id="txtMaxQty" name="txtMaxQty"
                                        min="0" oninput="validity.valid||(value='');" title="Enter Order Qty"
                                        value="{{ old('txtMaxQty') }}" required />
                                </div>
                                @if ($errors->has('txtMaxQty'))
                                    <div class="text-danger">{{ $errors->first('txtMaxQty') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Description <span class="text-danger">*</span></label>
                                    <textarea type="text" id="txtdescription" name="txtdescription" class="form-control" placeholder="Description"
                                        title="Enter description" required>{{ old('txtdescription') }} </textarea>

                                    @if ($errors->has('txtdescription'))
                                        <div class="text-danger">{{ $errors->first('txtdescription') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Check only this Product Type belongs to Elite<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <label class="switch">
                                            <input type="checkbox" id="chkElite"
                                                name="chkElite" value="0" class="switch-input"  {{ old('chkElite') == 1 ? 'checked' : '' }}>
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4 mb-3">
                                    <button type="submit" id="btnSave" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-danger" onclick="cancel();">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>

    <h5 class="fw-bold py-1 mb-4">Product Type List</h5>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblProducttype" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Category Name</th>
                            <th>Product Type</th>
                            <th>Delivery Charge (₹)</th>
                            <th>Delivery Duration (Hrs)</th>
                            <th>Order Before</th>
                            <th>New Can Deposit (₹)</th>
                            <th>Order Qty Min / Max </th>
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
<script src="{{ asset('assets/js/admin/products/producttype.js') }}"></script>
@endsection
