var now = new Date();
var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);
var today = now.getFullYear() + "-" + month + "-" + day;

$(document).ready(function () {
    $("#txtAmount").bind("keyup", function () {
        //check Ledger Amount
        if ($("#isPaid").val() > 0) {
            checkLedgerAmount();
        }
    });

    //today's date
    $("#ddlDate").val(today);

    //  define checkbox value
    if ($("#txtCheckBox").is(":checked")) {
        $(this).val(1);
        $("#isPaid").val(1);
    }
    else {
        $(this).val(0);
        $("#isPaid").val(0);
    }

    //  define radio value
    if ($("#radioGenral").is(":checked")) {
        $(this).val(1);
        $("#txtExpenseType").val(1);
    }

    // checkbox
    $("#txtCheckBox").bind("click", function () {
        onChecked();
    });

    $("#txtNotPay").bind("click", function () {
        onCheckedNotpay();
    });
    //

    // radio
    $("#radioGenral").bind("change", function () {
        radioGenral();
    });

    $("#radioEmployee").bind("change", function () {
        radioEmployee();
    });

    //  onclick clear
    $("#btnClear").bind("click", function () {
        clearData();
    });

    //  onclick validate and submit
    $("#btnSave").bind("click", function () {
        ValidateForm();
    });

    $("#txtExpenseDetail").bind("click", () => {
        $("#emptydetail").text("");
    });

    $("#txtAmount").bind("click", () => {
        $("#emptyamount").text("");
    });

    $("#ddlExpenseGroup").bind("change", () => {
        $("#emptygrp").text("");
    });

    $("#ddlExpenselVendor").bind("change", () => {
        $("#emptyvenledger").text("");
        //vendor balance info
        loadVendorBalanceInfo();
    });

    $("#ddlExpenselCompany").bind("change", () => {
        $("#emptycompany").text("");
        $("#txtAmount").val("");
        //company balance info
        loadCompanyBalanceInfo();
    });

    $("#ddlExpenselEmployee").bind("change", () => {
        $("#emptyemployeeId").text("");
        //employee balance info
        loadEmployeeBalanceInfo();
    });
});

// checbox Check
function onChecked() {
    $("#txtCheckBox").removeAttr("checked");
    if ($("#txtCheckBox").prop("checked", true)) {
        $(this).val(0);
        $("#isPaid").val(0);
        $("#ddlExpenselCompany").val("0").trigger("change");
        $("#PayNowdiv").css({ display: "none" });
        $("#NotPaydiv").css({ display: "block" });
    }
}

function onCheckedNotpay() {
    $("#hdClosinglCompany").val(0);
    $("#txtAmount").val("");
    if ($("#txtNotPay").prop("checked", false)) {
        $(this).val(1);
        $("#isPaid").val(1);

        $("#PayNowdiv").css({ display: "block" });
        $("#NotPaydiv").css({ display: "none" });
    }
}
// clear form
function clearData() {
    $("#ddlExpenselCompany").val("").trigger("change");
    $("#closinglcompany").text("0.00");
    $("#ddlExpenselVendor").val("").trigger("change");
    $("#ddlExpenselEmployee").val("").trigger("change");
    $("#closinglvendor").text("0.00");
    $("#ddlExpenseGroup").val("").trigger("change");
    $("#txtExpenseDetail ").val("");
    $("#txtAmount ").val("");
    $("#txtfileattachment ").val("");
    $("#ddlDate").val(moment(today).format("DD/MM/YYYY"));
}

//  Validate form
function ValidateForm() {
    var cLedger = $("#ddlExpenselCompany option:selected").val();
    var vLedger = $("#ddlExpenselVendor option:selected").val();
    var emp = $("#ddlExpenselEmployee option:selected").val();
    var expGrp = $("#ddlExpenseGroup option:selected").val();
    var expDetail = $("#txtExpenseDetail ").val();
    var amt = $("#txtAmount").val();
    var isPaid = $("#isPaid").val();

    if (expDetail == "") {
        $("#emptydetail").text("Please fill out this field!");
        $("#txtExpenseDetail").focus();
        return false;
    }
    if (vLedger == 0 && emp == 0) {
        $("#emptyvenledger").text("Please fill out this field!");
        $("#emptyemployeeId").text("Please fill out this field!");

        // $("#ddlExpenselVendor").focus();
        return false;
    }
    if (amt == "") {
        $("#emptyamount").text("Please fill out this field!");
        $("#txtAmount").focus();
        return false;
    }
    if (expGrp == 0) {
        $("#emptygrp").text("Please fill out this field!");
        $("#ddlExpenseGroup").focus();
        return false;
    }
    if (isPaid == 1 && cLedger == 0) {
        $("#emptycompany").text("Please fill out this field!");
        $("#ddlExpenselCompany").focus();
        return false;
    } else {
        $("#expensesubmit").submit();
    }
}

function radioGenral() {
    $("#empDiv").css({ display: "none" });
    $("#ledDiv").css({ display: "block" });
    $("#empFile").css({ display: "none" });
    $("#txtExpenseType").val(1);
    $("#ddlExpenselEmployee").val("0").trigger("change");
    $("#emptyvenledger").text("");
    $("#emptyemployeeId").text("");
}

function radioEmployee() {
    $("#ledDiv").css({ display: "none" });
    $("#empDiv").css({ display: "block" });
    $("#empFile").css({ display: "block" });

    $("#ddlExpenselVendor").val("0").trigger("change");
    $("#txtExpenseType").val(2);
    $("#emptyvenledger").text("");
    $("#emptyemployeeId").text("");
}

function loadCompanyBalanceInfo() {
    $("#pageloader").fadeIn();
    var ledger_id = $("#ddlExpenselCompany").val();
    $.ajax({
        url: "/get/ledgerbalanceinfo",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            ledger_id: ledger_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#closinglCompany").text(
                result.companyLedgerBalanceInfo ?
                    result.companyLedgerBalanceInfo.closing_balance.toFixed(2) :
                    "0.00"
            );
            $("#hdClosinglCompany").val(
                result.companyLedgerBalanceInfo ?
                    result.companyLedgerBalanceInfo.closing_balance.toFixed(2) :
                    "0.00"
            );
            $("#pageloader").fadeOut();
        },
    });
}

function loadEmployeeBalanceInfo() {
    $("#pageloader").fadeIn();
    var employee_id = $("#ddlExpenselEmployee").val();
    $.ajax({
        url: "/get/ledgerbalanceinfo",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            employee_id: employee_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#pendingemployee").text(
                result.employeeLeger ?
                    result.employeeLeger.closing_balance.toFixed(2) :
                    "0.00"
            );
            $("#hdPendingEmployee").val(
                result.employeeLeger ?
                    result.employeeLeger.closing_balance.toFixed(2) :
                    "0.00"
            );
            $("#pageloader").fadeOut();
        },
    });
}

function loadVendorBalanceInfo() {
    $("#pageloader").fadeIn();
    var vendor_id = $("#ddlExpenselVendor").val();
    $.ajax({
        url: "/get/ledgerbalanceinfo",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            vendor_id: vendor_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#closinglVendor").text(
                result.vendorLedgerBalanceInfo ?
                    result.vendorLedgerBalanceInfo.closing_balance.toFixed(2) :
                    "0.00"
            );
            $("#hdclosinglVendor").val(
                result.vendorLedgerBalanceInfo ?
                    result.vendorLedgerBalanceInfo.closing_balance.toFixed(2) :
                    "0.00"
            );
            $("#pageloader").fadeOut();
        },
    });
}

function checkLedgerAmount() {
    if (Number($("#txtAmount").val()) > Number($("#hdClosinglCompany").val())) {
        showmsg("payment exceeds closing balance amount");
        $("#txtAmount").val("");
    }
}

function showmsg(msg, type) {
    toastr.options.timeOut = 3000;
    toastr.options.positionClass = "toast-top-right";
    toastr.error(msg);
}