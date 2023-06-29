$(document).ready(function () {
    $("#tblDocumentType").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "documenttype/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "documenttype_name" },
            { data: "action", orderable: false },
        ],
    });
});

function doEdit(id) {
    $("#hdDocumentTypeNameId").val(id);
    $("#documentTypeTitle").text("Update Document Type");
    $("#txtDocumenttypeName").focus();
    $("#btnSave").text("Update");
    getDocumentTypeById(id);
}

function getDocumentTypeById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getdocumenttype/" + id,
        dataType: "json",
        success: function (data) {
            $("#txtDocumenttypeName").val(data.document.documenttype_name);
            $("#pageloader").fadeOut();
        },
    });
}

function cancel() {
    $("#documentTypeTitle").text("Document Type");
    $("#hdDocumentTypeNameId").val("");
    $("#txtDocumenttypeName").val("");
    $("#ddlState").focus();
    $("#btnSave").text("Save");
}

function showDelete(id) {
    confirmDelete(id, "delete/documenttype/", "tblDocumentType");
}


// jquery Validation
$(function () {
    $("form[name='documenttype']").validate({

        rules: {
            txtDocumenttypeName: "required",
        },
    });
});

