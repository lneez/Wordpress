<?php
if ( ! lsvr_shortcode_exists( 'lsvr_image' ) && ! function_exists( 'lsvr_image_shortcode' ) ) {

    function lsvr_image_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_image' => array(
                    'name' => __( 'Image', 'lsvr-toolkit' ),
                    'paired' => false,
                    'inline' => true,
                    'atts' => array(
                        'image' => array(
                            'label' => __( 'Upload Image', 'lsvr-toolkit' ),
                            'type' => 'file'
                        ),
						'size' => array(
                            'label' => __( 'Size', 'lsvrtoolkit' ),
							'description' => __( 'You can specify an image size which will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
						'max_width' => array(
                            'label' => __( 'Max Width', 'lsvrtoolkit' ),
							'description' => __( 'You can define maximum width (in pixels, e.g. "100") to restrict image dimensions.', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'link' => array(
                            'label' => __( 'Link', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'lightbox' => array(
                            'label' => __( 'Open In Lightbox', 'lsvr-toolkit' ),
                            'description' => __( 'URL of the lightbox image must be placed in "Link" field.', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
                            'default' => 'no'
                        ),
                        'rounded' => array(
                            'label' => __( 'Rounded', 'lsvr-toolkit' ),
                            'description' => __( 'Make sure to use an image with square aspect ratio (1:1), for example 400x400px.', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
                            'default' => 'no'
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

		// PARSE IMAGE
		$image_url_full = '';
		$image = $args['image'];
		if ( (int) $image > 0 ) {
			$image_data = lsvr_get_image_data( (int) $image );
			if ( $image_data ) {
				$image_url = esc_url( $image_data[ $size ] );
				$image_url_full = esc_url( $image_data[ 'full' ] );
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

		$html = '';
		if ( $lightbox && $image_url_full !== '' ) {
			$html = '<a href="' . $image_url_full . '" class="no-border lightbox">';
		}
		elseif ( $link !== '' ) {
			$html = '<a href="' . $link . '" class="no-border">';
		}

		$html .= $max_width !== '' ? '<div style="max-width: ' . (int) $max_width . 'px;">' : '';
		$html .= $image !== '' ? '<img src="' . $image_url . '" class="' . $class . '" alt="" ' . $inview_anim_data . '>' : '';
		$html .= $max_width !== '' ? '</div>' : '';

		if ( ( $lightbox && $image_url_full !== '' ) || $link !== '' ) {
			$html .= '</a>';
		}

		return $html;

    }
    add_shortcode( 'lsvr_image', 'lsvr_image_shortcode' );

}
?>