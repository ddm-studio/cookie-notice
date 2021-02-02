<div id="{{ slug }}" class="cookie-overlay" data-consent-classes="{{ consent-classes }}"
	{{ if background-image }}style="background-image: url('{{ background-image }}');"{{ /if }}>
	<div class="cookie-overlay-container">
		<h2>{{ title }}</h2>
		<div class="title-spacer"></div>
		<p>{{ description }}</p>
		<div class="text-spacer"></div>
		<a id="cookie-overlay-button-accept">{{ cookie-overlay-button-accept }}</a>
	</div>
</div>