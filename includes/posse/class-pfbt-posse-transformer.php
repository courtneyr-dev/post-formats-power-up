<?php
/**
 * POSSE Transformer for Post Formats
 *
 * Prepares post content for POSSE (Publish Own Site, Syndicate Elsewhere)
 * syndication to various platforms.
 *
 * @package PostFormatsBlockThemes
 * @since 1.2.0
 *
 * @see https://indieweb.org/POSSE
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * POSSE Transformer
 *
 * Transforms post content for syndication to various platforms.
 * Handles format-specific transformations and character limits.
 *
 * @since 1.2.0
 */
class PFBT_Posse_Transformer {

	/**
	 * Singleton instance
	 *
	 * @var PFBT_Posse_Transformer|null
	 */
	private static $instance = null;

	/**
	 * Syndication targets
	 *
	 * @var array
	 */
	private $targets = array();

	/**
	 * Get singleton instance
	 *
	 * @since 1.2.0
	 *
	 * @return PFBT_Posse_Transformer
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.2.0
	 */
	private function __construct() {
		$this->init_targets();
	}

	/**
	 * Initialize syndication targets
	 *
	 * @since 1.2.0
	 */
	private function init_targets() {
		$this->targets = array(
			'twitter'  => array(
				'id'          => 'twitter',
				'name'        => 'Twitter/X',
				'char_limit'  => 280,
				'media_types' => array( 'image', 'video', 'gif' ),
				'url_length'  => 23,
			),
			'mastodon' => array(
				'id'          => 'mastodon',
				'name'        => 'Mastodon',
				'char_limit'  => 500,
				'media_types' => array( 'image', 'video', 'audio' ),
				'url_length'  => 23,
			),
			'bluesky'  => array(
				'id'          => 'bluesky',
				'name'        => 'Bluesky',
				'char_limit'  => 300,
				'media_types' => array( 'image' ),
				'url_length'  => 0,
			),
			'threads'  => array(
				'id'          => 'threads',
				'name'        => 'Threads',
				'char_limit'  => 500,
				'media_types' => array( 'image', 'video' ),
				'url_length'  => 0,
			),
			'linkedin' => array(
				'id'          => 'linkedin',
				'name'        => 'LinkedIn',
				'char_limit'  => 3000,
				'media_types' => array( 'image', 'video', 'document' ),
				'url_length'  => 0,
			),
			'tumblr'   => array(
				'id'          => 'tumblr',
				'name'        => 'Tumblr',
				'char_limit'  => 0,
				'media_types' => array( 'image', 'video', 'audio' ),
				'url_length'  => 0,
			),
		);

		/**
		 * Filter available POSSE targets.
		 *
		 * @since 1.2.0
		 *
		 * @param array $targets The syndication targets.
		 */
		$this->targets = apply_filters( 'pfbt_posse_targets', $this->targets );
	}

	/**
	 * Get all syndication targets
	 *
	 * @since 1.2.0
	 *
	 * @return array Syndication targets.
	 */
	public function get_targets() {
		return array_values( $this->targets );
	}

	/**
	 * Get a specific target
	 *
	 * @since 1.2.0
	 *
	 * @param string $target_id Target ID.
	 * @return array|null Target configuration or null.
	 */
	public function get_target( $target_id ) {
		return $this->targets[ $target_id ] ?? null;
	}

	/**
	 * Prepare post for POSSE syndication
	 *
	 * @since 1.2.0
	 *
	 * @param WP_Post $post    The post to prepare.
	 * @param array   $targets Target platforms (optional).
	 * @return array Prepared content for each target.
	 */
	public function prepare( $post, $targets = array() ) {
		$post = get_post( $post );
		if ( ! $post ) {
			return array();
		}

		$format = get_post_format( $post->ID );
		if ( false === $format ) {
			$format = 'standard';
		}

		// If no specific targets, prepare generic content.
		if ( empty( $targets ) ) {
			return $this->prepare_generic( $post, $format );
		}

		$prepared = array();
		foreach ( $targets as $target_id ) {
			$target = $this->get_target( $target_id );
			if ( $target ) {
				$prepared[ $target_id ] = $this->prepare_for_target( $post, $format, $target );
			}
		}

		return $prepared;
	}

	/**
	 * Prepare generic POSSE content
	 *
	 * @since 1.2.0
	 *
	 * @param WP_Post $post   The post.
	 * @param string  $format Post format.
	 * @return array Prepared content.
	 */
	private function prepare_generic( $post, $format ) {
		$content = $this->get_format_content( $post, $format );
		$media   = $this->extract_media( $post, $format );
		$url     = get_permalink( $post );

		return array(
			'text'       => $content,
			'url'        => $url,
			'media'      => $media,
			'char_count' => mb_strlen( $content ),
			'format'     => $format,
		);
	}

	/**
	 * Prepare content for a specific target
	 *
	 * @since 1.2.0
	 *
	 * @param WP_Post $post   The post.
	 * @param string  $format Post format.
	 * @param array   $target Target configuration.
	 * @return array Prepared content.
	 */
	private function prepare_for_target( $post, $format, $target ) {
		$content    = $this->get_format_content( $post, $format );
		$media      = $this->extract_media( $post, $format );
		$url        = get_permalink( $post );
		$char_limit = $target['char_limit'];
		$url_length = $target['url_length'] > 0 ? $target['url_length'] : mb_strlen( $url );

		// Filter media by supported types.
		$media = $this->filter_media_for_target( $media, $target );

		// Truncate content if needed.
		if ( $char_limit > 0 ) {
			$available_chars = $char_limit - $url_length - 2;
			if ( mb_strlen( $content ) > $available_chars ) {
				$content = $this->truncate_content( $content, $available_chars );
			}
		}

		// Build final text with URL.
		$final_text = trim( $content );
		if ( ! empty( $url ) && $this->should_include_url( $format, $target ) ) {
			$final_text .= "\n\n" . $url;
		}

		return array(
			'text'       => $final_text,
			'url'        => $url,
			'media'      => $media,
			'char_count' => mb_strlen( $final_text ),
			'target'     => $target['id'],
			'valid'      => 0 === $char_limit || mb_strlen( $final_text ) <= $char_limit,
		);
	}

	/**
	 * Get format-appropriate content
	 *
	 * @since 1.2.0
	 *
	 * @param WP_Post $post   The post.
	 * @param string  $format Post format.
	 * @return string Content text.
	 */
	private function get_format_content( $post, $format ) {
		switch ( $format ) {
			case 'status':
			case 'aside':
				// Use content directly for short-form posts.
				return wp_strip_all_tags( $post->post_content );

			case 'quote':
				// Extract quote and attribution.
				return $this->extract_quote_text( $post->post_content );

			case 'link':
				// Use title and excerpt.
				$title = get_the_title( $post );
				return $title;

			case 'image':
			case 'gallery':
			case 'video':
			case 'audio':
				// Use title or excerpt for media posts.
				$title   = get_the_title( $post );
				$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : '';
				return $excerpt ? $excerpt : $title;

			default:
				// Standard posts use title and excerpt.
				$title   = get_the_title( $post );
				$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : '';
				return $excerpt ? $title . ': ' . $excerpt : $title;
		}
	}

	/**
	 * Extract media from post
	 *
	 * @since 1.2.0
	 *
	 * @param WP_Post $post   The post.
	 * @param string  $format Post format.
	 * @return array Media items.
	 */
	private function extract_media( $post, $format ) {
		$media = array();

		// Get featured image.
		if ( has_post_thumbnail( $post ) ) {
			$thumbnail_id  = get_post_thumbnail_id( $post );
			$thumbnail_url = wp_get_attachment_url( $thumbnail_id );
			if ( $thumbnail_url ) {
				$media[] = array(
					'type' => 'image',
					'url'  => $thumbnail_url,
					'id'   => $thumbnail_id,
				);
			}
		}

		// Extract format-specific media.
		switch ( $format ) {
			case 'image':
			case 'gallery':
				$images = $this->extract_images_from_content( $post->post_content );
				foreach ( $images as $image_url ) {
					$media[] = array(
						'type' => 'image',
						'url'  => $image_url,
					);
				}
				break;

			case 'video':
				$videos = $this->extract_videos_from_content( $post->post_content );
				foreach ( $videos as $video_url ) {
					$media[] = array(
						'type' => 'video',
						'url'  => $video_url,
					);
				}
				break;

			case 'audio':
				$audios = $this->extract_audios_from_content( $post->post_content );
				foreach ( $audios as $audio_url ) {
					$media[] = array(
						'type' => 'audio',
						'url'  => $audio_url,
					);
				}
				break;
		}

		// Remove duplicates.
		$unique_media = array();
		$seen_urls    = array();
		foreach ( $media as $item ) {
			if ( ! in_array( $item['url'], $seen_urls, true ) ) {
				$unique_media[] = $item;
				$seen_urls[]    = $item['url'];
			}
		}

		return $unique_media;
	}

	/**
	 * Extract images from content
	 *
	 * @since 1.2.0
	 *
	 * @param string $content Post content.
	 * @return array Image URLs.
	 */
	private function extract_images_from_content( $content ) {
		$images = array();
		if ( preg_match_all( '/<img[^>]+src=["\']([^"\']+)["\']/', $content, $matches ) ) {
			$images = $matches[1];
		}
		return $images;
	}

	/**
	 * Extract videos from content
	 *
	 * @since 1.2.0
	 *
	 * @param string $content Post content.
	 * @return array Video URLs.
	 */
	private function extract_videos_from_content( $content ) {
		$videos = array();

		// Direct video src.
		if ( preg_match_all( '/<video[^>]+src=["\']([^"\']+)["\']/', $content, $matches ) ) {
			$videos = array_merge( $videos, $matches[1] );
		}

		// Source elements.
		if ( preg_match_all( '/<source[^>]+src=["\']([^"\']+)["\'][^>]+type=["\']video/', $content, $matches ) ) {
			$videos = array_merge( $videos, $matches[1] );
		}

		return array_unique( $videos );
	}

	/**
	 * Extract audios from content
	 *
	 * @since 1.2.0
	 *
	 * @param string $content Post content.
	 * @return array Audio URLs.
	 */
	private function extract_audios_from_content( $content ) {
		$audios = array();

		if ( preg_match_all( '/<audio[^>]+src=["\']([^"\']+)["\']/', $content, $matches ) ) {
			$audios = array_merge( $audios, $matches[1] );
		}

		if ( preg_match_all( '/<source[^>]+src=["\']([^"\']+)["\'][^>]+type=["\']audio/', $content, $matches ) ) {
			$audios = array_merge( $audios, $matches[1] );
		}

		return array_unique( $audios );
	}

	/**
	 * Extract quote text from content
	 *
	 * @since 1.2.0
	 *
	 * @param string $content Post content.
	 * @return string Quote text.
	 */
	private function extract_quote_text( $content ) {
		// Look for blockquote content.
		if ( preg_match( '/<blockquote[^>]*>(.*?)<\/blockquote>/s', $content, $matches ) ) {
			$quote = wp_strip_all_tags( $matches[1] );

			// Look for citation.
			if ( preg_match( '/<cite[^>]*>(.*?)<\/cite>/s', $content, $cite_matches ) ) {
				$citation = wp_strip_all_tags( $cite_matches[1] );
				$quote   .= ' — ' . $citation;
			}

			return trim( $quote );
		}

		return wp_strip_all_tags( $content );
	}

	/**
	 * Filter media for target platform
	 *
	 * @since 1.2.0
	 *
	 * @param array $media  Media items.
	 * @param array $target Target configuration.
	 * @return array Filtered media.
	 */
	private function filter_media_for_target( $media, $target ) {
		$supported_types = $target['media_types'];

		return array_filter(
			$media,
			function ( $item ) use ( $supported_types ) {
				return in_array( $item['type'], $supported_types, true );
			}
		);
	}

	/**
	 * Truncate content intelligently
	 *
	 * @since 1.2.0
	 *
	 * @param string $content   Content to truncate.
	 * @param int    $max_chars Maximum characters.
	 * @return string Truncated content.
	 */
	private function truncate_content( $content, $max_chars ) {
		if ( mb_strlen( $content ) <= $max_chars ) {
			return $content;
		}

		// Truncate at word boundary.
		$truncated  = mb_substr( $content, 0, $max_chars - 1 );
		$last_space = mb_strrpos( $truncated, ' ' );

		if ( false !== $last_space && $last_space > $max_chars * 0.8 ) {
			$truncated = mb_substr( $truncated, 0, $last_space );
		}

		return trim( $truncated ) . '…';
	}

	/**
	 * Determine if URL should be included
	 *
	 * @since 1.2.0
	 *
	 * @param string $format Post format.
	 * @param array  $target Target configuration.
	 * @return bool Whether to include URL.
	 */
	private function should_include_url( $format, $target ) {
		// Always include URL except for status/aside on platforms with rich previews.
		if ( in_array( $format, array( 'status', 'aside' ), true ) ) {
			// These are self-contained, but still link back.
			return true;
		}

		return true;
	}
}
