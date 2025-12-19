<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Status Post Format Pattern
 *
 * Short status update without title, limited to 280 characters (Twitter-style).
 * Character validation handled by JavaScript.
 *
 * @package PostFormatsBlockThemes
 * @since 1.0.0
 */

// Single paragraph with status-paragraph class for character counter.
?>
<!-- wp:paragraph {"className":"status-paragraph","fontSize":"large"} -->
<p class="status-paragraph has-large-font-size"></p>
<!-- /wp:paragraph -->

