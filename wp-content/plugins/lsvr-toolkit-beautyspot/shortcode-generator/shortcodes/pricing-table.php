<?php
if ( ! lsvr_shortcode_exists( 'lsvr_pricing_table' ) && ! function_exists( 'lsvr_pricing_table_shortcode' ) ) {

    function lsvr_pricing_table_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_pricing_table' => array(
                    'name' => __( 'Pricing Table', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'price' => array(
                            'label' => __( 'Price', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'price_description' => array(
                            'label' => __( 'Price Description', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'button_label' => array(
                            'label' => __( 'Button Label', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'button_link' => array(
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
                'price' => '',
                'price_description' => '',
                'button_label' => '',
                'button_link' => '',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $title = $args['title'];
        $price = esc_attr( $args['price'] );
        $price_description = $args['price_description'];
        $button_label = $args['button_label'];
        $button_link = esc_attr( $args['button_link'] );
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


        $html = '<div class="c-pricing-table ' . $classes . '"' . $inview_anim_data . '><div class="table-header">';
		$html .= $title !== '' ? '<h4 class="table-title">' . $title . '</h4>' : '';
		$html .= '<h5 class="table-price">' . $price;
		$html .= $price_description !== '' ? '<span>' . $price_description . '</span>' : '';
		$html .= '</h5>';
		$html .= '</div><div class="table-content">' . do_shortcode( $content );
		$html .= $button_label !== '' && $button_link !== '' ? '<p><a href="' . $button_link . '" class="c-button">' . $button_label . '</a></p>' : '';
		$html .= '</div></div>';

        return $html;


    }
    add_shortcode( 'lsvr_pricing_table', 'lsvr_pricing_table_shortcode' );

}
?>