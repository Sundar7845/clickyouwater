$(document).ready(function () {
    $('#ddlCreditDebit').select2();
    $('#tblLedger').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: "ledger/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "ledger_code" },
            { data: "ledger_type" },
            { data: "ledger_name" },
            { data: "mobile" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                        <input onclick="doStatus(${row.id});" id="chkLedger${row.id}" type="checkbox" class="switch-input"
                        name="chkLedger" '  ${(data == 1 ? "checked" : "")} ' />
                        <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </span>
                    </label>`;
                }
            },
            { data: "action", orderable: false }
        ],
    });
});

function cancel() {
    $("#ddlLedgertype").val("").trigger("change");
    $("#txtLedgername").val("");
    $("#txtLedgerCode").val($("#hdLedgerCode").val());
    $("#txtmobile").val("");
    $("#ddlState").val("").trigger("change");
    $("#ddlCity").val("").trigger("change");
    $("#ddlArea").val("").trigger("change");
    $("#txtAddress").val("");
    $("#txtPincode").val("");
    $("#txtCreditPeriod").val("");
    $("#txtSettlemnt").val("");
    $("#txtopeningBalance").val("");
    $("#hdLedgerId").val("");
    $("#ddlCreditDebit").val("").trigger("change");
    $("#btnSave").text("Save");
    $("#heading").text("Add Ledger");
}

//jquery Validation
$(function () {
    $("form[name='ledger']").validate({
        rules: {
            txtLedgerCode: "required",
            ddlLedgertype: "required",
            txtLedgername: "required",
            txtmobile: "required",
            ddlState: "required",
            ddlCity: "required",
            ddlArea: "required",
            txtAddress: "required",
            txtPincode: "required",
            txtCreditPeriod: "required",
            txtSettlemnt: "required",
            txtopeningBalance: "required",
            ddlCreditDebit: "required",
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents(".form-group"));
            } else {
                // This is the default behavior
                // error.insertAfter(element);
                if (element.siblings(".error").html() == undefined) {
                    error.appendTo(element.parent().next(".error"));
                } else {
                    error.appendTo(element.siblings(".error"));
                }
            }
        },
    });

});

function doStatus(id) {
    var status = $("#chkLedger" + id).is(":checked");
    confirmStatusChange(id, "ledger/", "tblLedger", (status == true ? 1 : 0), "chkLedger");
}

function doEdit(id) {
    $("#hdLedgerId").val(id);
    $("#ddlLedgertype").focus();
    $("#btnSave").text("Update");
    $("#heading").text("Update Ledger");
    getLedgerById(id);
}

function getLedgerById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getledger/" + id,
        dataType: "json",
        success: function (data) {
            $("#txtLedgerCode").val(data.ledger.ledger_code);
            $("#ddlLedgertype").val(data.ledger.ledger_type_id).trigger('change');
            $("#txtLedgername").val(data.ledger.ledger_name);
            $("#txtmobile").val(data.ledger.mobile);
            $("#ddlState").val(data.ledger.state_id).trigger('change');
            setTimeout(function () {
                $("#ddlCity").val(data.ledger.city_id).trigger("change");
            }, 1500);
            setTimeout(function () {
                $("#ddlArea").val(data.ledger.area_id).trigger("change");
            }, 2000);
            $("#txtAddress").val(data.ledger.street);
            $("#txtPincode").val(data.ledger.pincode);
            $("#txtCreditPeriod").val(data.ledger.credit_period);
            $("#txtopeningBalance").val(data.ledger.opening_balance);
            $("#ddlCreditDebit").val(data.ledger.credit_debit).trigger("change");
            $("#txtSettlemnt").val(data.ledger.settlement_period);
            $("#pageloader").fadeOut();
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "delete/ledger/", "tblLedger");
}