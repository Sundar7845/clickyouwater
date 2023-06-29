var type = "";
var urlParams = new URLSearchParams(window.location.search);
if (urlParams.has("type")) {
    type = urlParams.get("type");
}

$(document).ready(function () {
    $('#tblrefferalhistory').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: {
            url: "/refferalcustomer/data/" + type,
            data: { type: type }
        },
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "user_name", orderable: false },
            { data: "user_name" },
            { data: "referral_code" },
            { data: "user_id_count" },
            { data: "action", orderable: false }
        ],
    });
});
