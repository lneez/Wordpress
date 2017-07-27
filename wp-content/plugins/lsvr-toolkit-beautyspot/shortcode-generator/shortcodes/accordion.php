<?php
if ( ! lsvr_shortcode_exists( 'lsvr_accordion' ) && ! function_exists( 'lsvr_accordion_shortcode' ) ) {

    function lsvr_accordion_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_accordion' => array(
                    'name' => __( 'Accordion', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'toggle' => array(
                            'label' => __( 'Toggle', 'lsvr-toolkit' ),
							'description' => __( 'This accordion will behave as a toggle if enabled.', 'lsvr-toolkit' ),
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
                'toggle' => 'no',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $toggle = esc_attr( $args['toggle'] );
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

		$classes = $custom_class;
		$classes .= $toggle === 'yes' ? ' m-toggle' : '';
		$classes .= ' ' . $inview_anim_class;
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        return '<ul class="c-accordion ' . $classes . '"' . $inview_anim_data . '>' . do_shortcode( $content ) . '</ul>';

    }
    add_shortcode( 'lsvr_accordion', 'lsvr_accordion_shortcode' );

}

/* -----------------------------------------------------------------------------
    ACCORDION ITEM
----------------------------------------------------------------------------- */

if ( ! lsvr_shortcode_exists( 'lsvr_accordion_item' ) && ! function_exists( 'lsvr_accordion_item_shortcode' ) ) {

    function lsvr_accordion_item_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_accordion_item' => array(
                    'name' => __( 'Accordion Item', 'lsvr-toolkit' ),
                    'description' => __ ( 'Must be placed inside <strong>Accordion</strong> shortcode.', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'price' => array(
                            'label' => __( 'Price Info', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'oldprice' => array(
                            'label' => __( 'Old Price Info', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'state' => array(
                            'label' => __( 'State', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'closed' => __( 'Closed', 'lsvr-toolkit' ), 'opened' => __( 'Opened', 'lsvr-toolkit' ) ),
                            'default' => 'closed'
                        ),
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
				'price' => '',
				'oldprice' => '',
                'state' => 'closed'
            ),
            $atts
        );

        $title = esc_attr( $args['title'] );
		$price = esc_attr( $args['price'] );
		$oldprice = esc_attr( $args['oldprice'] );
        $state = esc_attr( $args['state'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$oldprice = $oldprice !== '' ? '<s>' . $oldprice . '</s> ' : '';

        $html = $state === 'opened' ? '<li class="m-active">' : '<li>';
        $html .= '<h3 class="accordion-title';
        $html .= $price !== '' ? ' m-has-price' : '';
        $html .= '">' . $title . '</h3>';
		$html .= $price !== '' ? '<p class="accordion-price">' . $oldprice . $price . '</p>' : '';
        $html .= '<div class="accordion-content">' . do_shortcode( wpautop( $content ) ) . '</div></li>';

        return $html;

    }
    add_shortcode( 'lsvr_accordion_item', 'lsvr_accordion_item_shortcode' );

}
?>