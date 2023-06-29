var isEdit = false;
$(document).ready(function () {

});

$("#ddlOfferName").on("change", function () {
    var offer_id = $("#ddlOfferName").val();
    $.ajax({
        url: "/get/offerallocation/hubs",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            offer_id: offer_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.length === 0) {
                // Data is empty, update the input fields with a default value
                $('.txtPointsAllocated').val("");
            } else {
                // Data is not empty, update the input fields with the retrieved values
                $.each(data, function (key, value) {
                    var allocatepointsId = 'txtPointsAllocated' + key;
                    $("#" + allocatepointsId).val(value.points_allocated);
                    $('#totalPoints').text(value.offer_total_points);
                });
            }
        },
    });
});

$("#ddlCity").on("change", function () {
    $("#pageloader").fadeIn();
    var city_id = $("#ddlCity").val();
    $.ajax({
        url: "/get/offerallocation/hubs",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            city_id: city_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            var html = '';
            $.each(data, function (key, value) {
                var checkboxId = 'defaultCheck' + key;
                var totalpointId = 'TotalPointsAllocated' + key;
                var allocatepointsId = 'txtPointsAllocated' + key;
                html += '<tr>';
                html += '<td><div class="form-check"><input class="form-check-input" for="' + checkboxId + '" name="' + checkboxId + '" type="checkbox" value="' + value.id + '" id="' + checkboxId + '"></div></td>';
                html += '<td>' + value.hub_name + '</td>';
                html += '<td id="' + totalpointId + '">' + (value.total_points_allocated ?? 0) + '</td>';
                html += '<td><input type="text" name="' + allocatepointsId + '" id="' + allocatepointsId + '" class="form-control txtPointsAllocated" value="" placeholder="Enter Points" readonly></td>';
                html += '<td>0</td>';
                html += '</tr>';
            });
            html += '</form>';
            $('#tbodyOfferallocate').html(html);
            
            ///Allocation points validation
            $('input[name^="txtPointsAllocated"]').on('change', function () {
                var allocationPoints = 0;
                $('input[name^="txtPointsAllocated"]').each(function () {
                    var value = parseInt($(this).val()) || 0;
                    allocationPoints += value;
                });
                var allocationtotalPoints = allocationPoints;
                var Totalpoints = $('#totalPoints').text(); 
                $('#offerAllocateForm').off('submit').on('submit', function (event) {

                    if (allocationtotalPoints > Totalpoints) {
                        // Perform your validation action here
                        Swal.fire({
                            title: "Invalid Allocation Of Points",
                            text: "The allocation points exceeds the offer's total points.",
                            icon: "error",
                            customClass: {
                                confirmButton: "btn btn-primary",
                            },
                            buttonsStyling: false,
                        });
                        clearData();
                        return false;
                    }
                    return true;
                });
            });
            // Show/hide txtPointsAllocated input field based on checkbox state
            $('input[name^="defaultCheck"]').on('change', function () {
                var inputId = '#txtPointsAllocated' + $(this).attr('name').substr(12);
                if ($(this).is(':checked')) {
                    $(inputId).prop('readonly', false);
                } else {
                    $(inputId).prop('readonly', true);
                }
            });
            $("#pageloader").fadeOut();
        },
    });
});

function clearData() {
    $('#hdSelHubIds').val(''); // Clear hub IDs
    $('#hdSelHubPoints').val(''); // Clear hub points
}

// Handle form submission
function validateData() {
    var hub_ids = []; // create an empty array to store checked hub names
    var hub_points_allocated = []; // create an empty array to store txtPointsAllocated values
    //hub points allocated
    $('.txtPointsAllocated').each(function () {
        hub_points_allocated.push($(this).val());
    });

    //hub Name
    $('input[name^="defaultCheck"]').each(function (index) {
        hub_ids.push($(this).val());
    });
    $('#hdSelHubIds').val(JSON.stringify(hub_ids));
    $('#hdSelHubPoints').val(JSON.stringify(hub_points_allocated));
    return true;
}

// jquery Validation
$(function () {
    $("form[name='offer_allocate']").validate({
        rules: {
            ddlOfferName: "required",
            ddlState: "required",
            ddlCity: "required",
        },
        messages: {
            required: "This field is required",
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents(".form-group"));
            } else {
                // This is the default behavior
                // error.insertAfter(element);
                if (element.siblings(".error").html() == undefined) {
                    error.appendTo(element.parent().next(".error"));
                } else {
                    error.appendTo(element.siblings(".error"));
                }
            }
        },
    });
});
