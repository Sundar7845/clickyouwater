$(document).ready(function () {

    $("#ddlNotificationType").on("change", function () {
        $("#paramList").val("");
        BindMessageFormat();
    });

    $("#ddlMessageFormat").select2({
        placeholder: "Select Brands",
    });

    $("#tblNotificationConfig").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: "notification-config/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "notification_type" },
            { data: "notification_msg_format" },
            { data: "action", orderable: false },
        ],
       
    });

});

function notificationConfig(){
    //Bind Parameters In Message Format
    const paramValues = document.querySelectorAll('.paramValue');

    function insertParamValue(paramValue) {
        const txtMessageFormat = document.getElementById('txtMessageFormat');
        const startPos = txtMessageFormat.selectionStart;
        const endPos = txtMessageFormat.selectionEnd;
        const currentValue = txtMessageFormat.value;
        
        const newValue =
            currentValue.substring(0, startPos) +
            paramValue +
            currentValue.substring(endPos);

        txtMessageFormat.value = newValue;
        txtMessageFormat.focus();
        txtMessageFormat.setSelectionRange(startPos + paramValue.length, startPos + paramValue.length);
    }

    paramValues.forEach((param) => {
        param.addEventListener('click', () => {
            insertParamValue(param.textContent);
        });

        param.addEventListener('dragstart', (event) => {
            event.dataTransfer.setData('text/plain', param.textContent);
        });
    });
};



function BindMessageFormat() {
    $("#pageloader").fadeIn();
    $(".paramValue.badge.bg-label-primary.mx-1").text("");
    var notification_type_id = $("#ddlNotificationType").val();
    $("#notification_var").html("");
    $.ajax({
        url: "/get/messageformat",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            notification_type_id: notification_type_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (data) {
            $.each(data, function (key, value) {
                var spanElement = $('<span></span>').text(value.variables)
                    .addClass("paramValue badge bg-label-primary mx-1")
                    .attr("draggable", "true"); // Add this line to set the id
                $("#paramList").append(spanElement);
            });
                notificationConfig();
            $("#pageloader").fadeOut();
        },
    });
}


function doEdit(id) {
    $("#hdNotificationConfigId").val(id);
    $("#ddlNotificationType").focus();
    $("#btnSave").text("Update");
    getNotificationConfigById(id);
}

function getNotificationConfigById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getnotificationconfig/" + id,
        dataType: "json",
        success: function (data) {
            $("#ddlNotificationType").val(data.notificationConfig.notification_type_id).trigger("change");
            $("#txtMessageFormat").val(data.notificationConfig.notification_msg_format);
            $("#pageloader").fadeOut();
        },
    });
}

function cancel() {
    $("#hdNotificationConfigId").val("");
    $("#ddlNotificationType").val("").trigger("change");
    $("#txtMessageFormat").val("");
    $("#btnSave").text("Save");
    $("#ddlNotificationType").focus();
}

function showDelete(id) {
    confirmDelete(id, "delete/getnotificationconfig/", "tblNotificationConfig");
}

//jquery Validation
$(function () {
    $("#notificationConfig").validate({
        rules: {
            ddlNotificationType: "required",
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
