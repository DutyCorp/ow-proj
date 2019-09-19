/*function log() {
    var el = document.createElement('div');
    el.innerHTML = Array.prototype.join.call(arguments, '<br />');
        document.getElementById('js-log').appendChild(el);
}*/

var register = null;

if (navigator.serviceWorker) {
    //log("Browser supports Service Worker");
    /*if (navigator.serviceWorker.current) {
        log("Current Service Worker state: \\o/");
        log('Go to chrome://serviceworker-internals/ or about:serviceworkers to see Service Worker debug output');
    } else {
        log("No Service Worker active...");
    }*/

    //document.getElementById('swinstall').addEventListener('click', function () {
        console.log('About to try to install a Service Worker');
        navigator.serviceWorker.register('/js/lib/swcore.js', {
            scope: '/js/lib/swcore.js'
        })
            .then(function (serviceWorker) {
            register = serviceWorker;
            console.log('Successfully installed ServiceWorker');
        console.log('Go to chrome://serviceworker-internals/ or about:serviceworkers to see Service Worker debug output');
            serviceWorker.addEventListener('statechange', function (event) {
                console.log("Worker state is now " + event.target.state);
            });
        }, function (why) {
            console.log('Failed to install:' + why);
        });
    //});
    /*document.getElementById('swuninstall').addEventListener('click', function () {
        log('About to try to uninstall a Service worker');
        register.unregister()
            .then(function () {
            log('Successfully uninstalled ServiceWorker');
        }, function (why) {
            log('Failed to uninstall' + why);
        });
    });*/
} else {
    console.log("Browser does not support Service Worker, are you using Chrome Canary?  Is the Service Worker flag switched on? chrome://flags/#enable-service-worker");
}