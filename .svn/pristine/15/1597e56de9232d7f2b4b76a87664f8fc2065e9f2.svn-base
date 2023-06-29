@extends('layouts.main_master')
@section('content')
@section('title')
    Asset | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4" id="assetTitle">
        Asset
    </h4>

    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('add.asset') }}" method="POST" id="asset">
                        @csrf
                        <input type="hidden" name="hdAssetId" id="hdAssetId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="txtAssetPrefix">&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon11">Asset Code</span>
                                    <input type="text" class="form-control" value="{{ old('txtAssetPrefix') }}" name="txtAssetPrefix" readonly
                                        id="txtAssetPrefix" title="Selct Asset Prefix" required/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="ddlAssetType">Asset Type<span class="text-danger">*</span></label>
                                    <select name="ddlAssetType" id="ddlAssetType" class="select2 form-select" title="Select Asset Type" required>
                                        <option value="">Select Asset Type</option>
                                        @foreach ($assetType as $item)
                                            <option value="{{ $item->id }}" {{ old('ddlAssetType') == $item->id ? 'selected' : '' }}>{{ $item->asset_type }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlAssetType'))
                                    <div  class="text-danger">{{ $errors->first('ddlAssetType') }}</div>
                                @endif
                                    <span  class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtAssetName">Asset Name<span class="text-danger">*</span></label>
                                    <input type="text" name="txtAssetName" id="txtAssetName" class="form-control"
                                        placeholder="Asset Name" value="{{ old('txtAssetName') }}" title="Enter Asset Name" required>
                                        @if ($errors->has('txtAssetName'))
                                        <div  class="text-danger">{{ $errors->first('txtAssetName') }}</div>
                                    @endif
                                        <span  class="error"></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Asset Detail<span class="text-danger">*</span></label>
                                    <textarea type="text" name="txtAssetDetail" id="txtAssetDetail" class="form-control"
                                        placeholder="Asset Detail" title="Enter Asset Details" required>{{ old('txtAssetDetail') }}</textarea>
                                        @if ($errors->has('txtAssetDetail'))
                                        <div  class="text-danger">{{ $errors->first('txtAssetDetail') }}</div>
                                    @endif
                                        <span  class="error"></span>
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
                <h5 class="card-title m-0 me-2">Asset List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblAsset" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Asset Code</th>
                            <th>Asset Type</th>
                            <th>Asset Name</th>
                            <th>Asset Details</th>
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
<script src="{{ asset('assets/js/admin/masters/asset.js') }}"></script>
@endsection
