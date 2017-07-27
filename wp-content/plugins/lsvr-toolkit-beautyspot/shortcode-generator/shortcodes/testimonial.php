<?php
if ( ! lsvr_shortcode_exists( 'lsvr_testimonial' ) && ! function_exists( 'lsvr_testimonial_shortcode' ) ) {

    function lsvr_testimonial_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_testimonial' => array(
                    'name' => __( 'Testimonial', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'portrait' => array(
                            'label' => __( 'Portrait', 'lsvr-toolkit' ),
                            'type' => 'file'
                        ),
                        'source' => array(
                            'label' => __( 'Source', 'lsvr-toolkit' ),
							'description' => __( 'You can use some HTML for this field, for example:<br>&lt;strong&gt;John Doe&lt;/strong&gt;, Manager', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
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
				'portrait' => '',
                'source' => '',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $source = $args['source'];
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

		// PARSE IMAGE
		$portrait = $args['portrait'];
		if ( (int) $portrait > 0 ) {
			$image_data = lsvr_get_image_data( $portrait );
			if ( $image_data ) {
				$portrait = esc_url( $image_data[ 'medium' ] );
			}
			else {
				$portrait = '';
			}
		}
		else if ( $portrait !== '' ) {
			$portrait = esc_url( $portrait );
		}

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes .= $portrait !== '' ? ' m-has-portrait' : '';
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        $html = '<div class="c-testimonial ' . $classes . '" ' . $inview_anim_data . '><div class="testimonial-inner">';
		$html .= $portrait !== '' ? '<p class="testimonial-portrait"><span><img src="' . $portrait . '" alt=""></span></p>' : '';
		$html .= '<blockquote>' . wpautop( do_shortcode( $content ) );
		$html .= $source !== '' ? '<footer>' . $source . '</footer>' : '';
		$html .= '</blockquote></div></div>';

        return $html;

    }
    add_shortcode( 'lsvr_testimonial', 'lsvr_testimonial_shortcode' );

}
?>