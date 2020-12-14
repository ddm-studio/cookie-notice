{{ if cookie-notice-show }}
<div class="cookie-notice-bg" style="display: none;">
	<div class="cookie-notice-pos">
		<div class="cookie-notice-container">
			<div class="content">
				<h2>{{ cookie-notice-title }}</h2>
				<div class="title-spacer"></div>
				<p>{{ cookie-notice-text }}</p>
				<div class="text-spacer"></div>
				{{ cookie-consent-classes }}
				<div class="cookie-consent-class checkbox centered">
					<input type="checkbox" id="cookie-consent-{{ slug }}" name="{{ slug }}" {{ if required }}disabled checked{{ /if }}>
					<label for="cookie-consent-{{ slug }}">{{ title }}</label>
					<div class="checkbox-spacer"></div>
				</div>
				{{ /cookie-consent-classes }}
				<div class="button-spacer"></div>
				<div class="button-container">
					<a id="cookie-notice-button-all" href="/">{{ cookie-notice-button-all }}</a>
					<a id="cookie-notice-button-selected" href="/">{{ cookie-notice-button-selected }}</a>
				</div>
			</div>
		</div>
	</div>
</div>
{{ if cookie-notice-inline-script }}
<script src="/vendor/ddm-studio/cookie-notice/js/cookie-notice.min.js"></script>
{{ /if }}
{{ else }}
<div class="cookie-notice-disabled" style="display: none;"></div>
{{ /if }}
