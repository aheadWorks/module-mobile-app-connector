define([
    "jquery"
], function($, config){
        $(document).on('click', '#myappstoreurl', function() {
            var appstoreurlText = document.getElementById("appstoreurl");
            appstoreurlText.select();
            appstoreurlText.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(appstoreurlText.value);
        });

        $(document).on('click', '#mygoogleappurl', function() {
            var googleappurlText = document.getElementById("googleappurl");
            googleappurlText.select();
            googleappurlText.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(googleappurlText.value);
        });
    }
);