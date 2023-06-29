$(document).ready(function () {

  surrenderRequestList();

});

//filter
$("#ddlState,#ddlCity,#ddlArea").change(function () {
  surrenderRequestList();
  BindHub();
});

$("#ddlHub").change(function () {
  surrenderRequestList();
});

function surrenderRequestList() {

  var state_id =
    $("#ddlState option:selected").val() == undefined
      ? 0
      : $("#ddlState option:selected").val();
  var city_id =
    $("#ddlCity option:selected").val() == undefined
      ? 0
      : $("#ddlCity option:selected").val();
  var hub_id =
    $("#ddlHub option:selected").val() == undefined
      ? 0
      : $("#ddlHub option:selected").val();

  $("#tblSurrenderRequests").DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    scrollX: true,
    bDestroy: true,
    width: '100%', // Adjust the initial width as needed
    order: [[0, "ASC"]],
    ajax: {
      url: "/surrenderrequest/data/",
      data: function (customerorders) {
        customerorders.state_id = state_id;
        customerorders.city_id = city_id;
        customerorders.hub_id = hub_id;
      },
    },

    "fnRowCallback": serialNoCount,
    columns: [
      { data: "id", orderable: false },
      {
        data: "surrender_order_no",
        render: function (data, type, row, meta) {
          var formattedDate = moment(row.created_at).format("DD-MM-YYYY");
          var list =
            "<div class='text-muted'><small class='bg-light p-1'>" +
            row.surrender_order_no +
            "</small></div>";
          return formattedDate + " " + list;
        },
      },
      { data: "user_name" },
      { data: "hub_name" },
      { data: "total_qty" },
      {
        data: "refund_amount",
        render: function (data, type, row) {
          return "&#8377;" + data;
        }
      },
      {
        data: "refund_to",
        render: function (data, type, row, meta) {
          var button = `</br><a href="#" onclick="showBankInfoPopup(${row.user_id});">View</a>`;
          if (data == 'wallet') {
            return data;
          } else {
            return data + " " + button;
          }
        },
      },
      {
        data: "status",
        render: function (data, type, row) {
          return `<a class="badge bg-label-${row.status_color_css}">${row.status}</a>`;
        },
      },
      { data: "action", orderable: false },
    ],
  });
}


//Request Approved Function
function doApprove(id) {
  Swal.fire({
    title: "Are you sure want to Approved this request?",
    text: "You can able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, Approve it!",
    customClass: {
      confirmButton: "btn btn-success me-3",
      cancelButton: "btn btn-danger",
    },
    buttonsStyling: false,

  }).then(function (result) {
    if (result.isConfirmed) { // Check if "Yes" button was clicked
      var tblId = 'tblSurrenderRequests';
      $.ajax({
        url: "/approve/" + id,
        method: "GET",
        dataType: "json",
        success: function (response) {
          if (response.status == "error") {
            Swal.fire({
              title: "Request Not Approved!",
              text: "This surrender request maybe cancelled by customer.",
              icon: "error",
              customClass: {
                confirmButton: "btn btn-primary",
              },
              buttonsStyling: false,
            }).then(function () {
              refreshDatatable(tblId);
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Request Approved!",
              text: "This request has been approved.",
              customClass: {
                confirmButton: "btn btn-success",
              },
            }).then(function () {
              refreshDatatable(tblId);
            });
          }
        },
      });
    }
  });
}

function rejectrequest(Id) {
  $("#hdrejectId").val(Id);
}

// show Bank Info Popup
function showBankInfoPopup(id) {
  $('#hdUserId').val(id);
  $.ajax({
    url: '/surrenderbankinfo/' + id,
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      var modalContent = '';
      modalContent += '<tr>';
      modalContent += '<td>' + response.bankInfo.bank_name + '</td>';
      modalContent += '<td>' + response.bankInfo.branch_name + '</td>';
      modalContent += '<td>' + response.bankInfo.account_holder_name + '</td>';
      modalContent += '<td>' + response.bankInfo.account_no + '</td>';
      modalContent += '<td>' + response.bankInfo.ifsc_code + '</td>';
      modalContent += '</tr>';

      $('#tblBankInfo tbody').html(modalContent);
      $('#showBankInfoPopup').modal('show');
    },
    error: function (xhr, status, error) {
      console.log(error);
    }
  });
}

//Request Approved Function
// function processRefund(id) {
//   Swal.fire({
//     title: "Are you sure?",
//     text: "Click yes after you have processed the refund through bank",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonText: "Yes, process it!",
//     customClass: {
//       confirmButton: "btn btn-success me-3",
//       cancelButton: "btn btn-danger",
//     },
//     buttonsStyling: false,
//   }).then(function () {
//     var tblId = 'tblSurrenderRequests';
//     $.ajax({
//       url: "/processrefund/" + id,
//       method: "GET",
//       dataType: "json",
//       success: function (response) {
//         console.log(response);
//         if (response.status == "error") {
//           Swal.fire({
//             title: "Refund Already Processed!",
//             text: "This refund can be alreay processed.",
//             icon: "error",
//             customClass: {
//               confirmButton: "btn btn-primary",
//             },
//             buttonsStyling: false,
//           }).then(function () {
//             refreshDatatable(tblId);
//           });
//         } else {
//           Swal.fire({
//             icon: "success",
//             title: "Refund Processed!",
//             text: "This refund has been processed.",
//             customClass: {
//               confirmButton: "btn btn-success",
//             },
//           }).then(function () {
//             refreshDatatable(tblId);
//           });
//         }
//       },
//     });
//   });
// }

function processRefund(id) {
  Swal.fire({
    title: "Are you sure?",
    text: "Click yes after you have processed the refund through the bank",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, process it!",
    customClass: {
      confirmButton: "btn btn-success me-3",
      cancelButton: "btn btn-danger",
    },
    buttonsStyling: false,
  }).then(function (result) {
    if (result.isConfirmed) { // Check if "Yes" button was clicked
      var tblId = 'tblSurrenderRequests';
      $.ajax({
        url: "/processrefund/" + id,
        method: "GET",
        dataType: "json",
        success: function (response) {
          console.log(response);
          if (response.status == "error") {
            Swal.fire({
              title: "Refund Already Processed!",
              text: "This refund has already been processed.",
              icon: "error",
              customClass: {
                confirmButton: "btn btn-primary",
              },
              buttonsStyling: false,
            }).then(function () {
              refreshDatatable(tblId);
            });
          } else {
            Swal.fire({
              icon: "success",
              title: "Refund Processed!",
              text: "This refund has been processed.",
              customClass: {
                confirmButton: "btn btn-success",
              },
            }).then(function () {
              refreshDatatable(tblId);
            });
          }
        },
      });
    }
  });
}

