<?php
if ( ! lsvr_shortcode_exists( 'lsvr_gallery' ) && ! function_exists( 'lsvr_gallery_shortcode' ) ) {

    function lsvr_gallery_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_gallery' => array(
                    'name' => __( 'Gallery', 'lsvr-toolkit' ),
                    'description' => __( 'Insert any number of images into this shortcode.', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'carousel' => array(
                            'label' => __( 'Display as Carousel', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
                            'default' => 'no'
                        ),
                        'items_per_slide' => array(
                            'label' => __( 'Items per slide if displayed as carousel', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
                            'default' => '4'
                        ),
                        'items_per_slide_desktop' => array(
                            'label' => __( 'Items per slide under 1200px if displayed as carousel', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
                            'default' => '4'
                        ),
                        'items_per_slide_smalldesktop' => array(
                            'label' => __( 'Items per slide under 992px if displayed as carousel', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
                            'default' => '3'
                        ),
                        'items_per_slide_tablet' => array(
                            'label' => __( 'Items per slide under 768px if displayed as carousel', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
                            'default' => '2'
                        ),
                        'items_per_slide_mobile' => array(
                            'label' => __( 'Items per slide under 481px if displayed as carousel', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5 ),
                            'default' => '1'
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
				'carousel' => 'no',
				'items_per_slide' => 4,
				'items_per_slide_desktop' => 4,
				'items_per_slide_smalldesktop' => 3,
				'items_per_slide_tablet' => 2,
				'items_per_slide_mobile' => 1,
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

		$carousel = esc_attr( $args['carousel'] );
		$items_per_slide = (int) $args['items_per_slide'];
		$items_per_slide_desktop = (int) $args['items_per_slide_desktop'];
		$items_per_slide_smalldesktop = (int) $args['items_per_slide_smalldesktop'];
		$items_per_slide_tablet = (int) $args['items_per_slide_tablet'];
		$items_per_slide_mobile = (int) $args['items_per_slide_mobile'];
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

		if ( $carousel === 'yes' ){
			$items_per_slide_data = ' data-items="' . $items_per_slide . '"';
			$items_per_slide_data .= ' data-items-desktop="' . $items_per_slide_desktop . '"';
			$items_per_slide_data .= ' data-items-desktop-small="' . $items_per_slide_smalldesktop . '"';
			$items_per_slide_data .= ' data-items-tablet="' . $items_per_slide_tablet . '"';
			$items_per_slide_data .= ' data-items-mobile="' . $items_per_slide_mobile . '"';
		}
		else {
			$items_per_slide_data = '';
		}

        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes .= $carousel === 'yes' ? ' m-paginated' : '';
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        $html = '<div class="c-gallery ' . $classes . '" ' . $inview_anim_data . $items_per_slide_data . ' data-margin="0">';
		$html .= '<div class="thumb-list';
		$html .= $carousel === 'yes' ? ' c-carousel-items' : '';
		$html .= '">' . do_shortcode( $content ) . '</div>';
		$html .= '</div>';

        return $html;

    }
    add_shortcode( 'lsvr_gallery', 'lsvr_gallery_shortcode' );

}
?>