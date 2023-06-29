$(document).ready(function () {
    $("#tblCity").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "city/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "city_name" },
            { data: "state_name" },
            { data: "action", orderable: false },
        ],
    });
});

function doStatus(id) {
    var status = $("#chkCity" + id).is(":checked");
    confirmStatusChange(id, "city/", "tblCity", (status == true ? 1 : 0), "chkCity");
}
