require("./ban")

import { Datepicker } from 'vanillajs-datepicker'

if ($("#datepicker").length) {
    new Datepicker($("#datepicker").find("input")[0], {
        buttonClass: 'btn',
        autohide: true,
        defaultViewDate: new Date()
    })

}
