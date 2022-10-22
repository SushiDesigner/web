if (tadah.route == "account.disabled") {
    $("#agreed").on("change", function () {
        if ($(this).is(":checked")) {
            $("#reactivate").removeClass("disabled")
        } else {
            $("#reactivate").addClass("disabled")
        }
    })
}
