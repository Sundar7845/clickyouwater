$(document).ready(function () {
    listManufacturer();
    BindCity();
    BindArea();
});

$("#ddlState,#ddlCity,#ddlArea").change(function () {
    listManufacturer();
});

function listManufacturer() {
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


    //Get type from url to the dataTable
    var type = "";
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("type")) {
        type = urlParams.get("type");
    }

    $("#tblManufacturer").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/manufacturerData/" + type,
            data: function (manufacturer) {
                manufacturer.state_id = state_id;
                manufacturer.city_id = city_id;
                manufacturer.area_id = area_id;
                manufacturer.type = type;
            }
        },
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "manufacturer_code" },
            { data: "manufacturer_name" },
            {
                data: "proprietor_name",
                render: function (data, type, row, meta) {
                    var list =
                        "<div class='text-muted p-1'><small class='bg-light p-1'>" +
                        row.proprietor_mobile +
                        "</small></div>";
                    return row.proprietor_name + " " + list;
                },
            },
            {
                data: "address",
                render: function (data, type, row, meta) {
                    return (
                        row.address +
                        ", " +
                        row.state_name +
                        ", " +
                        row.city_name
                    );
                },
            },
            {
                data: "document_path",
                render: function (data, type, row) {
                    if (row.document_path) {
                        return `<a href="manufacturerdocument/${row.id}"
                        class="badge bg-label-warning">View</a>`;
                    } else {
                        return `<span class="badge bg-label-danger">NA</span>`;
                    }
                },
            },
            { data: "hub_count" },
            { data: "logistic_partner_count" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                            <input onclick="doStatus(${row.id
                        });" id="chkManufacturer${row.id
                        }" type="checkbox" class="switch-input"
                            name="chkManufacturer" '  ${data == 1 ? "checked" : ""
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
}

//Update Status
function doStatus(id) {
    var status = $("#chkManufacturer" + id).is(":checked");
    confirmStatusChange(
        id,
        "manufacturer/",
        "tblManufacturer",
        status == true ? 1 : 0,
        "chkManufacturer"
    );
}

//Delete Data
function showDelete(id) {
    confirmDelete(id, "delete/manufacturer/", "tblManufacturer");
}
