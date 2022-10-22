// fills in the caret
$("[data-tadah-magic='language-dropdown']").each(function () {
    $(this)[0].addEventListener("shown.bs.dropdown", () => {
        $(this).find(".fa-regular.fa-caret-down").removeClass("fa-regular").addClass("fa-solid")
    })

    $(this)[0].addEventListener("hidden.bs.dropdown", () => {
        $(this).find(".fa-solid.fa-caret-down").removeClass("fa-solid").addClass("fa-regular")
    })
})

// For forms that don't have buttons as the submit button, but rather an <a>
$(".tadah-link-submit").each(function() {
    $(this).on("click", () => {
        $(this).parent().trigger("submit")
    })
})
