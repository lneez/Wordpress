<?php
if ( ! lsvr_shortcode_exists( 'lsvr_image_vc' ) && ! function_exists( 'lsvr_image_vc_shortcode' ) ) {

    function lsvr_image_vc_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

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
                'image' => '',
				'size' => 'medium',
				'max_width' => '',
				'link' => '',
				'rounded' => 'no',
				'lightbox' => 'no',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

		$size = esc_attr( $args['size'] );
		$max_width = esc_attr( $args['max_width'] );
		$link = esc_url( $args['link'] );
		$rounded = esc_attr( $args['rounded'] );
		$rounded = $rounded === 'yes' ? true : false;
		$lightbox = esc_attr( $args['lightbox'] );
		$lightbox = $lightbox === 'yes' ? true : false;
		$inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );
        $image_alt = '';
        $image_caption = '';

		// PARSE IMAGE
		$image_url_full = '';
		$image = $args['image'];
		if ( (int) $image > 0 ) {
			$image_data = lsvr_get_image_data( (int) $image );
			if ( $image_data ) {
				$image_url = esc_url( $image_data[ $size ] );
				$image_url_full = esc_url( $image_data[ 'full' ] );
                $image_alt = $image_data[ 'alt' ];
                $image_caption = $image_data[ 'caption' ];
			}
			else {
				$image_url = '';
			}
		}
		else if ( $image !== '' ) {
			$image_url = esc_url( $image );
		}

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $class = $custom_class;
		$class .= $rounded ? ' rounded' : '';
		$class .= ' ' . $inview_anim_class;
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$html = '<div class="c-image">';
        $html .= $max_width !== '' ? '<div style="max-width: ' . (int) $max_width . 'px;">' : '';
        if ( $lightbox && $image_url_full !== '' ) {
            $html .= '<a href="' . $image_url_full . '" class="no-border lightbox" title="' . $image_caption . '">';
        }
        elseif ( $link !== '' ) {
            $html .= '</a><a href="' . $link . '" class="no-border">';
        }
        $html .= $image !== '' ? '<img src="' . $image_url . '" class="' . $class . '" title="' . $image_caption . '" alt="' . $image_alt . '" />' : '';
        if ( ( $lightbox && $image_url_full !== '' ) || $link !== '' ) {
            $html .= '</a>';
        }
        $html .= $max_width !== '' ? '</div>' : '';
        $html .= '</div>';

        return $html;

    }
    add_shortcode( 'lsvr_image_vc', 'lsvr_image_vc_shortcode' );

}
?>