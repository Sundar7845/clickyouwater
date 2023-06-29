$(document).ready(function () {
    BindCity();

    //datatable
    manufactureOrderList();

    $("#ddlCity").bind("change", function () {
        getManufactures();
    });
});

//filter
$("#ddlState,#ddlCity,#ddlManufacture").change(function () {
    manufactureOrderList();
});

function getManufactures() {
    $("#pageloader").fadeIn();
    var city_id = $("#ddlCity").val();
    $.ajax({
        url: "/getmanufacturers",
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
            $("#ddlManufacture").select2({
                placeholder: "Select Manufacture",
            });
            $("#ddlManufacture").html('<option value="0">Select Manufacture</option>');
            $.each(result.manufactures, function (key, value) {
                $("#ddlManufacture").append(
                    '<option value="' +
                        value.id +
                        '">' +
                        value.manufacturer_name +
                        "</option>"
                );
            });
            $("#pageloader").fadeOut();
        },
    });
}

function manufactureOrderList() {
    var state_id =
        $("#ddlState option:selected").val() == undefined
            ? 0
            : $("#ddlState option:selected").val();
    var city_id =
        $("#ddlCity option:selected").val() == undefined
            ? 0
            : $("#ddlCity option:selected").val();

    var Manufacture_id =
        $("#ddlManufacture option:selected").val() == undefined
            ? 0
            : $("#ddlManufacture option:selected").val();

    dtHubs = $("#tblManufactureOrders").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/manufacturer/data",
            data: function (data) {
                data.state_id = state_id;
                data.city_id = city_id;
                data.Manufacture_id = Manufacture_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "manufacturer_code" },
            { data: "manufacturer_name" },
            { data: "mobile" },
            { data: "hub_name" },
            { data: "city_name" },
            { data: "state_name" },
            { data: "action", orderable: false },
        ],
        rowGroup: {
            dataSrc: "manufacturer_name",
        },
    });
}
