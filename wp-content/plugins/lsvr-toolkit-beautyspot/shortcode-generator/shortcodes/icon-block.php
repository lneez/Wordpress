<?php
if ( ! lsvr_shortcode_exists( 'lsvr_icon_block' ) && ! function_exists( 'lsvr_icon_block_shortcode' ) ) {

    function lsvr_icon_block_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_icon_block' => array(
                    'name' => __( 'Icon Block', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'icon' => array(
                            'label' => __( 'Icon', 'lsvr-toolkit' ),
                            'description' => __( 'Name of the icon (e.g. "fa fa-heart"). Please refer to the documentation to learn more about using the icons.', 'lsvr-toolkit' ),
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
				'icon' => '',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

		$icon = esc_attr( $args['icon'] );
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

        $html = '<div class="c-icon-block ' . $classes . '"' . $inview_anim_data . '>';
		$html .= $icon !== '' ? '<i class="ico ' . $icon . '"></i>' : '';
		$html .= '<div class="icon-block-inner">' . do_shortcode( $content ) . '</div></div>';

		return $html;


    }
    add_shortcode( 'lsvr_icon_block', 'lsvr_icon_block_shortcode' );

}
?>