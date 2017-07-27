<?php
if ( ! lsvr_shortcode_exists( 'lsvr_carousel' ) && ! function_exists( 'lsvr_carousel_shortcode' ) ) {

    function lsvr_carousel_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_carousel' => array(
                    'name' => __( 'Carousel', 'lsvr-toolkit' ),
                    'description' => __( '<strong>Carousel</strong> is mainly used to divide similar elements into multiple slides.', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
						'wrap_in_container' => array(
                            'label' => __( 'Wrap in Container', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
                            'default' => 'no'
                        ),
						'transparent_bg' => array(
                            'label' => __( 'Transparent Background', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
                            'default' => 'yes'
                        ),
						'bg_color' => array(
                            'label' => __( 'Background Color', 'lsvr-toolkit' ),
                            'type' => 'color',
                            'description' => __( 'If you set "Transparent Background" option to "No" and leave this field blank, default color will be used.', 'lsvr-toolkit' ),
                        ),
                        'items_per_slide' => array(
                            'label' => __( 'Items Per Slide', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
                            'default' => '1'
                        ),
                        'items_per_slide_desktop' => array(
                            'label' => __( 'Items Per Slide Under 1200px', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
                            'default' => '1'
                        ),
                        'items_per_slide_smalldesktop' => array(
                            'label' => __( 'Items Per Slide Under 992px', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
                            'default' => '1'
                        ),
                        'items_per_slide_tablet' => array(
                            'label' => __( 'Items Per Slide Under 768px', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
                            'default' => '1'
                        ),
                        'items_per_slide_mobile' => array(
                            'label' => __( 'Items Per Slide Under 481px', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ),
                            'default' => '1'
                        ),
						'autoplay' => array(
                            'label' => __( 'Autoplay Speed', 'lsvr-toolkit' ),
                            'description' => __( 'In seconds. Set to 0 to disable', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8,
							'9' => 9, '10' => 10, '11' => 11, '12' => 12, '13' => 13, '14' => 14, '15' => 15, '16' => 16, '17' => 17, '18' => 18, '19' => 19, '20' => 20 ),
                            'default' => '0'
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
				'wrap_in_container' => 'no',
				'transparent_bg' => '',
				'bg_color' => '',
				'items_per_slide' => 1,
				'items_per_slide_desktop' => 1,
				'items_per_slide_smalldesktop' => 1,
				'items_per_slide_tablet' => 1,
				'items_per_slide_mobile' => 1,
				'autoplay' => 0,
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

		$wrap_in_container = esc_attr( $args['wrap_in_container'] );
		$transparent_bg = esc_attr( $args['transparent_bg'] );
		$bg_color = esc_attr( $args['bg_color'] );
		$bg_color = $bg_color !== '' && is_string( $bg_color ) && $bg_color[0] !== '#' ? '#' . $bg_color : '';
		$items_per_slide = (int) $args['items_per_slide'];
		$items_per_slide_desktop = (int) $args['items_per_slide_desktop'];
		$items_per_slide_smalldesktop = (int) $args['items_per_slide_smalldesktop'];
		$items_per_slide_tablet = (int) $args['items_per_slide_tablet'];
		$items_per_slide_mobile = (int) $args['items_per_slide_mobile'];
		$autoplay = (int) esc_attr( $args['autoplay'] );
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

		$items_per_slide_data = ' data-items="' . $items_per_slide . '"';
		$items_per_slide_data .= ' data-items-desktop="' . $items_per_slide_desktop . '"';
		$items_per_slide_data .= ' data-items-desktop-small="' . $items_per_slide_smalldesktop . '"';
		$items_per_slide_data .= ' data-items-tablet="' . $items_per_slide_tablet . '"';
		$items_per_slide_data .= ' data-items-mobile="' . $items_per_slide_mobile . '"';
		if ( $autoplay > 0 ) {
			$items_per_slide_data .= ' data-autoplay="' . $autoplay * 1000 . '"';
			$items_per_slide_data .= ' data-loop="true"';
		}

        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes .= $transparent_bg !== 'yes' ? ' m-has-bg-color' : '';
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

		$styles = $bg_color !== '' ? ' style="background-color: ' . $bg_color . '"' : '';

        $html = '<div class="c-carousel ' . $classes . '" ' . $styles . $inview_anim_data . $items_per_slide_data . '>';
		$html .= $wrap_in_container === 'yes' ? '<div class="container">' : '';
		$html .= '<div class="c-carousel-items">' . do_shortcode( $content ) . '</div>';
		$html .= $wrap_in_container === 'yes' ? '</div>' : '';
		$html .= '</div>';

		return $html;

    }
    add_shortcode( 'lsvr_carousel', 'lsvr_carousel_shortcode' );

}

/* -----------------------------------------------------------------------------
    CAROSUEL ITEM
----------------------------------------------------------------------------- */

if ( ! lsvr_shortcode_exists( 'lsvr_carousel_item' ) && ! function_exists( 'lsvr_carousel_item_shortcode' ) ) {

    function lsvr_carousel_item_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_carousel_item' => array(
                    'name' => __( 'Carousel Item', 'lsvrtoolkit' ),
                    'description' => __ ( 'Must be placed inside <strong>Carousel</strong> shortcode.', 'lsvrtoolkit' ),
                    'paired' => true,
                    'inline' => false,
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
            Generate HTML
        --------------------------------------------------------------------- */

		$output = '<div class="carousel-item">' . do_shortcode( wpautop( $content ) ) . '</div>';

		return $output;

    }
    add_shortcode( 'lsvr_carousel_item', 'lsvr_carousel_item_shortcode' );

}
?>