<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Audio Post Format Pattern
 *
 * Audio file or embed. Starts with a core audio block followed by a paragraph.
 * Can be swapped with Podlove Podcast Publisher or Able Player blocks.
 *
 * @package PostFormatsBlockThemes
 * @since 1.0.0
 */
?>
<!-- wp:audio -->
<figure class="wp-block-audio"><audio controls></audio></figure>
<!-- /wp:audio -->

<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph -->
