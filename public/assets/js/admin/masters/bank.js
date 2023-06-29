$(document).ready(function () {
    $("#tblBankList").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: "bank/data", "fnRowCallback": serialNoCount,
        columns: [{ data: "id", orderable: false }, { data: "bank_name" }, { data: "action", orderable: false }],
    });
});

function doEdit(id) {
    $("#hdBankId").val(id);
    $("#txtBankName").focus();
    $("#bankTittle").text("Update Bank");
    $("#btnSave").text("Update");
    getBankById(id);
}

function getBankById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getbank/" + id,
        dataType: "json",
        success: function (data) {
            $("#txtBankName").val(data.bank.bank_name);
            $("#pageloader").fadeOut();
        },
    });
}

function cancel() {
    $("#bankTittle").text("Bank");
    $("#hdBankId").val("");
    $("#txtBankName").val("");
    $("#btnSave").text("Save");
    $("#txtBankName").focus();
}

function showDelete(id) {
    confirmDelete(id, "delete/bank/", "tblBankList");
}

// jquery Validation
$(function () {
    $("form[name='bank']").validate({
        rules: {
            txtBankName: "required",
        },
    });
});
