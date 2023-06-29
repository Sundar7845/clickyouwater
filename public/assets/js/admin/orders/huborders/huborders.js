$(document).ready(function () {
    BindCity();

    //datatable
    hubOrderList();
});

$("#ddlCity").bind("change", function () {
    getHubs();
});

//filter
$("#ddlState,#ddlCity,#ddlHub").change(function () {
    hubOrderList();
});

function getHubs() {
    $("#pageloader").fadeIn();
    var city_id = $("#ddlCity").val();
    $.ajax({
        url: "/get/hubs",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            city_id: city_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#ddlHub").select2({
                placeholder: "Select Hub",
            });
            $("#ddlHub").html('<option value="0">Select Hub</option>');
            $.each(result.hubs, function (key, value) {
                $("#ddlHub").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.hub_name +
                    "</option>"
                );
            });
            $("#pageloader").fadeOut();
        },
    });
}

//datatable
function hubOrderList() {
    var state_id =
        $("#ddlState option:selected").val() == undefined
            ? 0
            : $("#ddlState option:selected").val();
    var city_id =
        $("#ddlCity option:selected").val() == undefined
            ? 0
            : $("#ddlCity option:selected").val();

    var hub_id =
        $("#ddlHub option:selected").val() == undefined
            ? 0
            : $("#ddlHub option:selected").val();

    dtHubs = $("#tblHubOrders").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/hub/data",
            data: function (data) {
                data.state_id = state_id;
                data.city_id = city_id;
                data.hub_id = hub_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "hub_name" },
            { data: "mobile" },
            { data: "official_email" },
            { data: "city_name" },
            { data: "state_name" },
            { data: "action", orderable: false },
        ],
    });
}

