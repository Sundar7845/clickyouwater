var RowIndex = 1;
var now = new Date();
var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);
var today = now.getFullYear() + "-" + month + "-" + day;

$(document).ready(function () {
    //Change Payment Mode
    paymentMode();

    //payment for dropdown
    $("#ddlPaymentFor").bind("change", function () {
        $("#pageloader").fadeIn();
        paymentFor();
    });

    $("#ddlLedgerName").on("change", function () {
        //vendor data
        vendorData();
    });

    $("#ddlEmployeeName").on("change", function () {
        //employee data
        employeeData();
    });

    //checkout
    checkAmount();

    $("#ddlCompanyLedger").on("change", function () {
        //company balance info
        loadCompanyBalanceInfo($("#ddlCompanyLedger").val());
    });

    // CLEARING ERRORS
    $("#ddlPaymentMode").bind("change", () => {
        $("#spanPaymentFor").text("");
    });

    $("#ddlBankName").bind("change", () => {
        $("#spanBankName").text("");
    });

    $("#ddlLedgerName").bind("change", () => {
        $("#spanLedger1Name").text("");
    });

    $("#ddlEmployee").bind("change", () => {
        $("#spanLedger3Name").text("");
    });

    $("#txtChequeNo").bind("keyup", () => {
        $("#spanChequeNo").text("");
    });

    $("#txtDDNo").bind("keyup", () => {
        $("#spanDDNo").text("");
    });

    $("#txtBranchName").bind("keyup", () => {
        $("#spanBranchName").text("");
    });

    $("#txtRemarks").bind("keyup", () => {
        $("#spanRemarks").text("");
    });

    $("#txtAmount").bind("keyup", () => {
        $("#spanAmt").text("");
    });

    $("#txtAmount").bind("keyup", () => {
        checkAmount();
    });

    $("#ddlPaymentFor").bind("change", function () {
        changePaymentType();
    });

    $("#ddlLedgerName").bind("change", function () {
        validate_LedgerID();
    });

    $("#tableHeadCheck").on("change", () => {
        doCheckAll();
    });
});

function validate_LedgerID() {
    if ($("#ddlLedgerName").val() != 0) {
        if ($("#ddlPaymentFor").val() == 0) {
            $("#ddlLedgerName").val("0").trigger("change");
            $("#spanPaymentFor").text("Please select any one value");
            return false;
        }
    }
}

// VALIDATION:::
function validateForm() {
    var ddlVendorName = $("#ddlLedgerName");
    var Employee = $("#ddlEmployeeName");
    var LedgerName = $("#ddlCompanyLedger");

    var ddlPaymentFor = $("#ddlPaymentFor");
    if (ddlPaymentFor.val() == 0) {
        $("#spanPaymentFor").text("Select Type");
        ddlPaymentFor.focus();
        return false;
    }

    if (
        ddlVendorName.val() == 0 &&
        Employee.val() == 0 &&
        LedgerName.val() == 0
    ) {
        $("#spanLedgerName").text("Select Ledger Name");
        $("#spanEmployeeName").text("Select Employee Name");
        $("#spanCompanyLedgerName").text("Select Ledger Name");
        ddlVendorName.focus();
        return false;
    }
    var ddlCompanyLedger = $("#ddlCompanyLedger");
    if (ddlCompanyLedger.val() == 0) {
        $("#spanCompanyLedger").text("Select Company Ledger");
        ddlCompanyLedger.focus();
        return false;
    }

    var closingAmt = $("#ddlCompanyLedger option:selected").attr("closingAmt");
    if (Number($("#tdtotAmt").val()) > Number(closingAmt)) {
        $("#spanCompanyLedger").text("Low balance in Company ledger");
        ddlCompanyLedger.focus();
        return false;
    }

    var txtAmount = $("#txtAmount");
    if (txtAmount.val() == 0) {
        $("#spanAmt").text("Enter Amount");
        txtAmount.focus();
        return false;
    }

    txtRemarks = $("#txtRemarks");
    if (txtRemarks.val() == 0) {
        $("#spanRemarks").text("Enter Remarks");
        txtRemarks.focus();
        return false;
    }

    // CHEQUE VALIDATION
    var ddlPaymentMode = $("#ddlPaymentMode");
    if (ddlPaymentMode.val() == 2) {
        var ddlBankName = $("#ddlBankName");
        if (ddlBankName.val() == 0) {
            $("#spanBankName").text("Select Bank Name");
            ddlBankName.focus();
            return false;
        }
        var txtChequeNo = $("#txtChequeNo");
        if (txtChequeNo.val() == "") {
            $("#spanChequeNo").text("Enter Cheque No");
            txtChequeNo.focus();
            return false;
        }
        var txtBranchName = $("#txtBranchName");
        if (txtBranchName.val() == "") {
            $("#spanBranchName").text("Enter Branch Name");
            txtBranchName.focus();
            return false;
        }
    }

    // DD VALIDATION
    if (Number(ddlPaymentMode.val()) == 3) {
        var ddlBankName = $("#ddlBankName");
        if (ddlBankName.val() == 0) {
            $("#spanBankName").text("Select Bank Name");
            ddlBankName.focus();
            return false;
        }
        var txtDDNo = $("#txtDDNo");
        if (txtDDNo.val() == 0) {
            $("#spanDDDate").text("Select DD No");
            txtDDNo.focus();
            return false;
        }
    }

    if (
        Number(ddlPaymentMode.val()) == 4 ||
        Number(ddlPaymentMode.val()) == 5
    ) {
        var ddlBankName = $("#ddlBankName");
        if (ddlBankName.val() == 0) {
            $("#spanBankName").text("Select Bank Name");
            ddlBankName.focus();
            return false;
        }
        var txtDDNo = $("#txtChequeNo");
        if (txtDDNo.val() == 0) {
            $("#spanTransNo").text("Enter Transaction No");
            txtDDNo.focus();
            return false;
        }
    }
    pushTableData();
}

function pushTableData() {
    var TableRowData = [];
    $("#tbodyRow tr").each(function (index, value) {
        (id = $(this).find(":checkbox:checked")), console.log(id, "===idd===");

        TableRowData.push({
            expenseId: $(this).find("td:eq(2)").attr("expenseId"),
            amount:
                $(this).find("td:eq(7)").text() == ""
                    ? 0
                    : $(this).find("td:eq(7)").text(),
        });
    });

    $("#hiddenPaymentDet").val(JSON.stringify(TableRowData));
}

function doCheckAll() {
    checkAmount();

    let checkBox = $("#tableHeadCheck");
    if (checkBox.prop("checked")) {
        $(".allCheckCls").prop("checked", true);
        // return false
    } else {
        $(".allCheckCls").prop("checked", false);
        // return false;
    }
}

// CLEARING FIELD INPUT FUNC:::
function clearInput() {
    $("#ddlLedgerName").val(0).trigger("change");
    $("#ddlLedgerName").val(0).trigger("change");
    $("#ddlCompanyLedger").val(0).trigger("change");
    $("#ddlEmployeeName").val(0).trigger("change");
    $("#ddlPaymentFor").val(0).trigger("change");
    $("#ddlBankName").val(0).trigger("change");
    $("#ddlPaymentMode").val(1).trigger("change");
    $("#ddlPaymentDate").val(today);
    $("#txtChequeNo").val("");
    $("#txtDDNo").val("");
    $("#txtBranchName").val("");
    $("#txtAmount").val("");
    $("#txtRemarks").val("");
    $("#vendorClosingbalance").text("0.00");
    $("#companyClosingBalance").text("0.00");
    $("#employeeClosingBalance").text("0.00");
}

function paymentMode() {
    //Change Payment Mode
    $("#ddlPaymentMode").bind("change", function () {
        $(".CHQ").css("display", "none");
        $("#txtChequeNo").val("");
        $("#ddlBankName").val("0");

        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + month + "-" + day;

        $("#txtTransDate").val(today);

        switch ($("#ddlPaymentMode").find("option:selected").val()) {
            case "1":
                $(".CHQ").css("display", "none");
                break;
            case "2":
                $(".CHQ").css("display", "block");
                $("#lblTransDt").text("Cheque Date");
                $("#lblTransNo").text("Cheque No");
                $("#lblBranchName").css("display", "block");
                $("#txtBranchName").css("display", "block");
                break;
            case "3":
                $(".CHQ").css("display", "block");
                $("#lblTransDt").text("DD Date");
                $("#lblTransNo").text("DD No");
                $("#lblBranchName").css("display", "none");
                $("#txtBranchName").css("display", "none");
                break;
            case "4":
                $(".CHQ").css("display", "block");
                $("#lblTransDt").text("Transaction Date");
                $("#lblTransNo").text("Transaction No");
                $("#lblBranchName").css("display", "none");
                $("#txtBranchName").css("display", "none");
                break;
            case "5":
                $(".CHQ").css("display", "block");
                $("#lblTransDt").text("UPI Transaction Date");
                $("#lblTransNo").text("UPI Reference No");
                $("#lblBranchName").css("display", "none");
                $("#txtBranchName").css("display", "none");
                break;
            case "6":
                $(".CHQ").css("display", "block");
                $("#lblTransDt").text("Transaction Date");
                $("#lblTransNo").text("Transaction No");
                $("#lblBranchName").css("display", "none");
                $("#txtBranchName").css("display", "none");
                break;
            case "7":
                $(".CHQ").css("display", "block");
                $("#lblTransDt").text("Transaction Date");
                $("#lblTransNo").text("Transaction No");
                $("#lblBranchName").css("display", "none");
                $("#txtBranchName").css("display", "none");
                break;
        }
    });

    $("#chkIsPaid").click(function () {
        if (!$(this).is(":checked")) {
            $("#lblIsPaid").text("Not Paid");
            $("#divCLedger").hide();
        } else {
            $("#lblIsPaid").text("Paid");
            $("#divCLedger").show();
        }
    });
}

function paymentFor() {
    var paymenttype = $("#ddlPaymentFor").val();
    if (paymenttype == 1) {
        $("#divEmployee").css({ display: "none" });
        $("#divLedger").css({ display: "block" });
        loadGeneralExpenseData();
    }
    if (paymenttype == 2) {
        $("#divLedger").css({ display: "none" });
        $("#divEmployee").css({ display: "block" });
        loadEmployeeExpenseData();
    }
}

function loadGeneralExpenseData() {
    var ledger_type_id = 2;
    $.ajax({
        url: "/get/genaralexpense",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            ledger_type_id: ledger_type_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#ddlLedgerName").html(
                '<option value="0">Select Ledger Name</option>'
            );
            $.each(result.generalExpenseData, function (key, val) {
                $("#ddlLedgerName").append(
                    '<option value="' +
                    val.id +
                    '">' +
                    val.ledger_name +
                    "</option>"
                );
            });
            $("#pageloader").fadeOut();
        },
        error: function (result) {
            $("#pageloader").fadeOut();
        }
    });
}

function loadEmployeeExpenseData() {
    $.ajax({
        url: "/get/genaralexpense",
        type: "GET",
        dataType: "json",
        success: function (result) {
            $("#ddlEmployeeName").html(
                '<option value="0">Select Employee</option>'
            );
            $.each(result.employeeExpenseData, function (key, val) {
                $("#ddlEmployeeName").append(
                    '<option value="' +
                    val.id +
                    '">' +
                    val.display_name +
                    "</option>"
                );
            });

            $("#pageloader").fadeOut();
        },
        error: function (result) {
            $("#pageloader").fadeOut();
        }
    });
}

function loadCompanyBalanceInfo(ledger_id) {
    $("#pageloader").fadeIn();
    $.ajax({
        url: "/get/balanceinfo",
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
            $("#companyClosingBalance").text(
                result.companyLedgerBalanceInfo
                    ? result.companyLedgerBalanceInfo.closing_balance.toFixed(
                        2
                    )
                    : "0.00"
            );
            $("#hdCompanyClosingBalance").val(
                result.companyLedgerBalanceInfo
                    ? result.companyLedgerBalanceInfo.closing_balance.toFixed(
                        2
                    )
                    : "0.00"
            );
            $("#pageloader").fadeOut();
        },
        error: function (result) {
            $("#pageloader").fadeOut();
        }
    });
}

function checkedtotal() {
    setTimeout(() => {
        totalTableAmount();
        totalTableBillAmount();
    }, 1000);
}

function totalTableAmount() {
    var amt = 0;
    $("#tblPaymentID tr").each(function (index, val) {
        if ($(this).find("td:eq(0) input").prop("checked")) {
            amt += Number(
                isNaN($(this).find("td:eq(5)").text())
                    ? 0
                    : $(this).find("td:eq(5)").text()
            );
        }
    });
    $("#tdtotalAmt").html("<span>₹</span>" + amt.toFixed(2));
}

function totalTableBillAmount() {
    var amt = 0;
    $("#tblPaymentID tr").each(function (index, val) {
        if ($(this).find("td:eq(0) input").prop("checked")) {
            amt += Number(
                isNaN($(this).find("td:eq(6)").text())
                    ? 0
                    : $(this).find("td:eq(6)").text()
            );
        }
    });
    $("#tdBillAmt").html("<span>₹</span>" + amt.toFixed(2));
    $("#tdBillAmt").val(amt);
}

function totalAmt() {
    var amt = 0;
    $("#tblPaymentID tr").each(function (index, val) {
        amt += Number(
            isNaN($(this).find("td:eq(7)").text())
                ? 0
                : $(this).find("td:eq(7)").text()
        );
    });
    $("#tdtotAmt").html("<span>₹</span>" + amt.toFixed(2));
    $("#tdtotAmt").val(amt);
}

function addDetailsToTable(expenseId, billNo, billDate, desc, amt, balAmt) {
    var Row = "";
    Row += "<tr id='tr" + RowIndex + "' >";
    Row += "<td align='center'>";
    Row +=
        "<input type='checkbox' id='checkPer_" +
        RowIndex +
        "'class='form-check-input allCheckCls' checked onchange='return checkedtotal();'/>";
    Row += "</td>";
    Row += "<td align='center'>" + ($("#tbodyRow tr").length + 1) + "</td>";
    Row += "<td align='left' expenseId='" + expenseId + "'>" + billNo + "</td>";
    Row += "<td align='left'>" + billDate + "</td>";
    Row += desc;
    Row += "<td align='left' class='text-center'>" + amt + "</td>";
    Row +=
        "<td id='amt_" +
        RowIndex +
        "' class='text-center'>" +
        parseFloat(balAmt).toFixed(2) +
        "</td>";
    Row += "<td id='tdEnterAmt" + RowIndex + "' class='text-center'></td>";
    Row += "</tr>";

    $("#tbodyRow").append(Row);
    RowIndex++;
    // Item_arr.push(String(Item_id))
}

function vendorData() {
    $("#pageloader").fadeIn();
    var billNo = 0;
    var billDate = 0;
    var desc = 0;
    var amt = 0;
    var balAmt = 0;

    var vendor_id = $("#ddlLedgerName").val();
    $.ajax({
        url: "/get/pendingbills",
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
            $("#tdBillAmt").html("<span>₹</span> 0.00");
            if (result.vendorPendingBills.length != 0) {
                var totalBalAmt = 0;
                console.log(result.vendorPendingBills);
                $("[id^='trNoRecord']").remove();
                $("[id^='tr']").remove();
                $.each(result.vendorPendingBills, function (key, val) {
                    billNo = "-";
                    billDate = val.expense_date;
                    desc =
                        "<td align='center'> <p class='text-white badge bg-warning'>General Expense</p></td>";
                    amt = val.amount_paid;
                    balAmt = val.amount - val.amount_paid;
                    vendorid = val.id;

                    addDetailsToTable(
                        vendorid,
                        billNo,
                        billDate,
                        desc,
                        amt,
                        balAmt
                    );
                    totalBalAmt += balAmt;
                    $("#vendorClosingbalance").text(totalBalAmt.toFixed(2));
                });

                //Bind total values for pending bills
                totalTableAmount();
                totalTableBillAmount();
                totalAmt();
            } else {
                $("#vendorClosingbalance").text("0.00");
                $("#tbodyRow").html(`<tr id="trNoRecord" val="1">
                        <td colspan="8" class="text-muted text-center">No Records Added</td>
                    </tr>`);
            }

            $("#pageloader").fadeOut();
        },
        error: function (result) {
            $("#pageloader").fadeOut();
        }
    });
}

function employeeData() {
    var billNo = 0;
    var billDate = 0;
    var desc = 0;
    var amt = 0;
    var balAmt = 0;
    var employee_id = $("#ddlEmployeeName").val();
    $.ajax({
        url: "/get/pendingbills",
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
            if (result.employeePendingBills.length != 0) {
                $("[id^='trNoRecord']").remove();
                $("[id^='tr']").remove();
                var totalEmpBalAmt = 0;
                $.each(result.employeePendingBills, function (key, val) {
                    billNo = "-";
                    billDate = val.expense_date;
                    desc =
                        "<td align='center'> <p class='text-white badge bg-primary'>Employee Expense</p></td>";
                    amt = val.amount_paid;
                    balAmt = val.amount - val.amount_paid;
                    employeeId = val.id;

                    addDetailsToTable(
                        employeeId,
                        billNo,
                        billDate,
                        desc,
                        amt,
                        balAmt
                    );
                    totalEmpBalAmt += balAmt;
                    $("#employeeClosingBalance").text(
                        employee_id != 0 ? totalEmpBalAmt.toFixed(2) : "0.00"
                    );
                });
                //Bind total values for pending bills
                totalTableAmount();
                totalTableBillAmount();
                totalAmt();
            } else {
                $("#employeeClosingBalance").text("0.00");
                $("#tbodyRow").html(`<tr id="trNoRecord" val="1">
                        <td colspan="8" class="text-muted text-center">No Records Added</td>
                    </tr>`);
            }

            $("#pageloader").fadeOut();
        },
        error: function (result) {
            $("#pageloader").fadeOut();
        }
    });
}

function checkAmount() {
    if (Number($('#txtAmount').val()) > Number($('#tdBillAmt').val())) {
        showmsg('There is no pending bills')
        $("[id^='tdEnterAmt']").text('0.00');
        $('#txtAmount').val('')
        $('#tdtotAmt').html('0.00')
    }
    else {

        var amt = 0;
        var Amount = $("#txtAmount").val() == "" ? "0" : $("#txtAmount").val();
        amt = Amount;

        $("#tbodyRow tr").each(function () {
            if ($(this).find("td:eq(0) input").prop("checked")) {
                if (parseFloat($(this).find("td:eq(6)").text()) > amt) {
                    $(this).find("td:eq(7)").text(amt);
                    amt -= amt;

                    setTimeout(() => {
                        totalAmt();
                    }, 700);
                } else {
                    $(this)
                        .find("td:eq(7)")
                        .text($(this).find("td:eq(6)").text());
                    amt -= parseFloat($(this).find("td:eq(6)").text());

                    setTimeout(() => {
                        totalAmt();
                    }, 700);
                }
            } else {
                $(this).find("td:eq(7)").text("");
            }
        });
    }
}

function changePaymentType() {
    var paymenttype = $("#ddlPaymentFor").val();
    if (paymenttype == 0) {
        $("#divVendor").css({ display: "block" });
        $("#divEmployee").css({ display: "none" });
        $("#txtAmount").val("");
        $("#spanPaymentFor").text("");
        $("#tdtotAmt").val("0.00");
        $("#ddlEmployee").val("0").trigger("change");
        $("#tbodyRow").html(`<tr id="trNoRecord" val="1">
        <td colspan="8" class="text-muted text-center">No Records Added</td>
    </tr>`);
    }
    if (paymenttype == 1) {
        $("#divVendor").css({ display: "block" });
        $("#divEmployee").css({ display: "none" });
        $("#txtAmount").val("");
        $("#spanPaymentFor").text("");
        $("#tdtotAmt").val("0.00");
        $("#ddlEmployee").val("0").trigger("change");
        $("#tbodyRow").html(`<tr id="trNoRecord" val="1">
        <td colspan="8" class="text-muted text-center">No Records Added</td>
    </tr>`);
    }
    if (paymenttype == 2) {
        $("#divVendor").css({ display: "none" });
        $("#divEmployee").css({ display: "block" });
        $("#txtAmount").val("");
        $("#spanPaymentFor").text("");
        $("#tdtotAmt").val("0.00");
        $("#ddlEmployee").val("0").trigger("change");
        $("#tbodyRow").html(`<tr id="trNoRecord" val="1">
        <td colspan="8" class="text-muted text-center">No Records Added</td>
    </tr>`);
    }
}

function showmsg(msg, type) {
    toastr.options.timeOut = 3000;
    toastr.options.positionClass = "toast-top-right";
    toastr.error(msg);
}
