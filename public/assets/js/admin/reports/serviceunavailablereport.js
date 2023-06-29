$(document).ready(function () {
    BindCity();

    serviceUnavailableList();
});

//filter
$("#ddlState,#ddlCity").change(function () {
    serviceUnavailableList();
});

function serviceUnavailableList() {
    var state_id =
        $("#ddlState option:selected").val() == undefined
            ? 0
            : $("#ddlState option:selected").val();
    var city_id =
        $("#ddlCity option:selected").val() == undefined
            ? 0
            : $("#ddlCity option:selected").val();

    var area_id =
        $("#ddlArea option:selected").val() == undefined
            ? 0
            : $("#ddlArea option:selected").val();

    $("#tblServiceUnavailableReport").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/serviceunavilable/data",
            data: function (data) {
                data.state_id = state_id;
                data.city_id = city_id;
            },
        },
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "customer_name",
                render: function (data, type, row, meta) {
                    var html =
                        "<div class='text-muted p-1'><small class='bg-light p-1'>" +
                        row.mobile +
                        "</small></div>";
                    return row.customer_name + " " + html;
                },
            },
            { data: 'state_name'},
            { data: 'city_name'},
            {
                data: null,
                render: function (data, type, row) {
                    return (
                        data.building_no +
                        " " +
                        data.street +
                        ", " +
                        data.area +
                        ", " +
                        data.city_name +
                        ", " +
                        data.state_name +
                        ", " +
                        data.pincode
                    );
                },
            },
        ],
    });
}
