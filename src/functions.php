<?php
/**
 * Theme setup
 */
function mytheme_setup() {
	// Document title managed by WP
	add_theme_support( 'title-tag' );

	// Featured images
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'mytheme_setup' );

/**
 * Enqueue styles
 */
function mytheme_enqueue_assets() {
	// Use stylesheet_* so it works for child themes too
	$css_rel_path = '/assets/css/custom.css';
	$css_path     = get_stylesheet_directory() . $css_rel_path; // filesystem path for filemtime
	$css_uri      = get_stylesheet_directory_uri() . $css_rel_path; // URL for enqueue

	$version = file_exists( $css_path ) ? filemtime( $css_path ) : null;

	wp_enqueue_style(
		'theme-custom',
		$css_uri,
		array(),
		$version
	);
}
add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_assets' );

/**
 * Disable the Gutenberg editor
 *
 * @since 1.0.0
*/

add_filter( 'use_block_editor_for_post_type', 'disable_gutenberg', 10, 2 );
function disable_gutenberg() {
	return false;
}

/**
 * Remove default 'posts' from admin
 *
 * @since 1.0.0
 */

add_filter(
	'register_post_type_args',
	function ( $args, $post_type ) {
		if ( $post_type !== 'post' ) {
			return $args;
		}

		// Hide everywhere and remove capabilities from the UI
		$args['public']              = false;
		$args['publicly_queryable']  = false;
		$args['exclude_from_search'] = true;
		$args['show_ui']             = false;
		$args['show_in_menu']        = false;
		$args['show_in_admin_bar']   = false;
		$args['show_in_nav_menus']   = false;
		$args['show_in_rest']        = false; // hides from the block editor and REST API
		$args['has_archive']         = false;
		$args['rewrite']             = false; // remove post permalinks
		$args['supports']            = array();    // no title, editor, etc.

		return $args;
	},
	10,
	2
);

/**
 * Remove the "Posts" menu as a belt and braces measure.
 */
add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit.php' ); // Posts
	},
	999
);

/**
 * Kill direct access to post screens if someone knows the URL.
 */
add_action(
	'load-edit.php',
	function () {
		if ( isset( $_GET['post_type'] ) && $_GET['post_type'] === 'post' ) {
			wp_die( 'Posts are disabled.' );
		}
	}
);

add_action(
	'load-post-new.php',
	function () {
		global $typenow;
		if ( $typenow === 'post' ) {
			wp_die( 'Posts are disabled.' );
		}
	}
);

/**
 * Photos Custom Post Type
 *
 * @since 1.0.0
 */

function rr_register_photos_cpt() {
	$labels = array(
		'name'                  => _x( 'Photos', 'Post Type General Name', 'richonrails' ),
		'singular_name'         => _x( 'Photo', 'Post Type Singular Name', 'richonrails' ),
		'menu_name'             => __( 'Photos', 'richonrails' ),
		'name_admin_bar'        => __( 'Photo', 'richonrails' ),
		'add_new'               => __( 'Add New', 'richonrails' ),
		'add_new_item'          => __( 'Add New Photo', 'richonrails' ),
		'edit_item'             => __( 'Edit Photo', 'richonrails' ),
		'new_item'              => __( 'New Photo', 'richonrails' ),
		'view_item'             => __( 'View Photo', 'richonrails' ),
		'view_items'            => __( 'View Photos', 'richonrails' ),
		'search_items'          => __( 'Search Photos', 'richonrails' ),
		'not_found'             => __( 'No photos found', 'richonrails' ),
		'not_found_in_trash'    => __( 'No photos found in Trash', 'richonrails' ),
		'all_items'             => __( 'All Photos', 'richonrails' ),
		'archives'              => __( 'Photo Archives', 'richonrails' ),
		'attributes'            => __( 'Photo Attributes', 'richonrails' ),
		'insert_into_item'      => __( 'Insert into photo', 'richonrails' ),
		'uploaded_to_this_item' => __( 'Uploaded to this photo', 'richonrails' ),
		'parent_item_colon'     => __( 'Parent Photo:', 'richonrails' ),
	);

	$args = array(
		'label'               => __( 'Photos', 'richonrails' ),
		'labels'              => $labels,
		'description'         => __( 'Single photos or photo entries', 'richonrails' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'show_in_rest'        => true, // Gutenberg and REST API
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-image',
		'hierarchical'        => false,
		'supports'            => array(
			'thumbnail',
			'editor',
			'custom-fields',
		),
		'taxonomies'          => array( 'category', 'post_tag' ), // built in cats and tags
		'has_archive'         => true,
		'rewrite'             => array(
			'slug'       => 'photos',
			'with_front' => false,
		),
		'publicly_queryable'  => true,
		'query_var'           => true,
		'can_export'          => true,
		'exclude_from_search' => false,
		'capability_type'     => 'post', // uses regular post capabilities
		'map_meta_cap'        => true,
	);
	register_post_type( 'photo', $args );
}
add_action( 'init', 'rr_register_photos_cpt' );

/**
 * Flush rewrite rules once on theme switch so /photos works
 */
function rr_photos_flush_rewrite() {
	rr_register_photos_cpt();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'rr_photos_flush_rewrite' );

// Optional, make sure thumbnails are on in your theme
add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'post-thumbnails' );
	}
);

/**
 * Time Calculation
 *
 * @since 1.0.0
 */

function post_time_ago( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$time    = get_post_time( 'U', true, $post_id );       // published time (UTC-aware)
	$now     = current_time( 'timestamp' );                // site’s timezone
	$delta   = max( 1, $now - $time );                     // avoid zero/negative

	if ( $delta < MINUTE_IN_SECONDS ) {
		return 'Just now';
	}
	if ( $delta < HOUR_IN_SECONDS ) {
		$m = floor( $delta / MINUTE_IN_SECONDS );
		return $m . 'min ago';
	}
	if ( $delta < DAY_IN_SECONDS ) {
		$h = floor( $delta / HOUR_IN_SECONDS );
		return $h . 'hr' . ( $h > 1 ? 's' : '' ) . ' ago';
	}
	$d = floor( $delta / DAY_IN_SECONDS );
	return $d . ' day' . ( $d > 1 ? 's' : '' ) . ' ago';
}
