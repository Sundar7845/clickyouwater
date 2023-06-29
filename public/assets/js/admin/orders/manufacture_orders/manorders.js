//Load Orders Data On Dashboard DataTable
$(document).ready(function () {
    manfacturerCansOrderData();
    manfacturerOthersOrderData();
});

//Cans Order Data
function manfacturerCansOrderData() {
    $('#tblCans').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: "/manfacturerCansOrderData",
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_type_name" },
            { data: "product_name" },
            { data: "order_qty" },
            { data: "filled_qty" },
            { data: "empty_qty" },
        ],
    });
}

//Others Order Data
function manfacturerOthersOrderData() {
    $('#tblOthers').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: "/manfacturerOthersOrderData",
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_type_name" },
            { data: "product_name" },
            { data: "order_qty" },
            { data: "filled_qty" },
            { data: "empty_qty" },
        ],
    });
}