<?php
if ( ! lsvr_shortcode_exists( 'lsvr_icon' ) && ! function_exists( 'lsvr_icon_shortcode' ) ) {

    function lsvr_icon_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_icon' => array(
                    'name' => __( 'Icon', 'lsvr-toolkit' ),
                    'paired' => false,
                    'inline' => true,
                    'atts' => array(
                        'icon' => array(
                            'label' => __( 'Icon', 'lsvr-toolkit' ),
                            'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'icon_size' => array(
                            'label' => __( 'Icon Size', 'lsvr-toolkit' ),
                            'description' => __( 'Size of icon in pixels.', 'lsvr-toolkit' ),
                            'type' => 'text',
                            'default' => 18
                        ),
                        'icon_color' => array(
                            'label' => __( 'Icon Color', 'lsvr-toolkit' ),
                            'description' => __( 'For example "#232323".', 'lsvr-toolkit' ),
                            'type' => 'color'
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
            return true;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
                'icon' => '',
                'icon_size' => 18,
                'icon_color' => '',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $icon = esc_attr( $args['icon'] );
        $icon_size = (int) esc_attr( $args['icon_size'] );
        $icon_color = esc_attr( $args['icon_color'] );
		$icon_color = ( strlen( $icon_color ) > 0 ) && ( substr( $icon_color, 0, 1 ) ) !== '#' ? '#' . $icon_color : $icon_color;
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $styles = 'style="';
        $styles .= $icon_color !== '' ? 'color: ' . $icon_color . ';' : '';
        $styles .= $icon_size !== '' ? ' font-size: ' . $icon_size . 'px;' : '';
        $styles .= '" ';
		$styles = trim( preg_replace( '/\s+/', ' ', $styles ) );

		$classes = $custom_class;
		$classes .= ' ' . $icon;
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        return '<i class="' . $classes . '" ' . $styles . ' ' . $inview_anim_data . ' ></i>';

    }
    add_shortcode( 'lsvr_icon', 'lsvr_icon_shortcode' );

}
?>