$(function () {

    if ($("#navbar").length == 0) {
        return;
    }

    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }

    function loadNotifications() {

        $.get("/site/browser-notification", function (res) {

            // Sirf jab notification ho tab log karo
            if (!res.success) {
                return;
            }

            console.log("Notification Received:", res);

            new Notification(res.title, {
                body: res.body
            });

        }).fail(function () {
            console.log("Notification request failed");
        });

    }

    loadNotifications();

    setInterval(loadNotifications, 3000);

});