const xss = require("xss")

function appendToLog(data) {
    let line = $("<span>", { class: "arbiter-line" })
    let html = ""

    html += '<span class="arbiter-black">[' + xss(data.timestamp) + ']</span> '
    html += '<span style="color: ' + xss(data.severity.color) + ' !important">[' + xss(data.severity.event) + ']</span> '

    if (!data.blur) {
        html += xss(data.output)
    } else {
        let output = xss(data.output)
        output = output.replaceAll(xss(data.blur), '<span class="arbiter-blur">' + xss(data.blur) + '</span>')

        html += output
    }

    $(line).html(html)
    $(".arbiter-output").find("#content").append($(line))
}

if (tadah.route == "admin.game-server.view") {
    if (!tadah.data.isSetUp) {
        Echo.private(`game-servers.${tadah.data.uuid}`)
            .listen('GameServer\\StateChange', () => {
                window.location.reload()
            })
    } else {
        if (tadah.data.state == 0) {
            axios.post(`/admin/game-server/${tadah.data.uuid}/logs`, {
                'key': 'console'
            }).then((data) => {
                for (let i = 0; i < data.data.output.length; i++) {
                    appendToLog(data.data.output[i])
                }

                $(".spinner-border").addClass("d-none")
                $(".arbiter-output").removeClass("offline-output")
                $(".arbiter-output").addClass("blinking")
                $(".arbiter-output").find("img").addClass("d-none")
                $("#timestamp").removeClass("d-none")
                $(".arbiter-output").find("#content").removeClass("d-none")
            })
        }
        Echo.private(`game-servers.${tadah.data.uuid}`)
            .listen('GameServer\\ConsoleOutput', (data) => {
                appendToLog(data)
            })
            .listen('GameServer\\StateChange', (data) => {
                // Look at this code daaaaaawg :sob:

                switch (data.state) {
                    case 0:
                        $("#status").attr("class", "d-flex align-items-center text-success")
                        $("#status").find("span").text("Online")
                        $("#running-thumbnail-jobs").removeClass("d-none")
                        $("#running-thumbnail-jobs").find("#amount").text("0 running thumbnail job(s)")
                        $("#running-place-jobs").removeClass("d-none")
                        $("#running-place-jobs").find("#amount").text("0 running place job(s)")

                        if (!$(".arbiter-output").hasClass("blinking")) {
                            $(".arbiter-output").removeClass("offline-output")
                            $(".arbiter-output").addClass("blinking")
                            $(".arbiter-output").find("img").addClass("d-none")
                            $("#timestamp").removeClass("d-none")
                            $(".arbiter-output").find("#content").removeClass("d-none")
                        }

                        if ($("#cpu-usage").hasClass("d-none")) {
                            /*
                            $("#cpu-usage").removeClass("d-none")
                            $("#cpu-usage").parent().find("i").addClass("d-none")
                            $("#ram-usage").removeClass("d-none")
                            $("#ram-usage").parent().find("i").addClass("d-none")
                            $("#network-usage").removeClass("d-none")
                            $("#network-usage").parent().find("i").addClass("d-none")
                            */
                            $("#grafana").removeClass("d-none")
                        }

                        if ($("#shutdown").hasAttr("disabled")) $("#shutdown").removeAttr("disabled")
                        if ($("#sleep").hasAttr("disabled")) $("#sleep").removeAttr("disabled")

                        break
                    case 1:
                        $("#status").attr("class", "d-flex align-items-center text-muted")
                        $("#status").find("span").text("Offline")

                        if ($(".arbiter-output").hasClass("blinking")) {
                            $(".arbiter-output").addClass("offline-output")
                            $(".arbiter-output").removeClass("blinking")
                            $(".arbiter-output").find("img").removeClass("d-none")
                            $("#timestamp").addClass("d-none")
                            $(".arbiter-output").find("#content").html("")
                            $(".arbiter-output").find("#content").addClass("d-none")
                        }

                        if (!$("#cpu-usage").hasClass("d-none")) {
                            /*
                            $("#cpu-usage").addClass("d-none")
                            $("#cpu-usage").parent().find("i").removeClass("d-none")
                            $("#ram-usage").addClass("d-none")
                            $("#ram-usage").parent().find("i").removeClass("d-none")
                            $("#network-usage").addClass("d-none")
                            $("#network-usage").parent().find("i").removeClass("d-none")
                            */
                            $("#grafana").addClass("d-none")
                        }

                        $("#running-thumbnail-jobs").addClass("d-none")
                        $("#running-place-jobs").addClass("d-none")

                        if (!$("#shutdown").hasAttr("disabled")) $("#shutdown").attr("disabled", "")
                        if (!$("#sleep").hasAttr("disabled")) $("#sleep").attr("disabled", "")

                        break
                }

                $("#friendly_name").text(data.friendly_name)
                $("#utc_offset").text("UTC" + data.utc_offset.slice(0, -3))
            })
    }
}
