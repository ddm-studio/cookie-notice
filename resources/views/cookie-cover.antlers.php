{{ if active }}
{{ if !{ cookie_notice:hasConsent cookieClasses="{ classes }" } }}
<div class="ddmcc" id="{{ handle }}" data-classes="{{ classes }}" style="display: block;opacity: 100;{{ if bg_image }}background-image: url('{{ bg_image }}'){{ /if }}">
    <div class="ddmcc-pos">
        <div class="ddmcc-content">
            <h2>{{ title }}</h2>
            <p>{{ paragraph }}</p>
            <div class="buttons">
                <button id="ddmcc-button-accept">{{ button_accept }}</button>
            </div>
        </div>
    </div>
</div>
{{ /if }}
{{ /if }}
