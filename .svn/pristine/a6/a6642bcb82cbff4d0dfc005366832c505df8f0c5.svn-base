//document update
function doVerify(id) {
    var status = $("#chkVerifyDocument" + id).is(":checked");
    if (status == true) {
        $("#chkVerifyDocument").val(1);
        status = 1;
    } else {
        $("#chkVerifyDocument").val(0);
        status = 0;
    }
    var documentmodule_id = $("#hddocumentmodule_id").val();

    if (documentmodule_id == 1) {
        var url = "/verifymanufacturerdocument/";
    }

    if (documentmodule_id == 2) {
        var url = "/verifyhubdocument/";
    }

    if (documentmodule_id == 3) {
        var url = "/verifylogisticdocument/";
    }

    if (documentmodule_id == 4) {
        var url = "/verifydeliverypeopledocument/";
    }

    if (documentmodule_id == 6) {
        var url = "/verifyemployeedocument/";
    }

    confirmVerification(id, url, status);
}
