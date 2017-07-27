<?php

/* -----------------------------------------------------------------------------

    SETUP

----------------------------------------------------------------------------- */

// Runs when the plugin is activated
register_activation_hook( __FILE__, 'lsvr_slide_activation' );

// Adds the slider post type and taxonomies
add_action( 'init', 'lsvr_slide_init' );

// Thumbnail support for slider posts
add_theme_support( 'post-thumbnails', array( 'lsvrslide' ) );

// Adds thumbnails to column view
add_filter( 'manage_edit-lsvrslide_columns', 'lsvr_add_thumbnail_column', 10, 1 );
add_action( 'manage_posts_custom_column', 'lsvr_display_thumbnail', 10, 1 );

// Allows filtering of posts by taxonomy in the admin view
add_action( 'restrict_manage_posts', 'lsvr_add_taxonomy_filters' );

// Show slider post counts in the dashboard
add_action( 'right_now_content_table_end', 'lsvr_add_slide_counts' );


/* -----------------------------------------------------------------------------

    INIT

----------------------------------------------------------------------------- */

// Flushes rewrite rules on plugin activation to ensure slider posts don't 404
// http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
function lsvr_slide_activation() {
	lsvr_slide_init();
	flush_rewrite_rules();
}

function lsvr_slide_init() {

	// Enable the Slider custom post type
	// http://codex.wordpress.org/Function_Reference/register_post_type
	$labels = array(
		'name' => __( 'Slides', 'lsvr-toolkit' ),
		'singular_name' => __( 'Slide', 'lsvr-toolkit' ),
		'add_new' => __( 'Add New Slide', 'lsvr-toolkit' ),
		'add_new_item' => __( 'Add New Slide', 'lsvr-toolkit' ),
		'edit_item' => __( 'Edit Slide', 'lsvr-toolkit' ),
		'new_item' => __( 'Add New Slide', 'lsvr-toolkit' ),
		'view_item' => __( 'View Slide', 'lsvr-toolkit' ),
		'search_items' => __( 'Search slides', 'lsvr-toolkit' ),
		'not_found' => __( 'No slides found', 'lsvr-toolkit' ),
		'not_found_in_trash' => __( 'No slides found in trash', 'lsvr-toolkit' ),
	);

	$args = array(
		'labels' => $labels,
		'exclude_from_search' => true,
		'public' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'lsvrslide' ), // Permalinks format
		'menu_position' => 5,
		'has_archive' => false,
		'show_in_nav_menus' => false,
		'menu_icon'=>'dashicons-slides',
	);

	$args = apply_filters( 'lsvrslideposttype_args', $args );

	register_post_type( 'lsvrslide', $args );

	// Register a taxonomy for Slider Groups
	// http://codex.wordpress.org/Function_Reference/register_taxonomy
	$taxonomy_lsvrslider_labels = array(
		'name' => __( 'Sliders', 'lsvr-toolkit' ),
		'singular_name' => __( 'Slider', 'lsvr-toolkit' ),
		'search_items' => __( 'Search Sliders', 'lsvr-toolkit' ),
		'popular_items' => __( 'Popular Sliders', 'lsvr-toolkit' ),
		'all_items' => __( 'All Sliders', 'lsvr-toolkit' ),
		'parent_item' => __( 'Parent Slider', 'lsvr-toolkit' ),
		'parent_item_colon' => __( 'Parent Slider:', 'lsvr-toolkit' ),
		'edit_item' => __( 'Edit Slider', 'lsvr-toolkit' ),
		'update_item' => __( 'Update Slider', 'lsvr-toolkit' ),
		'add_new_item' => __( 'Add New Slider', 'lsvr-toolkit' ),
		'new_item_name' => __( 'New Slider Name', 'lsvr-toolkit' ),
		'separate_items_with_commas' => __( 'Separate sliders with commas', 'lsvr-toolkit' ),
		'add_or_remove_items' => __( 'Add or remove sliders', 'lsvr-toolkit' ),
		'choose_from_most_used' => __( 'Choose from the most used sliders', 'lsvr-toolkit' ),
		'menu_name' => __( 'Sliders', 'lsvr-toolkit' )
	);
	$taxonomy_lsvrslider_args = array(
		'labels' => $taxonomy_lsvrslider_labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'rewrite' => array( 'slug' => 'lsvr_group' ),
		'query_var' => true

	);
	register_taxonomy( 'lsvrslider', array( 'lsvrslide' ), $taxonomy_lsvrslider_args );

}

// Add Columns to Slider Edit Screen
// http://wptheming.com/2010/07/column-edit-pages/
function lsvr_add_thumbnail_column( $columns ) {
	$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'lsvr-toolkit' ) );
	$columns = array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
	return $columns;
}
function lsvr_display_thumbnail( $column ) {
	global $post;
	switch ( $column ) {
		case 'thumbnail':
			echo get_the_post_thumbnail( $post->ID, array( 35, 35 ) );
			break;
	}
}

// Adds taxonomy filters to the slider admin page
// Code artfully lifed from http://pippinsplugins.com
function lsvr_add_taxonomy_filters() {
	global $typenow;

	// An array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array( 'lsvrslider' );

	// must set this to the post type you want the filter(s) displayed on
	if ( $typenow == 'lsvrslide' ) {

		foreach ( $taxonomies as $tax_slug ) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj = get_taxonomy( $tax_slug );
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if ( count( $terms ) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>$tax_name</option>";
				foreach ( $terms as $term ) {
					echo '<option value=' . $term->slug, $current_tax_slug == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
				}
				echo "</select>";
			}
		}
	}
}

// Add Slider count to "Right Now" Dashboard Widget
function lsvr_add_slide_counts() {
	if ( ! post_type_exists( 'lsvrslide' ) ) {
		 return;
	}

	$num_posts = wp_count_posts( 'lsvrslide' );
	$num = number_format_i18n( $num_posts->publish );
	$text = _n( 'Slider Item', 'Slider Items', intval($num_posts->publish) );
	if ( current_user_can( 'edit_posts' ) ) {
		$num = "<a href='edit.php?post_type=lsvrslide'>$num</a>";
		$text = "<a href='edit.php?post_type=lsvrslide'>$text</a>";
	}
	echo '<td class="first b b-lsvrslide">' . $num . '</td>';
	echo '<td class="t lsvrslide">' . $text . '</td>';
	echo '</tr>';

	if ( $num_posts->pending > 0 ) {
		$num = number_format_i18n( $num_posts->pending );
		$text = _n( 'Slider Item Pending', 'Slider Items Pending', intval( $num_posts->pending ) );
		if ( current_user_can( 'edit_posts' ) ) {
			$num = "<a href='edit.php?post_status=pending&post_type=lsvrslide'>$num</a>";
			$text = "<a href='edit.php?post_status=pending&post_type=lsvrslide'>$text</a>";
		}
		echo '<td class="first b b-lsvrslide">' . $num . '</td>';
		echo '<td class="t lsvrslide">' . $text . '</td>';
		echo '</tr>';
	}
}


/* -----------------------------------------------------------------------------

    METABOXES

----------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------
        INIT
    ------------------------------------------------------------------------- */

	add_action( 'add_meta_boxes', 'lsvr_slide_settings_meta_add' );
	function lsvr_slide_settings_meta_add( $post ) {
		add_meta_box(
			'lsvr_slide_settings',
			'Slide Settings',
			'lsvr_slide_settings_meta_content',
			'lsvrslide',
			'normal',
			'high'
		);

	}

	function lsvr_slide_settings_meta_content( $post ) {

		$lsvr_slide_settings_meta = get_post_meta( $post->ID, '_lsvr_slide_settings_meta', true );

		/* -------------------------------------------------------------------------
			VERTICAL ALIGN
		------------------------------------------------------------------------- */

		$active_valign = is_array( $lsvr_slide_settings_meta ) && array_key_exists( 'valign', $lsvr_slide_settings_meta ) ? $lsvr_slide_settings_meta['valign'] : '';

		echo '<p><label for="lsvr_slide_settings_meta_valign"><strong>' . __( 'Vertical Align', 'lsvr-toolkit' ) . '</strong></label></p>';
		echo '<select id="lsvr_slide_settings_meta_valign" name="lsvr_slide_settings_meta_valign">';

		if ( $active_valign === 'top' ) {
			echo '<option value="top" selected="selected">';
		}
		else {
			echo '<option value="top">';
		}
		_e( 'Top', 'lsvr-toolkit' ) . '</option>';

		if ( $active_valign === 'middle' ) {
			echo '<option value="middle" selected="selected">';
		}
		else {
			echo '<option value="middle">';
		}
		_e( 'Middle', 'lsvr-toolkit' ) . '</option>';

		if ( $active_valign === 'bottom' ) {
			echo '<option value="bottom" selected="selected">';
		}
		else {
			echo '<option value="bottom">';
		}
		_e( 'Bottom', 'lsvr-toolkit' ) . '</option>';

		echo '</select>';

	}

    /* -------------------------------------------------------------------------
        SAVE
    ------------------------------------------------------------------------- */

	add_action( 'save_post', 'lsvr_slide_settings_meta_save' );
	function lsvr_slide_settings_meta_save(){

	global $post;
	if( $_POST && isset( $post->ID ) ) {
		$lsvr_slide_settings_meta = array();
		if ( array_key_exists( 'lsvr_slide_settings_meta_valign', $_POST ) ) {
			$lsvr_slide_settings_meta[ 'valign' ] = esc_attr( $_POST['lsvr_slide_settings_meta_valign'] );
		}
		update_post_meta( $post->ID, '_lsvr_slide_settings_meta', $lsvr_slide_settings_meta );
	}

}


?>