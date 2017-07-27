<?php

global $lsvr_inview_animations_vc;

vc_map( array(
	'weight' => 1000,
	'category' => __( 'Theme Specific', 'lsvr-toolkit' ),
    'name' => __( 'Team Member', 'lsvr-toolkit' ),
	'description' => __( 'Text block with portrait and title', 'lsvr-toolkit' ),
    'base' => 'lsvr_team_member',
	'icon' => 'lsvr-vc-ico fa fa-user',
    'content_element' => true,
    'show_settings_on_create' => true,
    'params' => array(
		array(
			'param_name' => 'portrait',
            'type' => 'attach_image',
            'heading' => __( 'Portrait', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'person_name',
            'type' => 'textfield',
            'heading' => __( 'Name', 'lsvr-toolkit' ),
			'holder' => 'div'
        ),
		array(
			'param_name' => 'description',
            'type' => 'textfield',
            'heading' => __( 'Role', 'lsvr-toolkit' ),
			'description' => __( 'Short text which will be shown under name (e.g. "web designer").', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'content',
            'type' => 'textarea_html',
            'heading' => __( 'Text', 'lsvr-toolkit' ),
        ),
		array(
			'param_name' => 'social_icons',
            'type' => 'textfield',
            'heading' => __( 'Social Icons', 'lsvr-toolkit' ),
			'description' => __( 'Use the following pattern for adding social icons: "<strong>icon_class1,link1|icon_class2,link2</strong>".<br>For example: "<strong>fa fa-twitter,https://twitter.com/MyTwitterProfile|fa fa-facebook,https://www.facebook.com/MyTwitterProfile</strong>".', 'lsvr-toolkit' ),
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