document.addEventListener("DOMContentLoaded", function () {

    if (!("Notification" in window)) {
        console.log("Browser Notification not supported");
        return;
    }

    if (Notification.permission === "default") {

        Notification.requestPermission().then(function (permission) {
            console.log("Permission :", permission);
        });

    } else {

        console.log("Permission :", Notification.permission);

    }

});