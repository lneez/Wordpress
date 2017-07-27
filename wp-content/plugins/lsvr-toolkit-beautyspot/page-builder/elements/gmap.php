<?php

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Google Map', 'lsvr-toolkit' ),
    'base' => 'lsvr_gmap',
	'icon' => 'lsvr-vc-ico fa fa-map-marker',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'address',
            'type' => 'textfield',
            'heading' => __( 'Address', 'lsvr-toolkit' ),
			'description' => __( 'For example: <em>8833 Sunset Blvd, West Hollywood, CA 90069, USA</em>.', 'lsvr-toolkit' ),
			'holder' => 'div'
        ),
        array(
			'param_name' => 'latitude',
            'type' => 'textfield',
            'heading' => __( 'Latitude', 'lsvr-toolkit' ),
			'description' => __( 'Optional, it can be more precise than using just the address. For example: <em>48.634340</em>.', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'longitude',
            'type' => 'textfield',
            'heading' => __( 'Longitude', 'lsvr-toolkit' ),
			'description' => __( 'Optional, it can be more precise than using just the address. For example: <em>21.929627</em>.', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'type',
            'type' => 'dropdown',
            'heading' => __( 'Map Type', 'lsvr-toolkit' ),
			'value' => array( __( 'Roadmap', 'lsvr-toolkit' ) => 'roadmap', __( 'Satellite', 'lsvr-toolkit' ) => 'satellite' , __( 'Terrain', 'lsvr-toolkit' ) => 'terrain', __( 'Hybrid', 'lsvr-toolkit' ) => 'hybrid' ),
        ),
        array(
			'param_name' => 'zoom',
            'type' => 'dropdown',
            'heading' => __( 'Zoom Level', 'lsvr-toolkit' ),
			'value' => array( __( 'Far', 'lsvr-toolkit' ) => '16', __( 'Medium', 'lsvr-toolkit' ) => '17' , __( 'Default', 'lsvr-toolkit' ) => '18', __( 'Very Close', 'lsvr-toolkit' ) => '19' ),
        ),
        array(
			'param_name' => 'height',
            'type' => 'textfield',
            'heading' => __( 'Height', 'lsvr-toolkit' ),
			'description' => __( 'In pixels.', 'lsvr-toolkit' ),
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