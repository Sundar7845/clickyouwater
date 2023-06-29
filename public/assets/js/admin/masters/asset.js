$(document).ready(function () {
    $("#tblAsset").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: "asset/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "asset_id" },
            { data: "asset_type" },
            { data: "asset_name" },
            { data: "asset_detail" },
            { data: "action", orderable: false },
        ],
    });
    BindAssetId();
});

function doEdit(id) {
    $("#hdAssetId").val(id);
    $("#assetTitle").text("Update Asset");
    $("#ddlAssetType").focus();
    $("#btnSave").text("Update");
    getAssetById(id);
}

function getAssetById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getasset/" + id,
        dataType: "json",
        success: function (data) {
            $("#txtAssetPrefix").val(data.asset.prefix);
            $("#ddlAssetType").val(data.asset.asset_type_id).trigger("change");
            $("#txtAssetName").val(data.asset.asset_name);
            $("#txtAssetDetail").val(data.asset.asset_detail);
            $("#pageloader").fadeOut();
        },
    });
}

function cancel() {
    $("#hdAssetId").val("");
    $("#txtAssetId").val("");
    $("#assetTitle").text("Asset");
    $("#ddlAssetType").val("").trigger("change");
    $("#txtAssetName").val("");
    $("#txtAssetDetail").val("");
    $("#btnSave").text("Save");
    $("#txtAssetType").focus();
}

function showDelete(id) {
    confirmDelete(id, "delete/asset/", "tblAsset");
}

function BindAssetId() {
    $("#ddlAssetType").on("change", function () {
        var asset_type_id = this.value;
        $("#txtAssetPrefix").html("");
        $.ajax({
            url: "get/assetid",
            type: "POST",
            data: {
                asset_type_id: asset_type_id,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                if (data.assetid == "") {
                    $("#txtAssetPrefix").val("");
                } else {
                    $("#txtAssetPrefix").val(data.assetid);
                }
            },
        });
    });
}

//jquery Validation
$(function () {
    $("#asset").validate({
        rules: {
            ddlAssetType: "required",
            txtAssetName: "required",
            txtAssetDetail: "required",
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents(".form-group"));
            } else {
                if (element.siblings(".error").html() == undefined) {
                    error.appendTo(element.parent().next(".error"));
                } else {
                    error.appendTo(element.siblings(".error"));
                }
            }
        },
    });
});
