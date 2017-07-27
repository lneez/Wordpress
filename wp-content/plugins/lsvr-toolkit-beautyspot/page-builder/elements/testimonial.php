<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvrtheme' ),
    'name' => __( 'Testimonial', 'lsvrtoolkit' ),
	'description' => __( 'Quote block with source', 'lsvrtoolkit' ),
    'base' => 'lsvr_testimonial',
	'icon' => 'lsvr-vc-ico fa fa-quote-left',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'portrait',
            'type' => 'attach_image',
            'heading' => __( 'Portrait', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Quote', 'lsvrtoolkit' ),
        ),
		array(
			'param_name' => 'source',
            'type' => 'textfield',
            'heading' => __( 'Source', 'lsvrtoolkit' ),
			'description' => __( 'You can use some HTML for this field, for example:<br>&lt;strong&gt;John Doe&lt;/strong&gt;, Manager', 'lsvrtoolkit' ),
			'holder' => 'div'
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
            'heading' => __( 'Extra class name', 'lsvrtoolkit' ),
			'description' => __( 'It can be used for applying custom CSS.', 'lsvrtoolkit' ),
        ),
    ),
));

?>