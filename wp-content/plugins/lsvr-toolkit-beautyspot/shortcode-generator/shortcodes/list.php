<?php
if ( ! lsvr_shortcode_exists( 'lsvr_list' ) && ! function_exists( 'lsvr_list_shortcode' ) ) {

    function lsvr_list_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_list' => array(
                    'name' => __( 'List', 'lsvr-toolkit' ),
                    'description' => __( '<strong>List</strong> shortcode should contain multiple <strong>List Item</strong> shortcodes.', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
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
            return false;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

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

        return '<ul class="c-list ' . $classes . '"' . $inview_anim_data . '>' . do_shortcode( $content ) . '</ul>';

    }
    add_shortcode( 'lsvr_list', 'lsvr_list_shortcode' );

}



/* -----------------------------------------------------------------------------

    LIST ITEM

----------------------------------------------------------------------------- */

if ( ! lsvr_shortcode_exists( 'lsvr_list_item' ) && ! function_exists( 'lsvr_list_item_shortcode' ) ) {

    function lsvr_list_item_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_list_item' => array(
                    'name' => __( 'List Item', 'lsvr-toolkit' ),
                    'description' => __( '<strong>List Item</strong> should be put inside <strong>List</strong> shortcode.', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => true,
                    'atts' => array(
                        'icon' => array(
                            'label' => __( 'Icon', 'lsvr-toolkit' ),
                            'description' => __( 'Name of the icon (e.g. "fa fa-heart"). You will find list of all icons in the documentation.', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'icon_color' => array(
                            'label' => __( 'Icon Color', 'lsvr-toolkit' ),
                            'description' => __( 'For example "#232323", or use the color picker.', 'lsvr-toolkit' ),
                            'type' => 'color'
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
                'icon' => '',
                'icon_color' => ''
            ),
            $atts
        );

        $icon = esc_attr( $args['icon'] );
        $icon_color = esc_attr( $args['icon_color'] );
		$icon_color = ( strlen( $icon_color ) > 0 ) && ( substr( $icon_color, 0, 1 ) ) !== '#' ? '#' . $icon_color : $icon_color;

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

		$icon_styles = 'style="color: ' . $icon_color . ';"';
        $icon = $icon !== '' ? '<i class="ico ' . $icon . '" ' . $icon_styles . '></i>' : '';
        $html = '<li>' . $icon . do_shortcode( $content ) . '</li>';

        return $html;

    }
    add_shortcode( 'lsvr_list_item', 'lsvr_list_item_shortcode' );

}
?>