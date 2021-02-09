{{ if cookie-notice-show }}
<div class="ddmcn-bg" style="display: none;opacity: 0;">
	<div class="ddmcn-pos">
		<div class="ddmcn-container">
			<div class="content">
				<h2>{{ cookie-notice-title }}</h2>
				<div class="title-spacer"></div>
				<p>{{ cookie-notice-text }}</p>
				<div class="text-spacer"></div>
				{{ cookie-types }}
				<div class="cookie-types checkbox">
					<input type="checkbox" id="cookie-type-{{ slug }}" name="{{ slug }}" {{ if required }}disabled checked{{ /if }}>
					<label for="cookie-type-{{ slug }}">{{ title }}</label>
					<div class="checkbox-spacer"></div>
				</div>
				{{ /cookie-types }}
				<div class="button-spacer"></div>
				<div class="button-container">
					<button class="button" id="ddmcn-button-all">{{ cookie-notice-button-all }}</button>
					<button class="button" id="ddmcn-button-selected">{{ cookie-notice-button-selected }}</button>
				</div>
			</div>
		</div>
	</div>
</div>
{{ if !cookie-notice-custom-script }}
<script src="/vendor/ddm-studio/cookie-notice/js/cookie-notice.min.js"></script>
<script>{{ js_snippet }}</script>
{{ /if }}
{{ else }}
<div class="ddmcn-disabled" style="display: none;"></div>
{{ /if }}
