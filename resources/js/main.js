document.addEventListener('DOMContentLoaded', () => {
    var a = document.createElement('script');
    a.setAttribute('src', '/vendor/ddm-studio/cookie-notice/js/cookie-notice.min.js');
    document.body.appendChild(a);
    window.CookieConsent.registerCallback(() => {
        var loadGoogleMapsApi = () => {
            var script = document.createElement('script');
            script.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAV9RbIMwbbzjai00C93cuzQC_1c_b12yM&callback=InitGoogleMaps');
            document.head.appendChild(script);
        };
        if (document.readyState !== 'loading') loadGoogleMapsApi();
        else document.addEventListener('DOMContentLoaded', loadGoogleMapsApi);
    });
    window.CookieConsent.runCallbacks();
});
