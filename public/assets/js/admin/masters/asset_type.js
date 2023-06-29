$(document).ready(function () {
    $("#tblAssetType").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: "assettype/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "asset_type" },
            { data: "prefix" },
            { data: "action", orderable: false },
        ],
    });
});

function doEdit(id) {
    $("#hdAssetTypeId").val(id);
    $("#assetTitle").text("Update Asset Type");
    $("#txtAssetType").focus();
    $("#btnSave").text("Update");
    getAssetTypeById(id);
}

function getAssetTypeById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getassettype/" + id,
        dataType: "json",
        success: function (data) {
            $("#txtAssetType").val(data.assettype.asset_type);
            $("#txtPrefix").val(data.assettype.prefix);
            $("#pageloader").fadeOut();
        },
    });
}

function cancel() {
    $("#hdAssetTypeId").val("");
    $("#assetTitle").text("Asset Type");
    $("#txtAssetType").val("");
    $("#txtPrefix").val("");
    $("#btnSave").text("Save");
    $("#txtAssetType").focus();
}

function showDelete(id) {
    confirmDelete(id, "delete/assettype/", "tblAssetType");
}

// jquery Validation
$(function () {
    $("#assetType").validate({
        rules: {
            txtAssetType: "required",
            txtPrefix: "required",
        },
    });
});
