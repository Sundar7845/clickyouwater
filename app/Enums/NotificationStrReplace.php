<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class NotificationStrReplace extends Enum
{
    const OrderPlaced = "{{orderno}}";
    const PaymentSuccess = "{{invoiceno}}";
    const PaymentFailed = "{{invoiceno}}";
    const WholesaleCustomerApproved = "{{orderno}}";
    const WholesaleCustomerRejected = "{{orderno}}";
    const InvoiceDownloaded = "{{invoiceno}}";
    const OrderCancelled = "{{orderno}}";
    const OrderDelivered = "{{orderno}}";
    const OrderShipped = "{{orderno}}";
    const WalletPending = "{{walletno}}";
    const WalletSuccess = "{{walletno}}";
    const WalletFailed = "{{walletno}}";
    const Referral = "{{walletno}}";
    const Used = "{{walletno}}";
    const Offers = "{{walletno}}";
    const OrderNotDelivered = "{{orderno}}";
    const RefundRequested = "";
    const SurrenderRequested = "";
    const SurrenderApproved = "";
    const SurrenderRejected = "";
    const SurrenderCanCollected = "";
    const SurrenderRequestCancelled = "";
    const LogisticBooked = "";
    const ManufactureDelivered = "";
    const LogisticReceivedfromManufacture = "";
}
