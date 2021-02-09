{{ if !{ cookie_notice:hasConsent cookieType="{ consent-classes }" } }}
<div id="{{ slug }}" class="ddmco-bg" data-types="{{ consent-classes }}" style="display: block;opacity: 100;{{ if background-image }}background-image: url('{{ background-image }}');{{ /if }}">
	<div class="ddmco-container">
		<h2>{{ title }}</h2>
		<div class="title-spacer"></div>
		<p>{{ description }}</p>
		<div class="text-spacer"></div>
		<div class="button-container">
            <button class="button" id="ddmco-button-accept">{{ cookie-notice-button-accept }}</button>
        </div>
	</div>
</div>
{{ /if }}
