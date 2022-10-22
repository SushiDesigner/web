import { Datepicker } from 'vanillajs-datepicker'
var showdown = require('showdown')

if (tadah.route == "admin.ban") {
    $("#duration_preset").on("change", function() {
        if ($(this).val() == 6) {
            $("#datepicker").removeClass("d-none")
            $("#datepicker").find("input").attr("required", "")
        } else {
            $("#datepicker").addClass("d-none")
            $("#datepicker").find("input").removeAttr("required", "")
        }
    })

    new Datepicker($("#datepicker").find("input")[0], {
        buttonClass: 'btn',
        autohide: true,
        defaultViewDate: new Date()
    })

    $("#is_appealable").on("change", function () {
        if (!$(this).is(":checked")) {
            let hey = confirm("Are you sure you want to indicate this ban is unappealable?\n\nOnly do this if there is no chance that the user may get unbanned.")
            if (!hey) {
                $(this).prop("checked", true)
            }
        }
    })

    function hook() {
        let modal = new bootstrap.Modal($("#banDetailsModal"))
        let content = $("#banDetailsModal").find("#content")
        let loading = $("#banDetailsModal").find("#loading")

        $("[data-tadah-ban-id]").each(function () {
            $(this).on("click", async () => {
                if ($(content).css("display") != "none") {
                    $(content).css("display", "none")
                }

                $(loading).removeAttr("style")

                modal.show()

                axios.post("/admin/ban/information", {
                    "id": $(this).attr("data-tadah-ban-id")
                }).then((data) => {
                    let response = data.data

                    $(content).find("#moderator_note").find("code").text(response.ban.moderator_note)
                    $(content).find("#internal_reason").find("code").text(response.ban.internal_reason)
                    $(content).find("#is_appealable").find("span").html(response.ban.is_appealable ? '<b class="text-success">Yes</b>' : '<b class="text-danger">No</b>')

                    if (!response.ban.has_been_pardoned && !$(content).find("#pardon-reason").hasClass("d-none")) {
                        $(content).find("#pardon_reason").addClass("d-none")
                    } else {
                        $(content).find("#pardon_reason").find("code").text(response.ban.pardon_internal_reason)
                    }

                    if (response.ban.offensive_item === null && !$(content).find("#offensive_item").hasClass("d-none")) {
                        $(content).find("#offensive_item").addClass("d-none")
                    } else {
                        $(content).find("#offensive_item").find("div").html("")

                        let converter = new showdown.Converter()
                        $(content).find("#offensive_item").find("div").html(converter.makeHtml(response.ban.offensive_item))
                    }

                    setTimeout(() => {
                        $(loading).fadeOut(150, 'swing', () => {
                            $(content).fadeIn(150, 'swing')
                        })
                    }, 300)
                }).catch(() => {
                    alert("Unknown error occurred. Please try again.")

                    modal.hide()
                })
            })
        })
    }

    window.addEventListener("admin-hook-details", hook)
    if ($("#banDetailsModal").length) {
        hook()
    }
}
