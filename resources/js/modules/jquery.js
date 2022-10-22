window.$ = require("jquery")

$.fn.hasAttr = function (name) {
    return this.attr(name) !== undefined
}

require("jquery.waitforimages")
