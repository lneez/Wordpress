<?php
if ( ! lsvr_shortcode_exists( 'lsvr_divider' ) && ! function_exists( 'lsvr_divider_shortcode' ) ) {

    function lsvr_divider_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_divider' => array(
                    'name' => __( 'Divider', 'lsvr-toolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'whitespace_size' => array(
                            'label' => __( 'Whitespace Size', 'lsvr-toolkit' ),
                            'description' => __( 'Determines the top and bottom margins of <strong>divider</strong>.', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'm-small' => __( 'Default', 'lsvr-toolkit' ), 'm-x-small' => __( 'Small', 'lsvr-toolkit' ), 'm-medium' => __( 'Medium', 'lsvr-toolkit' ), 'm-large' => __( 'Large', 'lsvr-toolkit' ) ),
							'default' => 'm-small'
                        ),
                        'transparent' => array(
                            'label' => __( 'Transparent', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
							'default' => 'no'
                        ),
                        'inview_anim' => array(
                            'label' => __( 'InView Animation', 'lsvr-toolkit' ),
                            'description' => __( 'This animation will fire when element appears in the user\'s viewport.', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => $lsvr_inview_animations,
                            'default' => 'none'
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvr-toolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvr-toolkit' ),
                            'type' => 'text'
                        )
                    )
                )
            );

        }

        /* ---------------------------------------------------------------------
            Check if shortcode is inline
        --------------------------------------------------------------------- */

        if ( $check_if_inline === true ) {
            return false;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
                'whitespace_size' => 'normal',
				'transparent' => 'no',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $whitespace_size = esc_attr( $args['whitespace_size'] );
		$transparent = esc_attr( $args['transparent'] );
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

		$classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes .= ' ' . $whitespace_size;
		$classes .= $transparent === 'yes' ? ' m-transparent' : '';
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        return '<hr class="c-divider ' . $classes . '" ' . $inview_anim_data . '>';

    }
    add_shortcode( 'lsvr_divider', 'lsvr_divider_shortcode' );

}
?>