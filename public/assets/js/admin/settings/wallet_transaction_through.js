$(document).ready(function () {
    $("#tblWalletTransactionThrough").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: "wallet_transaction_thourgh_data/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "wallet_transaction_type" },
            { data: "msg_format" },
            { data: "action", orderable: false },
        ],
    });
});

function doEdit(id) {
    $("#hdWalletTransactionTypeId").val(id);
    $("#ddlwalletTransactionType").focus();
    $("#btnSave").text("Update");
    getWalletTransactionThroughById(id);
}

function getWalletTransactionThroughById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getwallettransactionthrough/" + id,
        dataType: "json",
        success: function (data) {
            $("#ddlwalletTransactionType").val(data.walletTransactionThrough.wallet_transaction_type_id).trigger("change");
            $("#txtMessageFormat").val(data.walletTransactionThrough.msg_format);
            $("#pageloader").fadeOut();
        },
    });
}

function cancel() {
    $("#hdWalletTransactionTypeId").val("");
    $("#ddlwalletTransactionType").val("").trigger("change");
    $("#txtMessageFormat").val("");
    $("#btnSave").text("Save");
    $("#ddlwalletTransactionType").focus();
}

function showDelete(id) {
    confirmDelete(id, "delete/wallettransactionthrough/", "tblWalletTransactionThrough");
}

//jquery Validation
$(function () {
    $("#walletTransactionType").validate({
        rules: {
            ddlwalletTransactionType: "required",
            txtMessageFormat: "required",
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
