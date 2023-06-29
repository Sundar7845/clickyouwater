$(document).ready(function () {
    BindCity();
    listDeliveryPerson();
});

$("#ddlState,#ddlCity,#ddlArea,#ddlhub").change(
    function () {
        listDeliveryPerson();
    }
);

function listDeliveryPerson() {
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
    var hub_id =
        $("#ddlhub option:selected").val() == undefined
            ? 0
            : $("#ddlhub option:selected").val();

    //Get type from url to the dataTable
    var type = "";
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("type")) {
        type = urlParams.get("type");
    }
    var baseUrl = window.location.origin;
    $("#tblDeliveryPerson").DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/delivery/person/data/" + type,
            data: function (deliveryperson) {
                deliveryperson.state_id = state_id;
                deliveryperson.city_id = city_id;
                deliveryperson.area_id = area_id;
                deliveryperson.hub_id = hub_id;
                deliveryperson.type = type;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "delivery_person_code" },
            {
                data: "delivery_person_image",
                orderable: false,
                render: function (data) {
                    if (data != null) {
                        return (
                            '<img src="' +
                            data +
                            '" class="avatar" width="50" height="50"/>'
                        );
                    } else {
                        return '<img src="' + baseUrl + '/assets/img/avatars/14.png" class="avatar" width="50" height="50"/>';
                    }
                },
            },
            { data: "delivery_person_name" },
            { data: "hub_name", visible: $("#hdAuthUserRoleId").val() != 4 },
            {
                data: "rating",
                render: function (data, type, row) {
                    return `<div class= "read-only-ratings" data - rateyo - read - only="true"> </div>`;
                },
            },
            {
                data: "document_view",
                render: function (data, type, row) {
                    if (row.document_path) {
                        return `<a href="deliverypeopledocument/${row.id}"
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
                    <input onclick="doStatus(${
                        row.id
                    });" id="chkDeliveryPerson${
                        row.id
                    }" type="checkbox" class="switch-input"
                name="chkDeliveryPerson" '  ${data == 1 ? "checked" : ""} ' />
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

//Status update
function doStatus(id) {
    var status = $("#chkDeliveryPerson" + id).is(":checked");
    if (status == true) {
        $("#chkDeliveryPerson").val(1);
        status = 1;
    } else {
        $("#chkDeliveryPerson").val(0);
        status = 0;
    }
    confirmStatusChange(id, "deliveryperson/", "tblDeliveryPerson", status);
}

//Delete Data
function showDelete(id) {
    confirmDelete(id, "delete/deliverperson/", "tblDeliveryPerson");
}
