//Load Orders Data On Dashboard DataTable
$(document).ready(function () {
    manfacturerCansOrderData();
    manfacturerOthersOrderData();
    manfacturerStockInProductionData();
    manfacturerStockData();
    manfacturerEmptyCanData();
    manfacturerDamagedCanData();
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

//Stock In Production Data
function manfacturerStockInProductionData() {
    $('#tblInProduction').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: "/manfacturerStockInProductionData",
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_type_name" },
            { data: "product_name" },
            { data: "qty" }
        ],
    });
}


//In Stock Data
function manfacturerStockData() {
    $('#tblInStock').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: "/manfacturerStockData",
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_type_name" },
            { data: "product_name" },
            { data: "filled_qty" }
        ],
    });
}


//Empty Can Data
function manfacturerEmptyCanData() {
    $('#tblEmptyCans').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: "/manfacturerEmptyCanData",
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_type_name" },
            { data: "product_name" },
            { data: "empty_qty" }
        ],
    });
}

//Damaged Can Data
function manfacturerDamagedCanData() {
    $('#tblDamagedCans').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: "/manfacturerDamagedCanData",
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_type_name" },
            { data: "product_name" },
            { data: "damaged_qty" }
        ],
    });
}