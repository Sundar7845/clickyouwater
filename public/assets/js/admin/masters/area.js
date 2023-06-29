$(document).ready(function () {
    $("#tblArea").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "area/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "state_name" },
            { data: "city_name" },
            { data: "area_name" },
            // { data: "radius" },
            {
                data: "is_active",

                render: function (data, type, row) {
                    return `<label class="switch">
                        <input onclick="doStatus(${row.id});" id="chkArea${row.id
                        }" type="checkbox" class="switch-input"
                        name="chkDesignation" '  ${data == 1 ? "checked" : ""
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

function doEdit(id) {
    $("#hdAreaId").val(id);
    $("#txtAreaName").focus();
    $("#areaTitle").text("Update Area");
    $("#btnSave").text("Update");
    getAreaById(id);
}

function getAreaById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getarea/" + id,
        dataType: "json",
        success: function (data) {
            $("#ddlState").val(data.area.state_id).trigger("change");
            setTimeout(function () {
                $("#ddlCity").val(data.area.city_id).trigger("change");
            }, 2000);
            $("#txtAreaName").val(data.area.area_name);
            $("#txtRadius").val(data.area.radius);
            $("#pageloader").fadeOut();
        },
    });
}

function cancel() {
    $("#areaTitle").text("Area");
    $("#hdAreaId").val("");
    $("#txtAreaName").val("");
    // $("#txtRadius").val("");
    $("#ddlState").val("").trigger("change");
    $("#ddlCity").val("").trigger("change");
    $("#ddlState").focus();
    $("#btnSave").text("Save");
}

function showDelete(id) {
    confirmDelete(id, "delete/area/", "tblArea");
}

function doStatus(id) {
    var status = $("#chkArea" + id).is(":checked");
    confirmStatusChange(
        id,
        "area/",
        "tblArea",
        status == true ? 1 : 0,
        "chkArea"
    );
}

// jquery Validation
$(function () {
    $("form[name='areaValidate']").validate({
        rules: {
            ddlState: "required",
            ddlCity: "required",
            txtAreaName: "required",
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
