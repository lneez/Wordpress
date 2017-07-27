<?php

if ( ! lsvr_shortcode_exists( 'lsvr_slider' ) && ! function_exists( 'lsvr_slider_shortcode' ) ) {

    function lsvr_slider_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        if ( post_type_exists( 'lsvrslide' ) ) {

        /* ---------------------------------------------------------------------
            Output shortcode info for shortcode generator
        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            $shortcode_data = array(
                'lsvr_slider' => array(
                    'name' => __( 'Slider', 'lsvr-toolkit' ),
                    'description' => __( 'Basic slider. Slides can be managed under <strong>Slider</strong> section of main menu.', 'lsvr-toolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        'fullsize' => array(
                            'label' => __( 'Fullsize', 'lsvr-toolkit' ),
							'description' => __( 'Select "Yes" if you are using this slider in Fullsize template.', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'yes' => __( 'Yes', 'lsvr-toolkit' ), 'no' => __( 'No', 'lsvr-toolkit' ) ),
                            'default' => 'no'
                        ),
                        'interval' => array(
                            'label' => __( 'Autoplay Speed', 'lsvr-toolkit' ),
                            'description' => __( 'Duration between transitions in seconds. Add 0 to disable automatic slideshow.', 'lsvr-toolkit' ),
                            'type' => 'text',
                            'default' => 0
                        ),
                        'custom_class' => array(
                            'label' => __( 'Custom Class', 'lsvr-toolkit' ),
                            'description' => __( 'It can be used for applying custom CSS.', 'lsvr-toolkit' ),
                            'type' => 'text'
                        )
                    )
                )
            );

            // check for slider taxonomy terms
            $slides_group_tax = get_terms( 'lsvrslider', 'hide_empty=0&hierarchical=0&parent=0' ) ;
            if ( count( $slides_group_tax ) > 0 ) {

                $values = array( 'none' => 'None' );
                foreach ( $slides_group_tax as $value ) {
                    $values[$value->slug] = $value->name;
                }

                $att_data = array(
                    'label' => __( 'Slider', 'lsvr-toolkit' ),
                    'description' => __( 'Which slider will be used. You can manage sliders under <strong>Dashboard / Slides / Sliders</strong>. Choose <strong>None</strong> to load all slides.', 'lsvr-toolkit' ),
                    'type' => 'select',
                    'values' => $values,
                    'default' => 'none'
                );

                $shortcode_data['lsvr_slider']['atts'] = array_merge( array( 'slider' => $att_data ), $shortcode_data['lsvr_slider']['atts'] );

            }

            return $shortcode_data;

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
                'slider' => '',
				'fullsize' => 'no',
                'interval' => 0,
                'custom_class' => ''
            ),
            $atts
        );

        $slider = trim( esc_attr( $args['slider'] ) );
        $interval = (int) $args['interval'];
        $fullsize = esc_attr( $args['fullsize'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Query
        --------------------------------------------------------------------- */

        $q_args = array(
            'posts_per_page' => -1,
            'post_type' => 'lsvrslide',
            'order' => 'ASC',
            'orderby' => 'post_date',
            'post_status' => array( 'publish', 'private' ),
            'suppress_filters' => false
        );

        if ( $slider !== '' && $slider !== 'none' ) {

            $slider = explode( ',', $slider );
            $q_args[ 'tax_query' ] = array(
                array(
                    'taxonomy' => 'lsvrslider',
                    'field' => 'slug',
                    'terms' => $slider
                )
            );

        }

        $loop = new WP_Query( $q_args );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        if ( $loop->have_posts() ) {

            $interval_data = $interval > 0 ? ' data-interval="' . ( $interval * 1000 ) . '"' : '';

			$classes = $custom_class;
			$classes .= $fullsize === 'yes' ? ' m-fullsize' : '';
			$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

            $html = '<div class="c-slider ' . $classes . '" ' . $interval_data . '><div class="slide-list">';

            $index = 0;
            while ( $loop->have_posts() ) {

                $loop->the_post();
                $post_id = get_the_ID();

				$style = '';
                if ( has_post_thumbnail( $post_id ) ) {
                    $featured_img_fullsize_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
                    $style .= ' background-image: url(' . $featured_img_fullsize_url['0'] . ');';
                }
				$lsvr_slide_settings_meta = get_post_meta( $post_id, '_lsvr_slide_settings_meta', true );
				$slide_valign = is_array( $lsvr_slide_settings_meta ) && array_key_exists( 'valign', $lsvr_slide_settings_meta ) ? $lsvr_slide_settings_meta['valign'] : 'top';
				$label_data = ' data-label="' . get_the_title( $post_id ) . '"';

                $content = get_the_content();
                $content = apply_filters( 'the_content', $content );
                $content = str_replace( ']]>', ']]&gt;', $content );

                $html .= '<div class="slide item slide ' . $classes . '" style="' . $style . '"' . $label_data . ' data-index="' . $index . '">';
				$html .= $fullsize === 'yes' ? '<div class="container">' : '';
				$html .= '<div class="slide-inner"><div class="slide-content various-content valign-' . $slide_valign . '">';
				$html .= do_shortcode( $content ) . '</div></div>';
				$html .= $fullsize === 'yes' ? '</div>' : '';
				$html .= '</div>';

				$index++;

            }
            wp_reset_query();

            $html .= '</div></div>';

            return $html;

        }

        }

    }
    add_shortcode( 'lsvr_slider', 'lsvr_slider_shortcode' );

}

?>