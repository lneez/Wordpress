<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Alert Message', 'lsvr-toolkit' ),
	'description' => __( 'Notification box', 'lsvr-toolkit' ),
    'base' => 'lsvr_alert_message',
	'icon' => 'lsvr-vc-ico fa fa-info-circle',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'type',
            'type' => 'dropdown',
            'heading' => __( 'Type', 'lsvr-toolkit' ),
			'value' => array( __( 'Warning', 'lsvr-toolkit' ) => 'warning', __( 'Success', 'lsvr-toolkit' ) => 'success', __( 'Info', 'lsvr-toolkit' ) => 'info', __( 'Notification', 'lsvr-toolkit' ) => 'notification' )
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'closable',
            'type' => 'checkbox',
            'heading' => __( 'Closable', 'lsvr-toolkit' ),
			'value' => array( __( 'Yes', 'lsvr-toolkit' ) => 'yes' )
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