@extends('layouts.main_master') @section('content')
@section('title')
    Hub Document | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Documents
    </h4>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Document Name</th>
                            <th>Document</th>
                            <th>Verification</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>GST Reg</td>
                            <td>
                                <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>FSSAI Cert</td>
                            <td>
                                <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>MOU</td>
                            <td>
                                <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Agreement</td>
                            <td>
                                <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Proprietor / Director PAN</td>
                            <td>
                                <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Proprietor / Director Aadhar</td>
                            <td>
                                <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            </td>
                            <td>
                                <div class="col-sm-6">
                                    <label class="switch">
                                        <input type="checkbox" class="switch-input" />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ DataTable with Buttons -->
</div>
<!-- viewDocument Modal -->
<div class="modal fade" id="viewDocument" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ viewDocument Modal -->
<!-- / Content -->
@endsection
