$(document).ready(function () {
    UserDepositHistory();
    UserRefundHistory();
});

function UserDepositHistory() {
    var customer_id = $('#hduserid').val();
    $('#tblDepositHistory').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        destroy: true, // Use "destroy" instead of "bDestroy"
        ajax: "/depositHistoryData/" + customer_id,
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "created_at",
                render: function (data, type, row) {
                    var date = new Date(data);
                    return moment(date).format("DD-MM-YYYY");
                },
            },
            { data: "product_name" },
            { data: "qty" },
            {
                data: null,
                render: function (data, type, row) {
                    let html = `<span class="rupee-symbol">&#8377;${data.deposit_amount}</span>`;
                    return html;
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    let html = `<span class="rupee-symbol">&#8377;${(data.qty * data.deposit_amount)}</span>`;
                    return html;
                }
            },
            // {
            //     data: "id",
            //     render: function (data, type, row) {
            //         return `<button type="button" class="btn btn-xs btn-primary" onclick="showRefundInfoPopup(${data});">View</button>`;
            //     }
            // }
        ],
    });
}


function UserRefundHistory() {
    var user_id = $('#hduserid').val();
    $('#tblRefundInfo').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        destroy: true, // Use "destroy" instead of "bDestroy"
        ajax: "/getRefundDetails/" + user_id,
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "refund_date",
                render: function (data, type, row) {
                    var date = new Date(data);
                    return moment(date).format("DD-MM-YYYY");
                },
            },
            { data: "product_name" },
            { data: "refund_to" },
            {
                data: null,
                render: function (data, type, row) {
                    let html = `<span class="rupee-symbol">&#8377;${data.refund_amount}</span>`;
                    return html;
                }
            }
        ],
    });
}
