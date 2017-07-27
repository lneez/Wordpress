<?php
$lsvr_tabs_sc_temp = array();

if ( ! lsvr_shortcode_exists( 'lsvr_tabs' ) && ! function_exists( 'lsvr_tabs_shortcode' ) ) {

    function lsvr_tabs_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_tabs' => array(
                    'name' => __( 'Tabs', 'lsvr-toolkit' ),
                    'description' => __( '<strong>Tabs</strong> shortcode should contain multiple <strong>Tab Item</strong> shortcodes.', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
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

        global $lsvr_tabs_sc_temp;

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        $html = '<div class="c-tabs ' . $classes . '"' . $inview_anim_data . '>';
        $html .= '<ul class="tab-list">';

        $tab_contents = do_shortcode( $content );
        foreach ( $lsvr_tabs_sc_temp as $tab ) {

            $active = $tab === reset( $lsvr_tabs_sc_temp ) ? ' m-active' : '';
            $title = $tab['title'] != '' ? '<span class="tab-label">' . $tab['title'] . '</span>' : '';
            $html .= '<li class="tab' . $active. '">' . $title . '</li>';

        }
        $lsvr_tabs_sc_temp = array();

        $html .= '</ul><ul class="content-list">' . $tab_contents . '</ul></div>';

        return $html;

    }
    add_shortcode( 'lsvr_tabs', 'lsvr_tabs_shortcode' );

}


/* -----------------------------------------------------------------------------
    TABS ITEM
----------------------------------------------------------------------------- */

if ( ! lsvr_shortcode_exists( 'lsvr_tab_item' ) && ! function_exists( 'lsvr_tabs_item_shortcode' ) ) {

    function lsvr_tabs_item_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_tab_item' => array(
                    'name' => __( 'Tab Item', 'lsvr-toolkit' ),
                    'description' => __( '<strong>Tab Item</strong> should be put inside <strong>Tabs</strong> shortcode.', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'title' => array(
                            'label' => __( 'Title', 'lsvr-toolkit' ),
                            'type' => 'text'
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
            ),
            $atts
        );

        $title = $args['title'];

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        global $lsvr_tabs_sc_temp;

        $tab = array();
        $tab['title'] = $title;

        array_push( $lsvr_tabs_sc_temp, $tab );

        $style = count( $lsvr_tabs_sc_temp ) > 1 ? ' style="display: none;"' : '';

        return '<li' . $style . '>' . do_shortcode ( $content ) . '</li>';

    }
    add_shortcode( 'lsvr_tab_item', 'lsvr_tabs_item_shortcode' );

}
?>