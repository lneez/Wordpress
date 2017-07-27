<?php
if ( ! lsvr_shortcode_exists( 'lsvr_custom_object' ) && ! function_exists( 'lsvr_custom_object_shortcode' ) ) {

    function lsvr_custom_object_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_custom_object' => array(
                    'name' => __( 'Custom Object', 'lsvr-toolkit' ),
                    'description' => __( '<strong>Custom Object</strong> doesn\'t have any default styles or functionality. It can be used for grouping multiple components.', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
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
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

		$classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        return '<div class="c-custom-object ' . $classes . '"' . $inview_anim_data . '>' . do_shortcode( $content ) . '</div>';

    }
    add_shortcode( 'lsvr_custom_object', 'lsvr_custom_object_shortcode' );

}
?>