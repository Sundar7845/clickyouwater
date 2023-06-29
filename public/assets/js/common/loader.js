//Page PredLoader on Form Submit
$(document).ready(function () {
    var formId = $('form').attr('id');
    if (formId != "frmPayment") {
        $("form").on("submit", function (event) {
            if (this.checkValidity()) {
                event.preventDefault();
                $("#pageloader").fadeIn();
                this.submit();
            }
        });
    }
});