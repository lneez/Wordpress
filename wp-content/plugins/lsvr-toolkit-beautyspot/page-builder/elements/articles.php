<?php

global $lsvr_inview_animations_vc;

// CATEGORY PAREMETER
$category_param = array();
$categories_tax = get_categories( 'hide_empty=1&hierarchical=0&parent=0' ) ;
if ( count( $categories_tax ) > 0 ) {
	$cat_arr = array( __( 'None', 'lsvr-toolkit' ) => 'none' );
	foreach ( $categories_tax as $value ) {
		$cat_arr[$value->name] = $value->slug;
	}
	$category_param = array(
		'param_name' => 'category',
		'type' => 'dropdown',
		'heading' => __( 'Category', 'lsvr-toolkit' ),
		'description' => __( 'Category to load posts from. Choose <strong>None</strong> to load posts regardless of category.', 'lsvr-toolkit' ),
		'value' => $cat_arr,
	);
}

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Blog', 'lsvr-toolkit' ),
	'description' => __( 'List of latest posts', 'lsvr-toolkit' ),
    'base' => 'lsvr_articles',
	'icon' => 'lsvr-vc-ico fa fa-pencil',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		$category_param,
        array(
			'param_name' => 'number_of_items',
            'type' => 'dropdown',
			'value' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ),
            'heading' => __( 'Number of posts', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'show_post_date',
            'type' => 'checkbox',
            'heading' => __( 'Show Post Date', 'lsvr-toolkit' ),
			'value' => array( __( 'Show', 'lsvr-toolkit' ) => 'show' ),
        ),
        array(
			'param_name' => 'show_post_media',
            'type' => 'checkbox',
            'heading' => __( 'Show Featured Image', 'lsvr-toolkit' ),
			'value' => array( __( 'Show', 'lsvr-toolkit' ) => 'show' ),
        ),
        array(
			'param_name' => 'show_post_excerpt',
            'type' => 'checkbox',
            'heading' => __( 'Show Post Excerpt', 'lsvr-toolkit' ),
			'value' => array( __( 'Show', 'lsvr-toolkit' ) => 'show' ),
        ),
        array(
			'param_name' => 'excerpt_length',
            'type' => 'textfield',
            'heading' => __( 'Excerpt Length', 'lsvr-toolkit' ),
			'value' => 40
        ),
        array(
			'param_name' => 'inview_anim',
            'type' => 'dropdown',
            'heading' => __( 'InView Animation', 'lsvr-toolkit' ),
			'description' => __( 'This animation will fire when element appears in the user\'s viewport.', 'lsvr-toolkit' ),
			'value' => $lsvr_inview_animations_vc,
        ),
        array(
			'param_name' => 'custom_class',
            'type' => 'textfield',
            'heading' => __( 'Extra class name', 'lsvr-toolkit' ),
			'description' => __( 'It can be used for applying custom CSS.', 'lsvr-toolkit' ),
        ),
    ),
));

?>