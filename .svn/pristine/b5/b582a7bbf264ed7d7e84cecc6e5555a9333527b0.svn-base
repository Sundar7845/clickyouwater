@extends('layouts.main_master')
@section('content')
@section('title')
    Surrender Details | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Surrender Details
    </h4>
    <div class="row">
        <!-- Invoice -->
        <div class="col-xl-12 col-md-12 col-12 mb-md-0 mb-4">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div
                        class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                        <div class="mb-xl-0 mb-4">
                            <h4 class="fw-semibold mb-2">{{ $customeraddress->user_name }}</h4>
                            <p class="mb-2">{{ $customeraddress->floor }},{{ $customeraddress->building_no }},
                                {{ $customeraddress->street }},{{ $customeraddress->area }},{{ $customeraddress->city_name }},
                                {{ $customeraddress->state_name }}-{{ $customeraddress->pincode }}.</p>
                            <p class="mb-0">+91 {{ $customeraddress->contact_person_mobile }}</p>
                        </div>
                        <div>
                            {{-- <h4 class="fw-semibold mb-2">SURRENDER NO: {{ $customeraddress->surrender_order_no }}</h4> --}}
                            <div class="pt-1">
                                <span>Surrender No:</span>
                                <span class="fw-semibold">{{ $customeraddress->surrender_order_no }}</span>
                            </div>
                            <div class="mb-2 pt-1">
                                <span>Surrender Date:</span>
                                <span class="fw-semibold">{{ $customeraddress->surrender_date }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Deposit Amount</th>
                                    <th>Surrender Qty</th>
                                    <th>Refund Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total_variable = 0 @endphp
                                @foreach ($surrenderdetails as $item)
                                    <tr>
                                        <td class="text-nowrap"><img src="{{ $item->product_image }}" width="100"
                                                height="100"></td>
                                        <td class="text-nowrap">{{ $item->product_name }}</td>
                                        <td>₹{{ $item->deposit_amount }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>₹{{ $item->deposit_amount * $item->qty }}</td>
                                        @php $total_variable += $item->deposit_amount * $item->qty @endphp
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <p class="fw-bold mb-2">Reason to surrender:</p>
                                        <p class="mb-2">{{ $customeraddress->reason }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="fw-bold mb-2">Surrender Status:</p>
                                        <p class="mb-2"><a class="badge bg-label-{{ $customeraddress->status_color_css }}">{{ $customeraddress->status }}</a></p>
                                    </td>
                                    @if($customeraddress->reject_reason_note != null)
                                    <td>
                                        <p class="fw-bold mb-2">Rejected Reason:</p>
                                        <p class="mb-2"><a class="badge bg-label-{{ $customeraddress->status_color_css }}">{{ $customeraddress->reject_reason_note }}</a></p>
                                    </td>
                                    @endif
                                    <td colspan="3" class="text-end px-4 py-3">
                                        <p class="mb-2">Total Refund:</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="fw-bold mb-2">₹{{ $total_variable }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Invoice -->
    </div>
</div>
<!-- / Content -->
@endsection
