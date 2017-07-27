<?php
if ( ! lsvr_shortcode_exists( 'lsvr_button' ) && ! function_exists( 'lsvr_button_shortcode' ) ) {

    function lsvr_button_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_button' => array(
                    'name' => __( 'Button', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => true,
                    'atts' => array(
                        'link' => array(
                            'label' => __( 'Link', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
						'target' => array(
                            'label' => __( 'Target', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'default' => __( 'Default', 'lsvr-toolkit' ), 'blank' => __( 'New Tab', 'lsvr-toolkit' ) ),
							'default' => 'default'
                        ),
                        'size' => array(
                            'label' => __( 'Size', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'm-normal' => __( 'Default', 'lsvr-toolkit' ), 'm-medium' => __( 'Medium', 'lsvr-toolkit' ), 'm-big' => 'Big' ),
							'default' => 'm-normal'
                        ),
                        'icon' => array(
                            'label' => __( 'Icon', 'lsvr-toolkit' ),
                            'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'color' => array(
                            'label' => __( 'Color', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'm-color-1' => __( 'Default', 'lsvr-toolkit' ), 'm-color-2' => __( 'Color 2', 'lsvr-toolkit' ), 'm-color-3' => __( 'Color 3', 'lsvr-toolkit' ) ),
							'default' => 'm-color-1'
                        ),
                        'style' => array(
                            'label' => __( 'Style', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'm-type-1' => __( 'Default', 'lsvr-toolkit' ), 'm-type-2' => __( 'Outline', 'lsvr-toolkit' ) ),
							'default' => 'm-type-1'
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
            return true;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
                'link' => '',
				'target' => 'default',
                'size' => 'm-normal',
                'icon' => '',
                'color' => 'm-color-1',
				'style' => 'm-type-1',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $link = esc_url( $args['link'] );
		$target = esc_attr( $args['target'] );
        $size = esc_attr( $args['size'] );
        $icon = esc_attr( $args['icon'] );
        $color = esc_attr( $args['color'] );
		$style = esc_attr( $args['style'] );
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes .= ' ' . $size;
		$classes .= ' ' . $color;
		$classes .= ' ' . $style;
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

		$target = $target === 'blank' ? ' target="_blank" ' : '';

        $html = '<a href="' .$link . '" ' . $inview_anim_data . $target . ' class="c-button ' . $classes . '">';
        $html .= $icon !== '' ? '<i class="ico ' . $icon . '"></i>' : '';
        $html .= do_shortcode( $content ) . '</a>';

        return $html;

    }
    add_shortcode( 'lsvr_button', 'lsvr_button_shortcode' );

}
?>