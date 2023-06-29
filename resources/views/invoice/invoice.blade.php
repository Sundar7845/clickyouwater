<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <style>
        table tr td {
            padding: 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card invoice-preview-card">
            <div class="card-body">
                <form id="formPrint" runat="server">
                    <div style='height:900px; line-height: 20px; font-family:arial,sans-serif;'>
                        <table style='width:100%;border-collapse: collapse; font-size: 14px;' cellpadding=0
                            cellspacing=0>
                            <tr>
                                <td
                                    style='width:50%; text-align:left;'>
                                    <div><img
                                            src="data:image/png;base64,{{ base64_encode(file_get_contents($companyDetails->company_logo)) }}"
                                            alt="logo" class="m-0" width="228px" height="50px"><br />
                                        {{ $companyDetails->company_name }} <br />
                                        {{ $companyDetails->company_address }}<br />
                                        Email : {{ $companyDetails->company_email }}<br />
                                        GSTIN : {{ $companyDetails->gstin }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table style='width:100%;border-collapse: collapse; font-size: 14px;'>
                            <tr>
                                <td style='text-align:center;'>
                                    <div style="font-size: 24px; font-weight:bold; color:rgb(30, 155, 212)">Tax
                                        Invoice</div>
                                    <div>(original for Recipient)</div>
                                </td>
                            </tr>
                        </table>
                        <table style='width:100%;border-collapse: collapse; font-size: 14px;'>
                            <tr>
                                <td style='width:50%; text-align:left;'>
                                    <b style="font-size: 16px;">Bill To:</b><br />
                                    <div>{{ $deliveryAddress['contactPersonName'] }}<br>
                                        {{ $deliveryAddress['delivery_address'] }},
                                        {{ $deliveryAddress['city'] }},<br>
                                        {{ $deliveryAddress['stateName'] }}-{{ $deliveryAddress['pincode'] }}<br>
                                        Contact No: {{ $deliveryAddress['contactPersonMobile'] }}</div>
                                </td>
                                <td style='width:50%; text-align:right;'>
                                    <b style="font-size: 15px;">Invoice No : {{ $invoice_no }}</b><br>
                                    <p class="mb-1">Order Number : <b>{{ $order->order_no }}</b></p>
                                    <p class="mb-1">Order Date : <b>{{ $order->created_at->format('d-m-Y') }}</b></p>
                                </td>
                            </tr>
                        </table>
                        <table style='width:100%;border-collapse: collapse; font-size: 15px; margin-top: 20px;'>
                            <thead style='font-weight:600; text-align: center;'>
                                <tr style="background-color: rgb(59, 173, 220); color: #fff; height: 30px;">
                                    <th
                                        style="width: 150px; padding-left: 15px; border: solid 1px #dadada; border-right: 1px solid #dadada; text-align: left;">
                                        Item Name
                                    </th>
                                    <th
                                        style='padding: 2px; width: 50px; border: solid 1px #dadada;border-right:1px solid #dadada;'>
                                        HSN/SAC
                                    </th>
                                    <th
                                        style='width: 40px; padding: 2px; border: solid 1px #dadada;border-right:1px solid #dadada;'>
                                        Quantity
                                    </th>
                                    <th
                                        style='padding: 2px; width: 50px; border: solid 1px #dadada;border-right:1px solid #dadada;'>
                                        Price
                                    </th>
                                    <th
                                        style='padding: 2px; width: 50px; border: solid 1px #dadada;border-right:1px solid #dadada;'>
                                        SGST
                                    </th>
                                    <th
                                        style='padding: 2px; width: 50px; border: solid 1px #dadada;border-right:1px solid #dadada;'>
                                        CGST
                                    </th>
                                    <th
                                        style='width: 50px; padding: 2px; border: solid 1px #dadada;border-right:1px solid #dadada;'>
                                        Amount
                                    </th>

                                </tr>
                            </thead>
                            <tbody class='prnbody'>
                                @php
                                    $total_price = 0.0;
                                    $total_cgst = 0.0;
                                    $total_sgst = 0.0;
                                @endphp
                                @foreach ($orderDet as $item)
                                    <tr style='font-size: 15px; line-height: 18px;'>
                                        <td
                                            style='padding-left: 15px; width:70px; height: 40px; border-left: solid 1px #dadada; border-bottom: solid 1px #dadada;'>
                                            {{ $item->product_name }}
                                        </td>
                                        <td
                                            style='padding-left: 10px; height: 40px; text-align: center; border-left: solid 1px #dadada; border-bottom: solid 1px #dadada;'>
                                            {{ $item->hsn_sac_code }}
                                        </td>
                                        <td
                                            style='padding-left: 10px; height: 40px; text-align: center; border-left: solid 1px #dadada; border-bottom: solid 1px #dadada;'>
                                            {{ $item->qty }}
                                        </td>
                                        <td
                                            style='padding-left: 10px; height: 40px; text-align: center; border-left: solid 1px #dadada; border-bottom: solid 1px #dadada;'>
                                            <span
                                                style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($item->price) }}
                                        </td>
                                        <td
                                            style='padding-left: 10px; height: 40px; text-align: center; border-left: solid 1px #dadada; border-bottom: solid 1px #dadada;'>
                                            <span
                                                style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>@php $total_sgst += $item->sgst_amount @endphp
                                            {{ $item->sgst_amount }}
                                            <span style="font-size: 10px;">{{ '(' . $item->SGST . '%)' }}</span>
                                        </td>
                                        <td
                                            style='padding-left: 10px; height: 40px; text-align: center; border-left: solid 1px #dadada; border-bottom: solid 1px #dadada;'>
                                            <span
                                                style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>@php $total_cgst += $item->cgst_amount @endphp
                                            {{ $item->cgst_amount }}
                                            <span style="font-size: 10px;">{{ '(' . $item->CGST . '%)' }}</span>
                                        </td>
                                        <td
                                            style='padding-left: 10px; height: 40px; text-align: center; border-left: solid 1px #dadada; border-right: solid 1px #dadada; border-bottom: solid 1px #dadada;'>
                                            <span
                                                style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($item->price * $item->qty) }}
                                            @php $total_price += $item->price * $item->qty @endphp
                                        </td>
                                    </tr>
                                @endforeach
                                <tr style='font-size: 15px; line-height: 18px;'>
                                    <td
                                        style='padding-left: 15px; height: 40px; text-align: center; border-bottom: solid 1px #dadada; font-weight: bold;'>
                                        Total
                                    </td>
                                    <td
                                        style='padding-left: 15px; height: 40px; text-align: center; border-bottom: solid 1px #dadada; font-weight: bold;'>

                                    </td>
                                    <td
                                        style='padding-left: 15px; height: 40px; text-align: center; border-bottom: solid 1px #dadada; font-weight: bold;'>
                                        {{ $order->total_qty }}
                                    </td>
                                    <td
                                        style='padding-left: 15px; height: 40px; text-align: center; border-bottom: solid 1px #dadada; font-weight: bold;'>

                                    </td>
                                    <td
                                        style='padding-left: 15px; height: 40px; text-align: center; border-bottom: solid 1px #dadada; font-weight: bold;'>
                                        <span
                                            style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ $total_sgst }}
                                    </td>
                                    <td
                                        style='padding-left: 15px; height: 40px; text-align: center; border-bottom: solid 1px #dadada; font-weight: bold;'>
                                        <span
                                            style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ $total_cgst }}
                                    </td>
                                    <td
                                        style='padding-left: 15px; height: 40px; text-align: center; border-bottom: solid 1px #dadada; font-weight: bold;'>
                                        <span
                                            style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($total_price) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table style='width:100%;border-collapse: collapse; font-size: 14px;'>
                            <tr>
                                <td style='width:65%; vertical-align:top; padding-top:20px'>
                                    <b>Invoice Amounts in Words</b><br>
                                    <p>{{ $amount_in_words }}</p>
                                    <b>Terms and Condition</b>
                                    <p>Goods once sold will not return back.<br>
                                        Subject to our home jurisdiction
                                    </p>
                                </td>
                                <td style='width:35%;'>
                                    <table
                                        style='width:100%;border-collapse: collapse; font-size: 14px; text-align:right;line-height:18px;'>
                                        <tr>
                                            <td style='padding:5px 0 5px;'>
                                                Subtotal</td>
                                            <td><span
                                                    style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($total_price) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding:5px 0 5px;'>
                                                SGST</td>
                                            <td><span
                                                    style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ $total_sgst }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding:5px 0 5px;'>
                                                CGST</td>
                                            <td><span
                                                    style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ $total_cgst }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding:5px 0 5px;'>
                                                Delivery Charges</td>
                                            <td><span
                                                    style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($order->delivery_charge) }}
                                            </td>
                                        </tr>
                                        @if ($order->additional_delivery_charge > 0)
                                            <tr>
                                                <td style='padding:5px 0 5px;'>
                                                    Additional Delivery Charges</td>
                                                <td><span
                                                        style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($order->additional_delivery_charge) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($order->deposit_amount > 0)
                                            <tr>
                                                <td style='padding-top:5px;'>
                                                    New Can Deposit
                                                </td>
                                                <td style='padding-top:5px;'><span
                                                        style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($order->deposit_amount) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span
                                                        style="font-size: 11px; color: rgb(202, 191, 191);">(Refundable)</span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr style="font-weight:bold;">
                                            <td style='padding:5px 0 5px;'>
                                                Grand Total</td>
                                            <td>
                                                <span
                                                    style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($order->grand_total) }}
                                            </td>
                                        </tr>
                                        {{-- @if ($order->total_igst_amount > 0)
                                            <tr>
                                                <td
                                                    style='padding:5px 0 5px;'>
                                                    GST</td>
                                                <td><span
                                                        style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ round($order->total_igst_amount) }}
                                                </td>
                                            </tr>
                                        @endif --}}
                                        {{-- <tr>
                                            <td
                                                style='padding:5px 0 5px;'>
                                                GRAND TOTAL<br><span
                                                    style="font-size: 11px; color: rgb(202, 191, 191);">(Round
                                                    Off)</span></td>
                                            <td><span
                                                    style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ round($order->grand_total) }}
                                            </td>
                                        </tr> --}}
                                        @if ($order->wallet_points_used > 0)
                                            <tr>
                                                <td style='padding-top:5px;'>
                                                    Wallet Points Used
                                                </td>
                                                <td style='padding-top:5px;'><span
                                                        style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($order->wallet_points_used) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-size: 11px; color: rgb(202, 191, 191);">(-)</span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($order->total_discount_amount > 0)
                                            <tr>
                                                <td style='padding-top:5px;'>
                                                    Coupon Discount
                                                </td>
                                                <td style='padding-top:5px;'><span
                                                        style="font-family: 'DejaVu Sans', sans-serif;">&#8377;</span>{{ round($order->total_discount_amount) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-size: 11px; color: rgb(202, 191, 191);">(-)</span>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($order->transaction_amount > 0)
                                            <tr style="font-weight:bold;">
                                                <td style='padding:5px 0 5px;'>
                                                    Online Payment
                                                </td>
                                                <td>
                                                    <span
                                                        style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ round($order->transaction_amount) }}
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table style='width:100%;border-collapse: collapse; font-size: 14px; margin-top: 20px;'>
                            <tr style="text-align: right;">
                                <td>
                                    <p>For GLOBAL CREATORS</p>
                                    <b>Computer Generated Bill<br>
                                        Signature Not Required
                                    </b>
                                    <p>Authorized Signatory</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- water invoice --}}
    {{-- <div class="container"> --}}
    <!-- Invoice -->
    {{-- <div class="col-xl-12 col-md-12 col-12 mb-md-0 mb-4">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between m-sm-3 m-0">
                        <div class="col-md-2 col-5 mb-xl-0 mb-4">
                            <img src="{{asset($companyDetails->company_logo)}}" alt="logo" class="m-0"
                                width="300px">
                            <p class="mb-2">{{ $companyDetails->company_name }}</p>
                            <p class="mb-2">{{ $companyDetails->company_address }}</p>
                            <p class="mb-2">+91 {{ $companyDetails->company_contactno }}</p>
                            <p class="mb-2">{{ $companyDetails->company_email }}</p>
                        </div>
                        <div>
                            <h4 class="fw-semibold mb-2">INVOICE #{{ $order->invoice_no }}</h4>
                            <div class="mb-2 pt-1">
                                <span>Order Number:</span>
                                <span class="fw-semibold">{{ $order->order_no }}</span>
                            </div>
                            <div class="pt-1">
                                <span>Invoice Date:</span>
                                <span class="fw-semibold">{{ $order->created_at->format('d-m-Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row p-sm-3 p-0">
                        <div class="col-md-4 col-4 mb-4">
                            <h6 class="mb-3">Invoice To:</h6>
							<p class="mb-1">{{ $deliveryAddress[0]['delivery_address']}},{{ $deliveryAddress[0]['floor']}},{{ $deliveryAddress[0]['loction']}},{{ $deliveryAddress[0]['lat']}}</p>
                        </div> --}}
    {{-- <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                            <h6 class="mb-4">Bill To:</h6>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="pe-4">Total Due:</td>
                                        <td><strong>₹12,110.55</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">Bank name:</td>
                                        <td>American Bank</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">Country:</td>
                                        <td>United States</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">IBAN:</td>
                                        <td>ETD95476213874685</td>
                                    </tr>
                                    <tr>
                                        <td class="pe-4">SWIFT code:</td>
                                        <td>BR91905</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> --}}
    {{-- </div>
                </div>
                <div class="container">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th style="width: 300px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDet as $item)
                                    <tr>
                                        <td class="text-nowrap">{{ $item->product_name }}</td>
                                        <td>₹{{ round($item->price) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>₹{{ round($item->price * $item->qty) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong class="mb-2 pt-3">Subtotal</strong></td>
                                                    <td>
                                                        <p class="fw-semibold mb-2 pt-3 pl-3">
                                                            ₹{{ round($order->sub_total) }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong class="mb-2 pt-3">Delivery Charges</strong></td>
                                                    <td>
                                                        <p class="fw-semibold mb-2 pt-3">
                                                            ₹{{ round($order->delivery_charge) }}</p>
                                                    </td>
                                                </tr>
                                                @if ($order->deposit_amount > 0)
                                                    <tr>
                                                        <td><strong class="mb-2 pt-3">New Can Deposit<div
                                                                    class="text-muted">(Refundable)</div></strong> </td>
                                                        <td>
                                                            <p class="fw-semibold mb-2 pt-3">
                                                                ₹{{ round($order->deposit_amount) }}</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($order->wallet_points_used > 0)
                                                    <tr>
                                                        <td><strong class="mb-2 pt-3">Wallet Points Used</strong></td>
                                                        <td>
                                                            <p class="fw-semibold mb-2 pt-3">
                                                                ₹{{ round($order->wallet_points_used) }}</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><strong class="mb-2 pt-3">GST</strong></td>
                                                    <td>
                                                        <p class="fw-semibold mb-2 pt-3">
                                                            ₹{{ round($order->total_igst_amount) }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong class="mb-2 pt-3">TOTAL<div class="text-muted">(Round
                                                                Off)
                                                            </div></strong> </td>
                                                    <td>
                                                        <p class="fw-semibold mb-2 pt-3">
                                                            ₹{{ round($order->grand_total) }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-body mx-3">
                    <div class="row">
                        <div class="col-12">
                            <span class="fw-semibold">Note:</span>
                            <span>It was a pleasure working with you and your team. We hope you will keep us in mind for
                                future freelance projects. Thank You!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    <!-- /Invoice -->
    {{-- </div> --}}
</body>

</html>
