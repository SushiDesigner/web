let participle = [
    "Accelerating",
    "Aggregating",
    "Allocating",
    "Aquiring",
    "Automating",
    "Backtracing",
    "Bloxxing",
    "Bootstraping",
    "Calibrating",
    "Correlating",
    "De-noobing",
    "De-ionizing",
    "Deriving",
    "Energizing",
    "Filtering",
    "Generating",
    "Indexing",
    "Loading",
    "Noobing",
    "Optimizing",
    "Oxidizing",
    "Queueing",
    "Parsing",
    "Processing",
    "Rasterizing",
    "Reading",
    "Registering",
    "Re-routing",
    "Resolving",
    "Sampling",
    "Updating",
    "Writing"
]

let modifier = [
    "Blox",
    "Count Zero",
    "Cylon",
    "Data",
    "Ectoplasm",
    "Encryption",
    "Event",
    "Farnsworth",
    "Bebop",
    "Flux Capacitor",
    "Fusion",
    "Game",
    "Gibson",
    "Host",
    "Mainframe",
    "Metaverse",
    "Nerf Herder",
    "Neutron",
    "Noob",
    "Photon",
    "Profile",
    "Script",
    "Skynet",
    "TARDIS",
    "Virtual"
]

let subject = [
    "Analogs",
    "Blocks",
    "Cannon",
    "Channels",
    "Core",
    "Database",
    "Dimensions",
    "Directives",
    "Engine",
    "Files",
    "Gear",
    "Index",
    "Layer",
    "Matrix",
    "Paradox",
    "Parameters",
    "Parsecs",
    "Pipeline",
    "Players",
    "Ports",
    "Protocols",
    "Reactors",
    "Sphere",
    "Spooler",
    "Stream",
    "Switches",
    "Table",
    "Targets",
    "Throttle",
    "Tokens",
    "Torpedoes",
    "Tubes"
]

function madStatus(lowercase = false) {
    let result = participle[Math.floor(Math.random() * (participle.length))] + " " +
        modifier[Math.floor(Math.random() * (modifier.length))] + " " +
        subject[Math.floor(Math.random() * (subject.length))] + "..."

    if (lowercase) {
        result = result.toLowerCase()
    }

    return result
}

if ($("[data-tadah-magic='register']").length) {
    let form = $("[data-tadah-magic='register']")
    let loading = $("[data-tadah-magic='register-noob']")
    let main = $("[data-tadah-magic='register-main']")
    let validated = false
    let registering = false

    function beginStatus() {
        setInterval(() => {
            $("[data-tadah-magic='state']").find("#text").text(madStatus(true))
        }, 2500)
    }

    function fatal(message) {
        if (!registering) {
            return
        }

        $(main).find(".grecaptcha-badge").css("display", "")
        $(loading).fadeOut(600, 'swing', () => {
            alert(message)
            $(loading).removeClass("add-kebab")
            $(main).removeClass("remove-kebab")

            registering = false
        })
    }

    window.registerCallback = () => {
        if (!validated) {
            return
        }

        registering = true

        beginStatus()

        let wireForm = livewire.find($(form).attr("wire:id"))
        wireForm.set("captcha", grecaptcha.getResponse())
        wireForm.call("register")

        $(loading).find("#register-name").text($("#username").val())
        $(main).find(".grecaptcha-badge").css("display", "none")
        $(main).addClass("remove-kebab")
        $(loading).addClass("add-kebab").fadeIn(600, 'swing', () => {
            $(loading).find("#lie").fadeIn(200)
        })
    }

    window.addEventListener("validated", (event) => {
        validated = event.detail.toString() == "true" ? true : false

        if (!registering) {
            if (validated && $("#register-button").hasAttr("disabled")) {
                $("#register-button").removeAttr("disabled")
            } else if (!validated && !$("#register-button").hasAttr("disabled")) {
                $("#register-button").attr("disabled", "")
            }
        }
    })

    window.addEventListener("fatal", (event) => {
        fatal(event.detail)
    })

    window.addEventListener("register-complete", () => {
        $("#noob").attr("src", tadah.url("/img/noobs/rockinHARD.png"))
        $("[data-tadah-magic='state']").addClass("d-none")
        $("[data-tadah-magic='completed']").removeClass("d-none")

        setTimeout(() => {
            window.location.href = tadah.url("/my/dashboard")
        }, 2500) // 2.5 seconds
    })

    $(document).ready(() => {
        setTimeout(() => {
            $("#register-button").attr("disabled", "")
        }, 200)
    })
}
