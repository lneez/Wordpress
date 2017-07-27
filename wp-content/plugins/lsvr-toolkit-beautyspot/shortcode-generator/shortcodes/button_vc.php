<?php
if ( ! lsvr_shortcode_exists( 'lsvr_button_vc' ) && ! function_exists( 'lsvr_button_vc_shortcode' ) ) {

    function lsvr_button_vc_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

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
				'text' => '',
                'link' => '',
				'target' => 'default',
                'size' => 'm-normal',
                'icon' => '',
                'color' => 'm-color-1',
				'style' => 'm-type-1',
				'section_button' => 'no',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

		$text = $args['text'];
        $link = esc_attr( $args['link'] );
		$target = esc_attr( $args['target'] );
        $size = esc_attr( $args['size'] );
        $icon = esc_attr( $args['icon'] );
        $color = esc_attr( $args['color'] );
		$style = esc_attr( $args['style'] );
		$section_button = esc_attr( $args['section_button'] );
		$section_button = $section_button === 'yes' ? true : false;
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

        $html = $section_button ? '<p class="section-button-holder">' : '<p>';
		$html .= '<a href="' .$link . '" ' . $inview_anim_data . $target . ' class="c-button ' . $classes . '">';
        $html .= $icon !== '' ? '<i class="ico ' . $icon . '"></i>' : '';
        $html .= $text . '</a></p>';

        return $html;

    }
    add_shortcode( 'lsvr_button_vc', 'lsvr_button_vc_shortcode' );

}
?>