<?php
if ( ! lsvr_shortcode_exists( 'lsvr_video' ) && ! function_exists( 'lsvr_video_shortcode' ) ) {

    function lsvr_video_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_video' => array(
                    'name' => __( 'Video', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
					'description' => __( 'Insert the embed code of the video inside the shortcode (after clicking on \"Add Shortcode\").', 'lsvr-toolkit' ),
                    'atts' => array(
                        'inview_anim' => array(
                            'label' => __( 'InView Animation', 'lsvr-toolkit' ),
                            'description' => __( 'Animation fired when element appears in the user\'s viewport.', 'lsvr-toolkit' ),
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

		//$embed_code = htmlspecialchars( $args['embed_code'] );
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

		$embed_code = str_replace( '&#8221;', '"', $content );
		$embed_code = str_replace( '&#8243;', '"', $embed_code );
		$embed_code = htmlspecialchars_decode( $embed_code );

        $html = '<div class="c-video ' . $classes . '" ' . $inview_anim_data . '><div class="embed-video">';
		$html .= $embed_code;
		$html .= '</div></div>';

        return $html;

    }
    add_shortcode( 'lsvr_video', 'lsvr_video_shortcode' );

}
?>