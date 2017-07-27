<?php
if ( ! lsvr_shortcode_exists( 'lsvr_cta_message' ) && ! function_exists( 'lsvr_cta_message_shortcode' ) ) {

    function lsvr_cta_message_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_cta_message' => array(
                    'name' => __( 'CTA Message', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'button_label' => array(
                            'label' => __( 'Button Label', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'link' => array(
                            'label' => __( 'Button Link', 'lsvr-toolkit' ),
                            'type' => 'text'
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
                'title' => '',
                'button_label' => '',
                'link' => '',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $title = $args['title'];
        $button_label = $args['button_label'];
        $link = esc_url( $args['link'] );
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

		$classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
        $classes .= $title !== '' ? ' m-has-title ' : '';
        $classes .= $button_label !== '' ? ' m-has-btn ' : '';
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        $html = '<div class="c-cta-message ' . $classes . '" ' . $inview_anim_data . '>';
        $html .= $title !== '' ? '<h3 class="cta-title"><span>' . $title . '</span></h3>' : '';
        $html .= '<div class="various-content">' . wpautop( do_shortcode( $content ) ) . '</div>';
        $html .= $button_label !== '' ? ' <a href="' . $link . '" class="cta-button c-button">' . $button_label . '</a>' : '';
        $html .= '</div>';

        return $html;

    }
    add_shortcode( 'lsvr_cta_message', 'lsvr_cta_message_shortcode' );

}
?>