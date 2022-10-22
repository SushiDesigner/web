import * as bootstrap from "bootstrap"
window.bootstrap = bootstrap

var tooltips = [].slice.call(document.querySelectorAll("[data-bs-toggle='tooltip']"))
tooltips.map((element) => {
    return new bootstrap.Tooltip(element)
})
