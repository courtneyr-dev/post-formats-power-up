<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Gallery Post Format Pattern
 *
 * Image gallery post. Starts with a gallery block followed by a paragraph.
 *
 * @package PostFormatsBlockThemes
 * @since 1.0.0
 */
?>
<!-- wp:gallery {"linkTo":"none"} -->
<figure class="wp-block-gallery has-nested-images columns-default is-cropped"></figure>
<!-- /wp:gallery -->

<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph -->
