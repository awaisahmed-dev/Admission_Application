document.addEventListener('DOMContentLoaded', function () {

    if (!("Notification" in window)) {
        return;
    }

    if (Notification.permission === 'default') {

        Notification.requestPermission()
        .then(function(permission){

            if(permission === 'granted'){

                new Notification(
                    'Notifications Enabled',
                    {
                        body: 'You will now receive notifications.'
                    }
                );

            }

        });

    }

});