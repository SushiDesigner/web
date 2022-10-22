if ($("#sessions").length) {
    $("#sessions").find("[data-tadah-toggle='sign-out']").each(function () {
        $(this).on("click", () => {
            $("#sessions").addClass("blurred")

            axios.post("/my/revoke-session", {
                "key": $(this).attr("data-tadah-key")
            }).then((data) => {
                let response = data.data

                if (response.success) {
                    $(this).closest("#session").remove()
                } else {
                    alert("Unknown error occurred. Please try again.")
                }
            }).catch(() => {
                alert("Unknown error occurred. Please try again.")
            })
        })
    })
}
