<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class StatusTypes extends Enum
{
    const Success = "1";
    const Failed = "2";
    const Pending = "3";
    const Approved = "4";
    const Rejected = "5";
    const Accepted = "6";
    const Onprocess = "7";
    const Cancelled = "8";
    const PaymentInitiated = "9";
    const SignatureMismatch = "10";
    const InvoiceDownloaded = "11";
    const TransactionFailed = "12";
    const RefundInitiated = "13";
    const RefundProcessed = "14";
    const OrderPlaced = "15";
    const OrderShipped = "16";
    const OrderDelivered = "17";
    const OrderCompleted = "18";
    const AssignedToDelivery = "19";
    const OrderNotDelivered = "20";
    const OrderMovedToAdmin = "21";
    const OrderCancelledByAdmin = "22";
    const AssignedToHub = "23";
    const RefundRequested = "24";
    const SurrenderRequested = "25";
    const SurrenderApproved = "26";
    const SurrenderRejected = "27";
    const SurrenderCanCollected = "28";
    const SurrenderRequestCancelled = "29";
    const LogisticBooked = "30";
    const ManufactureDelivered = "31";
    const LogisticReceivedfromManufacture = "32";
    const AssignedForPickup = "33";
    const LogisticBookingCancelled = "34";
    const HubCollected = "35";
    const LogisticReceivedfromHub = "36";
}
