let consentInputs;

$(function () {
    consentInputs = $(".cookie-consent-class input[type=\"checkbox\"]");

    $("#cookie-notice-button-all").on("touch click", function (e) {
        e.preventDefault();

        checkAllConsentClasses();

        finalizeConsentSettings();
    });

    $("#cookie-notice-button-selected").on("touch click", function (e) {
        e.preventDefault();

        finalizeConsentSettings();
    });

    if (!hasConsented("showed")) {
        showCookieNotice();
    }
});

/**
 * Displays the cookie notice.
 */
function showCookieNotice() {
    $(".cookie-notice-bg").show();

    // Check all previously checked consents, except the ones which are required anyways
    $(".cookie-consent-class input[type=\"checkbox\"]:not(:checked)").each(function (i, el) {
        $(el).prop("checked", hasConsented($(el).prop("name")));
    });
}

/**
 * Hides the cookie notice.
 */
function hideCookieNotice() {
    $(".cookie-notice-bg").hide();
}

/**
 * Checks all consent checkboxes at once.
 */
function checkAllConsentClasses() {
    if (consentInputs instanceof jQuery) {
        consentInputs.each(function (i, el) {
            $(el).prop("checked", "true");
        });
    }
}

/**
 * Sets and pushes consent for all consent classes.
 */
function pushConsentSettings() {
    if (consentInputs instanceof jQuery) {
        consentInputs.each(function (i, el) {
            let consentClass = $(el).prop("name");

            // window.dataLayer.push({
            //     event: "" + consentClass + "Trigger"
            // });

            setConsent(consentClass, $(el).prop("checked"));
        });
    }

    setConsent("showed", "true");
}

/**
 * Finalizes interaction with the consent modal.
 */
function finalizeConsentSettings() {
    pushConsentSettings();

    setTimeout(hideCookieNotice, 400);
}

/**
 * Checks whether the consent class has already been consented to or not.
 *
 * @param consentClass the consent class to check for
 * @returns {boolean} whether the consent class has been consented to
 */
function hasConsented(consentClass) {
    return Cookies.get("cookie-consent-" + consentClass) === "true";
}

/**
 * Sets the consent class to a boolean value.
 *
 * @param consentClass the consent class to set
 * @param hasConsent string or boolean
 */
function setConsent(consentClass, hasConsent) {
    Cookies.set("cookie-consent-" + consentClass, (hasConsent === true || hasConsent === "true"), {expires: 365});
}
