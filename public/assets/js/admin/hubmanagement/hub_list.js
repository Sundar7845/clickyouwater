$(document).ready(function () {
    listHub();
    BindCity();
    BindArea();
});

$("#ddlState,#ddlCity,#ddlArea").change(function () {
    listHub();
});

function listHub() {
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

    $("#tblHub").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/hubData/" + type,
            data: function (hub) {
                hub.state_id = state_id;
                hub.city_id = city_id;
                hub.area_id = area_id;
                hub.type = type;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "hub_code" },
            { data: "hub_name" },
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
            { data: "delivery_people_count" },
            {
                data: "document_path",
                render: function (data, type, row) {
                    if (row.document_path) {
                        return `<a href="hubdocument/${row.id}"
                        class="badge bg-label-warning">View</a>`;
                    } else {
                        return `<span 
                        class="badge bg-label-danger">NA</span>`;
                    }
                },
            },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                            <input onclick="doStatus(${row.id});" id="chkhub${
                        row.id
                    }" type="checkbox" class="switch-input"
                            name="chkhub" '  ${data == 1 ? "checked" : ""} ' />
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
    var status = $("#chkhub" + id).is(":checked");
    confirmStatusChange(id, "hub/", "tblHub", status == true ? 1 : 0, "chkhub");
}

//Delete Data
function showDelete(id) {
    confirmDelete(id, "delete/hub/", "tblHub");
}
