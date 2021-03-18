@php if (!defined('ABSPATH')) { exit; } @endphp

<form role="search" method="get" class="woocommerce-product-search" action="{{ esc_url(home_url('/')) }}">

  <label class="screen-reader-text" for="woocommerce-product-search-field-{{ isset($index) ? absint($index) : 0 }}">
    {{ esc_html_e('Search for:', 'woocommerce') }}
  </label>

  <input type="search" class="search-field" value="{{ get_search_query() }}" name="s"
         id="woocommerce-product-search-field-{{ isset($index) ? absint($index) : 0 }}"
         placeholder="{{ esc_attr__('Search products&hellip;', 'woocommerce') }}">

  <button type="submit" value="{{ esc_attr_x('Search', 'submit button', 'woocommerce') }}">
    {{ esc_html_x('Search', 'submit button', 'woocommerce') }}
  </button>

  <input type="hidden" name="post_type" value="product">
</form>
