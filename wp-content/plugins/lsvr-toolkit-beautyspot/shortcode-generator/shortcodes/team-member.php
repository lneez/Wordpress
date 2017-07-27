<?php
if ( ! lsvr_shortcode_exists( 'lsvr_team_member' ) && ! function_exists( 'lsvr_team_member_shortcode' ) ) {

    function lsvr_team_member_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            return array(
                'lsvr_team_member' => array(
                    'name' => __( 'Team Member', 'lsvr-toolkit' ),
                    'paired' => true,
                    'inline' => false,
                    'atts' => array(
                        'portrait' => array(
                            'label' => __( 'Portrait', 'lsvr-toolkit' ),
                            'type' => 'file'
                        ),
                        'person_name' => array(
                            'label' => __( 'Name', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'description' => array(
                            'label' => __( 'Description', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),
                        'social_icons' => array(
                            'label' => __( 'Social Icons', 'lsvr-toolkit' ),
                            'description' => __( 'Use the following pattern for adding social icons: "<strong>icon_class1,link1|icon_class2,link2</strong>".<br>For example: "<strong>fa fa-twitter,https://twitter.com/MyTwitterProfile|fa fa-facebook,https://www.facebook.com/MyTwitterProfile</strong>".', 'lsvr-toolkit' ),
                            'type' => 'text'
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
            return false;
        }

        /* ---------------------------------------------------------------------
            Prepare arguments
        --------------------------------------------------------------------- */

        $args = shortcode_atts(
            array(
                'portrait' => '',
                'person_name' => '',
                'description' => '',
                'social_icons' => '',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        $person_name = $args['person_name'];
        $description = $args['description'];
        $social_icons = $args['social_icons'];
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

		// PARSE IMAGE
		$portrait = $args['portrait'];
		if ( (int) $portrait > 0 ) {
			$image_data = lsvr_get_image_data( $portrait );
			if ( $image_data ) {
				$portrait = esc_url( $image_data[ 'medium' ] );
			}
			else {
				$portrait = '';
			}
		}
		else if ( $portrait !== '' ) {
			$portrait = esc_url( $portrait );
		}

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $classes = $custom_class;
		$classes .= ' ' . $inview_anim_class;
		$classes .= $portrait !== '' ? ' m-has-portrait' : '';
		$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

        $social_icons_html = '';
        if ( $social_icons !== '' ) {
            $social_icons_arr = explode( '|', $social_icons );
            if ( is_array( $social_icons_arr ) && count( $social_icons_arr ) > 0 ) {
                foreach( $social_icons_arr as $social_icon ) {

                    $social_icon_arr = explode( ',', $social_icon );
                    if ( is_array( $social_icon_arr ) && count( $social_icon_arr ) === 2 ) {
                        $social_icons_html .= '<li><a href="' . $social_icon_arr[1] . '" target="_blank"><i class="' . $social_icon_arr[0] . '"></i></a></li>';
                    }

                }
            }
        }

        $html = '<div class="c-team-member ' . $classes . '" ' . $inview_anim_data . '><div class="member-inner">';
        $html .= $portrait !== '' ? '<div class="member-portrait"><span><img alt="' . $person_name . '" src="' . $portrait . '"></span></div>' : '';
        $html .= $person_name !== '' ? '<h3 class="member-name m-secondary-font">' . $person_name . '</h3>' : '';
		$html .= $description !== '' ? '<h4 class="member-role">' . $description . '</h4>' : '';
		$html .= '<div class="member-description">' . do_shortcode( $content ) . '</div>';
        $html .= $social_icons !== '' ? '<ul class="member-social">' . $social_icons_html . '</ul>' : '';
		$html .= '</div></div>';

        return $html;

    }
    add_shortcode( 'lsvr_team_member', 'lsvr_team_member_shortcode' );

}
?>