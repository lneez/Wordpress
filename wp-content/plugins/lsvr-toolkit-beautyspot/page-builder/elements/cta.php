<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'CTA', 'lsvr-toolkit' ),
	'description' => __( 'Message with call to action button', 'lsvr-toolkit' ),
    'base' => 'lsvr_cta_message',
	'icon' => 'lsvr-vc-ico fa fa-arrow-circle-right',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'title',
            'type' => 'textfield',
            'heading' => __( 'Title', 'lsvr-toolkit' ),
			'holder' => 'div'
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'button_label',
            'type' => 'textfield',
            'heading' => __( 'Button Label', 'lsvr-toolkit' ),
			'description' => __( 'Leave blank to hide.', 'lsvr-toolkit' ),
        ),
        array(
			'param_name' => 'link',
            'type' => 'textfield',
            'heading' => __( 'Button Link', 'lsvr-toolkit' ),
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