if (tadah.session && tadah.session.heartbeat) {
    axios.get("/heartbeat")

    setInterval(() => {
        axios.get("/heartbeat")
    }, 30 * 1000)
}
