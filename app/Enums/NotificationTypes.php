<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class NotificationTypes extends Enum
{
    const OrderPlaced = "1";
    const PaymentSuccess = "2";
    const PaymentFailed = "3";
    const WholesaleCustomerApproved = "4";
    const WholesaleCustomerRejected = "5";
    const InvoiceDownloaded = "6";
    const OrderCancelled = "7";
    const OrderShipped = "8";
    const OrderDelivered = "9";
    const WalletPending = "10";
    const WalletSuccess = "11";
    const WalletFailed = "12";
    const Referral = "13";
    const Used = "14";
    const Offers = "15";
    const OrderNotDelivered = "16";
    const RefundRequested = "17";
    const SurrenderRequested = "18";
    const SurrenderApproved = "19";
    const SurrenderRejected = "20";
    const SurrenderCanCollected = "21";
    const SurrenderRequestCancelled = "22";
    const LogisticBooked = "23";
    const ManufactureDelivered = "24";
    const LogisticReceivedfromManufacture = "25";
    const OrderAssigned = "26";
    const OrderAcceptedByDP = "27";
    const OrderRejectedByDP = "28";
    const RefundRequestApproved = "29";
    const HubOrderPlaced = "30";
    const HubOrderCancelledByCustomer = "31";
    const HubOrderCancelledByAdmin = "32";
    const HubOrderAcceptedByDP = "33";
    const HubOrderRejectedByDP = "34";
    const HubOrderDelivered = "35";
    const HubOrderCouldNotDelivered = "36";
    const HubSurrenderApproved = "37";
}
