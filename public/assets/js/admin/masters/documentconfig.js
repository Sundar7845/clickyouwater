$(document).ready(function () {
    $("#tblDocumentConfig").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "documentconfig/data",
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "documenttype_name" },
            {
                data: "is_active",

                render: function (data, type, row) {
                    return `<label class="switch">
                        <input onclick="doStatus(${row.documenttype_id
                        });" id="chkDocumentConfig${row.documenttype_id
                        }" type="checkbox" class="switch-input"
                        name="chkDocumentConfig" '  ${data == 1 ? "checked" : ""
                        } ' />
                        <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </span>
                    </label>`;
                },
            },
            { data: "action", orderable: false },
        ],
    });
});

function doEdit(id, type) {
    $("#hdDocumentTypeId").val(type);
    $("#hdDocumentConfigId").val(id);
    $("#ddlDocumentType").focus();
    $("#documentTitle").text("Update Document Configuration");
    $("#btnSave").text("Update");
    $("input[name^='chkModuleName']").attr("checked", false);
    $("input[name^='chkMandatory']").attr("checked", false);
    getDocumentConfigById(id, type);
    $("#ddlDocumentType").attr('disabled', 'disabled');
    console.log($("#hdDocumentTypeId").val());
}

function getDocumentConfigById(id, type) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "documentconfig/" + id + "/" + type,
        dataType: "json",
        success: function (data) {
            console.log(data);
            $.each(data.document, function (key, val) {
                console.log(val);
                $("#ddlDocumentType").val(val.documenttype_id).trigger("change");
                $("#chkModuleName" + val.documentmodule_id).attr(
                    "checked",
                    true
                );
                if (val.is_mandatory == 1) {
                    $("#chkMandatory" + val.documentmodule_id).attr(
                        "checked",
                        true
                    );
                }
                $("#pageloader").fadeOut();
            });
            $.each(data.documenttype, function (key, val) {
                console.log(val);
                var newOption = '<option value="' + val.id + '">' + val.documenttype_name + '</option>';
                $("#ddlDocumentType").append(newOption);
                $("#ddlDocumentType").val(val.id).trigger("change");

            });
        },
    });
}

function cancel() {
    $("#documentTitle").text("Document Configuration");
    $("#hdDocumentConfigId").val("");
    $("#hdDocumentTypeId").val("");
    $("#ddlDocumentType").val("").trigger("change");
    $("input[name^='chkModuleName']").prop("checked", false);
    $("input[name^='chkMandatory']").prop("checked", false);
    $("#ddlDocumentType").removeAttr('disabled');
    $("#ddlDocumentType").focus();
    $("#btnSave").text("Save");
}

function showDelete(id) {
    confirmDelete(id, "delete/documentconfig/", "tblDocumentConfig");
}


function doStatus(id) {
    var status = $("#chkDocumentConfig" + id).is(":checked");
    confirmStatusChange(
        id,
        "documentconfig/",
        "tblDocumentConfig",
        status == true ? 1 : 0,
        "chkDocumentConfig"
    );
}

// jquery Validation
$(function () {
    $("form[name='document_config']").validate({
        rules: {
            ddlDocumentType: "required",
            chkModuleName: "required",
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
