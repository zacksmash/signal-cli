@php defined( 'ABSPATH' ) || exit; @endphp

<li>
	{{ do_action('woocommerce_widget_product_review_item_start', $args) }}

	<a href="{!! esc_url(get_comment_link($comment->comment_ID)) !!}">
		{{ $product->get_image() }}
		<span class="product-title">{{ $product->get_name() }}</span>
	</a>

	{{ wc_get_rating_html(intval(get_comment_meta($comment->comment_ID, 'rating', true))) }}

	<span class="reviewer">{{ sprintf(esc_html__('by %s', 'woocommerce'), get_comment_author($comment->comment_ID)) }}</span>

	{{ do_action('woocommerce_widget_product_review_item_end', $args) }}
</li>
