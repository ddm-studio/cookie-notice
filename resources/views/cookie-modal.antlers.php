{{ if active }}
<div class="ddmcm" style="display: none;opacity: 0;">
    <div class="ddmcm-rel">
        <div class="ddmcm-pos">
            <div class="ddmcm-content">
                <h2>{{ modal_title }}</h2>
                <p>{{ modal_description }}</p>
                <div class="ddmcm-classes">
                    {{ classes }}
                    <div class="checkbox">
                        <input type="checkbox" id="cookie-class-{{ handle }}" name="{{ handle }}"{{ if required }} disabled checked{{ /if }}>
                        <label for="cookie-class-{{ handle }}">{{ title }}</label>
                    </div>
                    {{ /classes }}
                </div>
                <div class="buttons">
                    <button id="ddmcm-button-all">{{ modal_button_all }}</button>
                    <button id="ddmcm-button-selected">{{ modal_button_selected }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{ load_code }}
{{ /if }}
