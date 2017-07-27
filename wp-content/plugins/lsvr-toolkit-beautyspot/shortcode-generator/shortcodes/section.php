<?php
if ( ! lsvr_shortcode_exists( 'lsvr_section' ) && ! function_exists( 'lsvr_section_shortcode' ) ) {

    function lsvr_section_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_section' => array(
                    'name' => __( 'Section', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'subtitle' => array(
                            'label' => __( 'Subtitle', 'lsvr-toolkit' ),
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
						'fullsize' => array(
							'label' => __( 'Fullsize', 'lsvr-toolkit' ),
                            'description' => __( 'Set "yes" if this section is used in fullsize template.', 'lsvr-toolkit' ),
							'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
                            'type' => 'select',
							'default' => 'no'
                        ),
						'wrap_in_container' => array(
							'label' => __( 'Wrap Content in Container', 'lsvr-toolkit' ),
							'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
                            'type' => 'select',
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
                        ),
                        'custom_id' => array(
                            'label' => __( 'Custom ID', 'lsvr-toolkit' ),
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
				'fullsize' => 'no',
				'wrap_in_container' => 'no',
                'title' => '',
				'subtitle' => '',
				'button_label' => '',
				'button_link' => '',
                'inview_anim' => 'none',
                'custom_class' => '',
				'custom_id' => ''
            ),
            $atts
        );

		$fullsize = esc_attr( $args['fullsize'] );
		$wrap_in_container = esc_attr( $args['wrap_in_container'] );
        $title = $args['title'];
		$subtitle = $args['subtitle'];
		$button_label = esc_attr( $args['button_label'] );
		$button_link = esc_url( $args['button_link'] );
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );
		$custom_id = esc_attr( $args['custom_id'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $has_title = $title !== '' ? ' has-title ' : '';
        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

		$id = $custom_id !== '' ? ' id="' . $custom_id . '"' : '';

        $html = '<section class="' . $classes . '"' . $inview_anim_data .  $id . '>';
        $html .= $title !== '' || $subtitle !== '' || ( $button_label !== '' && $button_link !== '' ) ? '<header>' : '';
		$html .= $fullsize === 'yes' && ( $title !== '' || $subtitle !== '' || ( $button_label !== '' && $button_link !== '' ) ) ? '<div class="container">' : '';
		$html .= $title !== '' ? '<h2>' . $title . '</h2>' : '';
		$html .= $subtitle !== '' ? '<p class="subtitle">' . $subtitle . '</p>' : '';
		$html .= $button_label !== '' && $button_link !== '' ? '<p class="more"><a href="' . $button_link . '" class="c-button m-type-2">' . $button_label . '</a></p>' : '';
		$html .= $fullsize === 'yes' && ( $title !== '' || $subtitle !== '' || ( $button_label !== '' && $button_link !== '' ) ) ? '</div>' : '';
		$html .= $title !== '' || $subtitle !== '' || ( $button_label !== '' && $button_link !== '' ) ? '</header>' : '';
		$html .= $wrap_in_container === 'yes' ? '<div class="container">' : '';
        $html .= do_shortcode( $content );
		$html .= $wrap_in_container === 'yes' ? '</div>' : '';
		$html .= '</section>';

        return $html;

    }
    add_shortcode( 'lsvr_section', 'lsvr_section_shortcode' );

}
?>