window.axios = require("axios")
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"
window.axios.defaults.headers.post["X-CSRF-TOKEN"] = document.querySelector("meta[name='csrf-token']").getAttribute("content")
window.axios.defaults.baseURL = window.tadah.baseURL
