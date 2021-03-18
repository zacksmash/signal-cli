@php
	defined('ABSPATH') || exit;

	do_action('woocommerce_widget_price_filter_start', $args);
@endphp

<form method="get" action="{{ esc_url($form_action) }}">
	<div class="price_slider_wrapper">
		<div class="price_slider" style="display: none;"></div>

		<div class="price_slider_amount" data-step="{{ esc_attr($step) }}">

			<input type="text" id="min_price" name="min_price" value="{{ esc_attr($current_min_price) }}" data-min="{{ esc_attr($min_price) }}" placeholder="{{ esc_attr__('Min price', 'woocommerce') }}" />

			<input type="text" id="max_price" name="max_price" value="{{ esc_attr($current_max_price) }}" data-max="{{ esc_attr($max_price) }}" placeholder="{{ esc_attr__('Max price', 'woocommerce') }}" />

			<button type="submit" class="button">{{ esc_html__('Filter', 'woocommerce') }}</button>

			<div class="price_label" style="display: none;">
				{{ esc_html__('Price:', 'woocommerce') }} <span class="from"></span> &mdash; <span class="to"></span>
			</div>

			{{ wc_query_string_form_fields(null, array('min_price', 'max_price', 'paged'), '', true) }}

			<div class="clear"></div>
		</div>
	</div>
</form>

{{ do_action('woocommerce_widget_price_filter_end', $args) }}
