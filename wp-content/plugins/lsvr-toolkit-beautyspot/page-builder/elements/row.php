<?php

vc_map_update( 'vc_row', array(
	'weight' => 1020,
	'show_settings_on_create' => true,
));
vc_add_params( 'vc_row', array(
	array(
		'weight' => 100,
		'param_name' => 'wrap_in_section',
		'type' => 'checkbox',
		'heading' => __( 'Wrap in Section', 'lsvrtoolkit' ),
		'description' => __( 'Wrap this row in Section element.', 'lsvrtoolkit' ),
		'value' => array( __( 'Wrap', 'lsvrtheme' ) => 'yes' ),
	),
	array(
		'weight' => 90,
		'param_name' => 'wrap_in_container',
		'type' => 'checkbox',
		'heading' => __( 'Wrap in Container', 'lsvrtoolkit' ),
		'description' => __( 'Enable if you are using Fullsize template and want this Row to be centered.', 'lsvrtoolkit' ),
		'value' => array( __( 'Wrap', 'lsvrtheme' ) => 'yes' ),
	),
	/*array(
		'weight' => 80,
		'param_name' => 'custom_id',
		'type' => 'textfield',
		'heading' => __( 'Custom ID', 'lsvrtoolkit' ),
		'description' => __( 'It can be used for one page navigation.', 'lsvrtoolkit' ),
	),*/
));

?>