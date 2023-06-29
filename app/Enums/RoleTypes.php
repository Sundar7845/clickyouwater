<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

final class RoleTypes extends Enum
{
    const SuperAdmin = "1";
    const Admin = "2";
    const Manufacturer = "3";
    const Hub = "4";
    const LogisticPartner = "5";
    const DeliveryPerson = "6";
    const RegionalManager = "7";
    const AreaManager = "8";
    const SalesHead = "9";
    const FinanceHead = "10";
    const AccountsHead = "11";
    const Accounts = "12";
    const ManufacturerIncharge = "13";
    const HubIncharge = "14";
    const LogisticsIncharge = "15";
    const BackOfficeSupport = "16";
    const Customer = "17";
    const Driver = "18";
}
