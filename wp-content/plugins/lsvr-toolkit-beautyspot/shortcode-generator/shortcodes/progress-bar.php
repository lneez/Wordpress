<?php
if ( ! lsvr_shortcode_exists( 'lsvr_progressbar' ) && ! function_exists( 'lsvr_progressbar_shortcode' ) ) {

    function lsvr_progressbar_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

		global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_progressbar' => array(
                    'name' => __( 'Progress Bar', 'lsvr-toolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'percentage' => array(
                            'label' => __( 'Percentage', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '0' => 0, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40, '45' => 45,
                                '50' => 50, '55' => 55, '60' => 60, '65' => 65, '70' => 70, '75' => 75, '80' => 80, '85' => 85, '90' => 90, '95' => 95, '100' => 100 ),
                            'default' => '100'
                        ),
                        'label' => array(
                            'label' => __( 'Label', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'color' => array(
                            'label' => __( 'Style', 'lsvr-toolkit' ),
                            'type' => 'select',
							'values' => array( 'm-color-1' => 'Color 1', 'm-color-2' => 'Color 2', 'm-color-3' => 'Color 3' )
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
                'percentage' => 100,
                'label' => '',
                'color' => 'm-color-1',
				'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $percentage = (int) esc_attr( $args['percentage'] );
        $label = $args['label'];
        $color = esc_attr( $args['color'] );
		$inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes .= ' ' . $color;
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

		$html = $label !== '' ? '<h5>' . $label . '</h5>' : '';
		$html .= '<div class="c-progress-bar ' . $classes . '" data-percentage="' . $percentage . '"' . $inview_anim_data . '><span class="bar-inner"></span></div>';

        return $html;

    }
    add_shortcode( 'lsvr_progressbar', 'lsvr_progressbar_shortcode' );

}
?>