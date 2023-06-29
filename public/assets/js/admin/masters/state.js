$(document).ready(function () {
    var table = $("#tblState").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "state/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "state_code" },
            { data: "state_name" },
            { data: "action", orderable: false },
        ],
    });
});


function doStatus(id) {
    var status = $("#chkState" + id).is(":checked");
    confirmStatusChange(id, "state/", "tblState", (status == true ? 1 : 0), "chkState");
}
