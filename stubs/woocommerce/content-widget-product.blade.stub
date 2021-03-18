@php
	if (!defined('ABSPATH')) { exit; }

	global $product;

	if (!is_a($product, 'WC_Product')) { return; }
@endphp

<li>
	{{ do_action('woocommerce_widget_product_item_start', $args) }}

	<a href="{{ esc_url($product->get_permalink()) }}">
		{{ $product->get_image() }}
		<span class="product-title">{{ wp_kses_post($product->get_name()) }}</span>
	</a>

	@if(!empty($show_rating))
		{{ wc_get_rating_html($product->get_average_rating()) }}
	@endif

	{{ $product->get_price_html() }}

	{{ do_action('woocommerce_widget_product_item_end', $args) }}
</li>
