window.addEventListener("alert", (event) => {
    alert(event.detail)
})

window.addEventListener("success", (event) => {
    let element = $("#container-success")
    $(element).find("span").html(event.detail)

    let clone = $(element).clone().removeAttr("id").appendTo($(element).parent())
    $(clone).removeClass("d-none")

    setTimeout(() => {
        $(clone).fadeOut(1000)
    }, 3500)
})

window.addEventListener("error", (event) => {
    let element = $("#container-error")
    $(element).find("span").html(event.detail)

    let clone = $(element).clone().removeAttr("id").appendTo($(element).parent())
    $(clone).removeClass("d-none")

    setTimeout(() => {
        $(clone).fadeOut(1000)
    }, 3500)
})

tadah.url = (uri) => {
    return `${tadah.baseURL}${uri}`
}

window.addEventListener("reload", () => {
    window.location.reload()
})
