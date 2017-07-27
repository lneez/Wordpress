<?php
if ( ! lsvr_shortcode_exists( 'lsvr_alert_message' ) && ! function_exists( 'lsvr_alert_message_shortcode' ) ) {

    function lsvr_alert_message_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_alert_message' => array(
                    'name' => __( 'Alert Message', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'type' => array(
                            'label' => __( 'Type', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'warning' => __( 'Warning', 'lsvr-toolkit' ) , 'success' => __( 'Success', 'lsvr-toolkit' ), 'info' => __( 'Info', 'lsvr-toolkit' ), 'notification' => __( 'Notification', 'lsvr-toolkit' ) )
                        ),
                        'closable' => array(
                            'label' => __( 'Closable', 'lsvr-toolkit' ),
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
                'type' => 'warning',
                'closable' => '',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $type = esc_attr( $args['type'] );
        $closable = esc_attr( $args['closable'] );
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

        if ( $type === 'success' ) {
            $html = '<div class="c-alert-message m-success ' . $classes . '"' . $inview_anim_data . '><i class="ico fa fa-check-circle"></i>';
        }
        elseif ( $type === 'info' ) {
            $html = '<div class="c-alert-message m-info ' . $classes . '"' . $inview_anim_data . '><i class="ico fa fa-info-circle"></i>';
        }
        elseif ( $type === 'notification' ) {
            $html = '<div class="c-alert-message m-notification ' . $classes . '"' . $inview_anim_data . '><i class="ico fa fa-question-circle"></i>';
        }
        else {
            $html = '<div class="c-alert-message m-warning ' . $classes . '"' . $inview_anim_data . '><i class="ico fa fa-exclamation-circle"></i>';
        }
        $html .= '<div class="alert-inner">' . do_shortcode( $content ) . '</div>';

        if ( $closable === 'yes' ) {
            $html .= '<i class="alert-close fa fa-times"></i>';
        }

        $html .= '</div>';

        return $html;

    }
    add_shortcode( 'lsvr_alert_message', 'lsvr_alert_message_shortcode' );

}
?>