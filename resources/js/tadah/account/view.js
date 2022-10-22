if ($("#usernameChangeModal").length) {
    let modal = new bootstrap.Modal($("#usernameChangeModal"))

    $("#usernameChange").on("click", function () {
        $(this).trigger("blur")
        modal.show()
    })
}

if ($("#emailChange").length) {
    $("#emailChange").on("click", () => {
        window.location.href = tadah.url("/my/update-email")
    })
}
