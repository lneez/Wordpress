<?php
if ( ! lsvr_shortcode_exists( 'lsvr_service' ) && ! function_exists( 'lsvr_feature_shortcode' ) ) {

    function lsvr_feature_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_service' => array(
                    'name' => __( 'Service', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'image' => array(
                            'label' => __( 'Image', 'lsvr-toolkit' ),
                            'type' => 'file',
                            'default' => ''
                        ),
						'image_size' => array(
                            'label' => __( 'Image', 'lsvr-toolkit' ),
							'description' => __( 'You can specify which image size will be used, e.g. "large" or "full". Sizes can be defined under <strong>Settings / Media</strong>. Leave blank to use a "medium" size.', 'lsvr-toolkit' ),
							'type' => 'text',
                        ),
						'image_rounded' => array(
							'label' => __( 'Rounded Image', 'lsvrtoolkit' ),
							'description' => __( 'If you enable this, make sure that your uploaded image has square aspect ratio (1:1), for example 300x300px.', 'lsvr-toolkit' ),
							'values' => array( 'yes' => __( 'Yes', 'lsvrtoolkit' ), 'no' => __( 'No', 'lsvrtoolkit' ) ),
                            'type' => 'select',
							'default' => 'yes'
                        ),
                        'title' => array(
                            'label' => __( 'Title', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'link' => array(
                            'label' => __( 'Link', 'lsvr-toolkit' ),
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
				'image' => '',
				'image_size' => 'medium',
				'image_rounded' => '',
                'title' => '',
                'link' => '',
                'inview_anim' => '',
                'custom_class' => ''
            ),
            $atts
        );

		$image = esc_url( $args['image'] );
		$image_size = esc_attr( $args['image_size'] );
        $image_rounded = esc_attr( $args['image_rounded'] );
        $image_rounded = $image_rounded === 'yes' ? true : false;
        $title = esc_attr( $args['title'] );
		$link = esc_attr( $args['link'] );
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );
        $image_alt = '';

		// PARSE IMAGE
		$image = $args['image'];
		if ( (int) $image > 0 ) {
			$image_data = lsvr_get_image_data( (int) $image );
			if ( $image_data ) {
				$image_url = esc_url( $image_data[ $image_size ] );
                $image_alt = ! empty( $image_data[ 'alt' ] ) ? $image_data[ 'alt' ] : '';
			}
			else {
				$image_url = '';
			}
		}
		else if ( $image !== '' ) {
			$image_url = esc_url( $image );
		}
        else {
            $image_url = '';
        }

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes .= $image_rounded ? ' m-rounded-image' : '';
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        $html = '<div class="c-service ' . $classes . '"' . $inview_anim_data . '>';
        if ( $image_url !== '' ) {
    		$html .= $image_url !== '' ? '<div class="service-image">' : '';
    		$html .= $image_url !== '' && $link !== '' ? '<a href="' . $link . '">' : '';
    		$html .= $image_url !== '' ? '<img src="' . $image_url . '" alt="' . esc_attr( $image_alt ) . '">' : '';
    		$html .= $image_url !== '' && $link !== '' ? '</a>' : '';
    		$html .= $image_url !== '' ? '</div>' : '';
        }
		$html .= $title !== '' ? '<h3 class="service-title">' : '';
		$html .= $title !== '' && $link !== '' ? '<a href="' . $link . '">' : '';
		$html .= $title !== '' ? $title : '';
		$html .= $title !== '' && $link !== '' ? '</a>' : '';
		$html .= $title !== '' ? '</h3>' : '';
		$html .= '<div class="service-description">' . do_shortcode( $content ) . '</div></div>';

        return $html;

    }
    add_shortcode( 'lsvr_service', 'lsvr_feature_shortcode' );

}
?>