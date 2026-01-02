<?php
/**
 * Webmention Context for Post Formats
 *
 * Provides format-specific webmention context for sending and receiving
 * webmentions based on post format semantics.
 *
 * @package PostFormatsBlockThemes
 * @since 1.2.0
 *
 * @see https://indieweb.org/Webmention
 * @see https://www.w3.org/TR/webmention/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Webmention Context
 *
 * Maps post formats to webmention interaction types and provides
 * context for webmention sending and display.
 *
 * @since 1.2.0
 */
class PFBT_Webmention_Context {

	/**
	 * Singleton instance
	 *
	 * @var PFBT_Webmention_Context|null
	 */
	private static $instance = null;

	/**
	 * Format context mappings
	 *
	 * @var array
	 */
	private $format_contexts = array();

	/**
	 * Get singleton instance
	 *
	 * @since 1.2.0
	 *
	 * @return PFBT_Webmention_Context
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
		$this->init_format_contexts();
	}

	/**
	 * Initialize format context mappings
	 *
	 * @since 1.2.0
	 */
	private function init_format_contexts() {
		$this->format_contexts = array(
			'standard' => array(
				'send_as'      => 'mention',
				'accept_types' => array( 'like', 'repost', 'reply', 'mention', 'bookmark' ),
				'properties'   => array(
					'in-reply-to' => false,
					'like-of'     => false,
					'repost-of'   => false,
					'bookmark-of' => false,
				),
				'description'  => __( 'Standard posts send as mentions and accept all interaction types.', 'post-formats-for-block-themes' ),
			),
			'aside'    => array(
				'send_as'      => 'note',
				'accept_types' => array( 'like', 'repost', 'reply' ),
				'properties'   => array(
					'in-reply-to' => true,
				),
				'description'  => __( 'Asides are notes, often replies. Can be in-reply-to another post.', 'post-formats-for-block-themes' ),
			),
			'status'   => array(
				'send_as'      => 'note',
				'accept_types' => array( 'like', 'repost', 'reply' ),
				'properties'   => array(
					'in-reply-to' => true,
				),
				'description'  => __( 'Status updates are short notes. Can be in-reply-to another post.', 'post-formats-for-block-themes' ),
			),
			'quote'    => array(
				'send_as'      => 'quotation',
				'accept_types' => array( 'like', 'repost', 'reply', 'mention' ),
				'properties'   => array(
					'quotation-of' => true,
				),
				'description'  => __( 'Quotes send as quotations with quotation-of property.', 'post-formats-for-block-themes' ),
			),
			'link'     => array(
				'send_as'      => 'bookmark',
				'accept_types' => array( 'like', 'reply' ),
				'properties'   => array(
					'bookmark-of' => true,
				),
				'description'  => __( 'Link posts send as bookmarks with bookmark-of property.', 'post-formats-for-block-themes' ),
			),
			'image'    => array(
				'send_as'      => 'photo',
				'accept_types' => array( 'like', 'repost', 'reply', 'mention' ),
				'properties'   => array(
					'photo' => true,
				),
				'description'  => __( 'Image posts send as photos with u-photo property.', 'post-formats-for-block-themes' ),
			),
			'gallery'  => array(
				'send_as'      => 'photo',
				'accept_types' => array( 'like', 'repost', 'reply', 'mention' ),
				'properties'   => array(
					'photo' => true,
				),
				'description'  => __( 'Gallery posts send as multi-photos with u-photo properties.', 'post-formats-for-block-themes' ),
			),
			'video'    => array(
				'send_as'      => 'video',
				'accept_types' => array( 'like', 'repost', 'reply', 'mention' ),
				'properties'   => array(
					'video' => true,
				),
				'description'  => __( 'Video posts send as video with u-video property.', 'post-formats-for-block-themes' ),
			),
			'audio'    => array(
				'send_as'      => 'audio',
				'accept_types' => array( 'like', 'repost', 'reply', 'mention' ),
				'properties'   => array(
					'audio' => true,
				),
				'description'  => __( 'Audio posts send as audio with u-audio property.', 'post-formats-for-block-themes' ),
			),
			'chat'     => array(
				'send_as'      => 'mention',
				'accept_types' => array( 'like', 'reply', 'mention' ),
				'properties'   => array(),
				'description'  => __( 'Chat transcripts send as mentions.', 'post-formats-for-block-themes' ),
			),
		);

		/**
		 * Filter format webmention contexts.
		 *
		 * @since 1.2.0
		 *
		 * @param array $format_contexts The format context mappings.
		 */
		$this->format_contexts = apply_filters( 'pfbt_webmention_contexts', $this->format_contexts );
	}

	/**
	 * Get webmention context for a format
	 *
	 * @since 1.2.0
	 *
	 * @param string $format Post format slug.
	 * @return array Context configuration.
	 */
	public function get_context( $format ) {
		if ( empty( $format ) || false === $format ) {
			$format = 'standard';
		}

		$context = $this->format_contexts[ $format ] ?? $this->format_contexts['standard'];

		return array(
			'format'       => $format,
			'send_as'      => $context['send_as'],
			'accept_types' => $context['accept_types'],
			'properties'   => $context['properties'],
			'description'  => $context['description'],
		);
	}

	/**
	 * Get send-as type for a format
	 *
	 * @since 1.2.0
	 *
	 * @param string $format Post format slug.
	 * @return string Webmention send type.
	 */
	public function get_send_as( $format ) {
		$context = $this->get_context( $format );
		return $context['send_as'];
	}

	/**
	 * Get accepted interaction types for a format
	 *
	 * @since 1.2.0
	 *
	 * @param string $format Post format slug.
	 * @return array Accepted interaction types.
	 */
	public function get_accept_types( $format ) {
		$context = $this->get_context( $format );
		return $context['accept_types'];
	}

	/**
	 * Check if format accepts an interaction type
	 *
	 * @since 1.2.0
	 *
	 * @param string $format           Post format slug.
	 * @param string $interaction_type Interaction type (like, repost, reply, etc.).
	 * @return bool Whether the format accepts this interaction type.
	 */
	public function accepts_type( $format, $interaction_type ) {
		$accept_types = $this->get_accept_types( $format );
		return in_array( $interaction_type, $accept_types, true );
	}

	/**
	 * Get all format contexts
	 *
	 * @since 1.2.0
	 *
	 * @return array All format context mappings.
	 */
	public function get_all_contexts() {
		return $this->format_contexts;
	}

	/**
	 * Get webmention display configuration for a format
	 *
	 * @since 1.2.0
	 *
	 * @param string $format Post format slug.
	 * @return array Display configuration.
	 */
	public function get_display_config( $format ) {
		$context = $this->get_context( $format );

		$config = array(
			'format'        => $format,
			'show_facepile' => true,
			'sections'      => array(),
		);

		// Build sections based on accepted types.
		foreach ( $context['accept_types'] as $type ) {
			switch ( $type ) {
				case 'like':
					$config['sections']['likes'] = array(
						'title'    => __( 'Likes', 'post-formats-for-block-themes' ),
						'icon'     => 'heart',
						'display'  => 'facepile',
						'priority' => 10,
					);
					break;

				case 'repost':
					$config['sections']['reposts'] = array(
						'title'    => __( 'Reposts', 'post-formats-for-block-themes' ),
						'icon'     => 'share',
						'display'  => 'facepile',
						'priority' => 20,
					);
					break;

				case 'reply':
					$config['sections']['replies'] = array(
						'title'    => __( 'Replies', 'post-formats-for-block-themes' ),
						'icon'     => 'comment',
						'display'  => 'full',
						'priority' => 30,
					);
					break;

				case 'mention':
					$config['sections']['mentions'] = array(
						'title'    => __( 'Mentions', 'post-formats-for-block-themes' ),
						'icon'     => 'link',
						'display'  => 'list',
						'priority' => 40,
					);
					break;

				case 'bookmark':
					$config['sections']['bookmarks'] = array(
						'title'    => __( 'Bookmarks', 'post-formats-for-block-themes' ),
						'icon'     => 'bookmark',
						'display'  => 'facepile',
						'priority' => 15,
					);
					break;
			}
		}

		// Sort sections by priority.
		uasort(
			$config['sections'],
			function ( $a, $b ) {
				return $a['priority'] - $b['priority'];
			}
		);

		/**
		 * Filter webmention display configuration.
		 *
		 * @since 1.2.0
		 *
		 * @param array  $config The display configuration.
		 * @param string $format The post format.
		 */
		return apply_filters( 'pfbt_webmention_display_config', $config, $format );
	}

	/**
	 * Check if Webmention plugin is active
	 *
	 * @since 1.2.0
	 *
	 * @return bool Whether the Webmention plugin is active.
	 */
	public static function is_webmention_active() {
		return class_exists( 'Webmention_Plugin' ) || function_exists( 'webmention_init' );
	}

	/**
	 * Check if Semantic Linkbacks plugin is active
	 *
	 * @since 1.2.0
	 *
	 * @return bool Whether Semantic Linkbacks is active.
	 */
	public static function is_semantic_linkbacks_active() {
		return class_exists( 'Semantic_Linkbacks_Plugin' );
	}
}
