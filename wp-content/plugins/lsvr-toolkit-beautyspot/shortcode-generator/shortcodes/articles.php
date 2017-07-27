<?php
if ( ! lsvr_shortcode_exists( 'lsvr_articles' ) && ! function_exists( 'lsvr_articles_shortcode' ) ) {

    function lsvr_articles_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

        /* ---------------------------------------------------------------------

            Output shortcode info for shortcode generator

        --------------------------------------------------------------------- */

        if ( $generator === true ) {

            $shortcode_data = array(
                'lsvr_articles' => array(
                    'name' => __( 'Articles', 'lsvr-toolkit' ),
                    'description' => __( 'Lists posts from specified category.', 'lsvr-toolkit' ),
                    'paired' => false,
                    'inline' => false,
                    'atts' => array(
                        /*'title' => array(
                            'label' => __( 'Title', 'lsvr-toolkit' ),
                            'type' => 'text'
                        ),*/
                        'number_of_items' => array(
                            'label' => __( 'Number of Posts', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ),
                            'default' => '4'
                        ),
                        'show_post_date' => array(
                            'label' => __( 'Show Post Date', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'show' => __( 'Show', 'lsvr-toolkit' ), 'hide' => __( 'Hide', 'lsvr-toolkit' ) ),
                            'default' => 'show'
                        ),
                        'show_post_media' => array(
                            'label' => __( 'Show Featured Image', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'show' => __( 'Show', 'lsvr-toolkit' ), 'hide' => __( 'Hide', 'lsvr-toolkit' ) ),
                            'default' => 'show'
                        ),
                        'show_post_excerpt' => array(
                            'label' => __( 'Show Post Excerpt', 'lsvr-toolkit' ),
                            'type' => 'select',
                            'values' => array( 'show' => __( 'Show', 'lsvr-toolkit' ), 'hide' => __( 'Hide', 'lsvr-toolkit' ) ),
                            'default' => 'show'
                        ),
                        'excerpt_length' => array(
                            'label' => __( 'Excerpt Length', 'lsvr-toolkit' ),
                            'type' => 'text',
                            'default' => 40
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

            // CHECK FOR CATEGORIES
            $categories_tax = get_categories( 'hide_empty=1&hierarchical=0&parent=0' ) ;

            if ( count( $categories_tax ) > 0 ) {

                $values = array( 'none' => __( 'None', 'lsvr-toolkit' ) );

                foreach ( $categories_tax as $value ) {
                    $values[$value->slug] = $value->name;
                }

                $att_data = array(
                    'label' => __( 'Category', 'lsvr-toolkit' ),
                    'description' => __( 'Category to load posts from. Choose <strong>None</strong> to load posts regardless of category.', 'lsvr-toolkit' ),
                    'type' => 'select',
                    'values' => $values,
                    'default' => 'none'
                );

                $shortcode_atts_arr = $shortcode_data['lsvr_articles']['atts'];
                $shortcode_atts_arr = array_splice( $shortcode_atts_arr, 0, 1, true ) + array( 'category' => $att_data ) + array_slice( $shortcode_atts_arr, 1, count( $shortcode_atts_arr ) - 1, true );
                $shortcode_data['lsvr_articles']['atts'] = $shortcode_atts_arr;

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
                //'title' => '',
                'category' => 'none',
                'number_of_items' => 3,
                'excerpt_length' => 40,
                'show_post_date' => '',
                'show_post_media' => '',
                'show_post_excerpt' => '',
                'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

        //$title = esc_attr( $args['title'] );
        $category = trim( esc_attr( $args['category'] ) );
        $number_of_items = (int) esc_attr( $args['number_of_items'] );
        $show_post_date = esc_attr( $args['show_post_date'] );
        $show_post_date = $show_post_date === 'show' ? true : false;
        $show_post_media = esc_attr( $args['show_post_media'] );
        $show_post_media = $show_post_media === 'show' ? true : false;
        $show_post_excerpt = esc_attr( $args['show_post_excerpt'] );
        $show_post_excerpt = $show_post_excerpt === 'show' ? true : false;
        $excerpt_length = (int) $args['excerpt_length'];
        $inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Query
        --------------------------------------------------------------------- */

        $q_args = array(
            'posts_per_page' => $number_of_items,
            'post_type' => 'post',
            'order' => 'DESC',
            'orderby' => 'post_date',
            'post_status' => array( 'publish' ),
            'suppress_filters' => false
        );

        if ( $category !== '' && $category !== 'none' && term_exists( $category, 'category' ) ) {

            // GET ITEMS FROM TOP CATEGORY
            $q_args[ 'tax_query' ] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                )
            );

            // GET TERM LINK
            $category_link = get_term_link( $category, 'category' );

        }

        $loop = new WP_Query( $q_args );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        if ( $loop->have_posts() ) {

			$inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
			$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

			$classes = $custom_class;
			$classes .= ' ' . $inview_anim_class;
			$classes = trim( preg_replace( '/\s+/', ' ', $classes ) );

			$html = '<div class="' . $classes . '"' . $inview_anim_data . '><div class="row">';
            $index = 0;

            // LOOP
            while ( $loop->have_posts() && $index < $number_of_items ) {

                $index++;
                $loop->the_post();
                $post_id = get_the_ID();
                $post_format = get_post_format();

                // GET MEDIA
                $post_media = '';
                $post_class = '';

                if ( $show_post_media ) {

                    // FEATURED IMAGE
                    if ( has_post_thumbnail() ) {

                        $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() );
                        $cropped = '-cropped';

                        if ( $number_of_items > 2 ) {
                            $thumb_url = $thumb_data[ 'small' . $cropped ];
                            $thumb_hires_url = $thumb_data[ 'medium' . $cropped ];
                        }
                        elseif ( $items_per_row <= 2 ) {
                            $thumb_url = $thumb_data[ 'medium' . $cropped ];
                            $thumb_hires_url = $thumb_data[ 'large' . $cropped ];
                        }

                        $post_media .= '<div class="article-image">';
                        $post_media .= '<a href="' . get_permalink(). '"><img src="' . $thumb_url . '" data-hires="' . $thumb_hires_url . '" alt="' . $thumb_data[ 'alt' ] . '"></a>';
                        $post_media .= '</div>';

                    }

                }

                // GET CATEGORIES
                $post_categories = wp_get_post_categories( $post_id );
                $cats = '';

                foreach ( $post_categories as $value ) {
                    $cat = get_category( $value );
                    $cats .= '<a href="' . get_category_link( $cat->term_id ) . '">' . $cat->name . '</a>';
                    $cats .= $value !== end( $post_categories ) ? ', ' : '';
                }

                // GET EXCERPT
                $post_excerpt = '<div class="article-excerpt various-content">' . lsvr_excerpt_by_id( $post_id, $excerpt_length ) . '</div>';

                // OUTPUT
                $col_class = 'col-sm-' . 12 / $number_of_items . ' ';

                $html .= '<div class="' . $col_class . '">';
                $html .= '<article class="c-article">';
				$html .= $show_post_media && $post_media !== '' ? $post_media : '';
				$html .= $show_post_date ? '<div class="article-date">' . get_the_date() . '</div>' : '';
                $html .= '<h3 class="article-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                $html .= $show_post_excerpt && $post_excerpt !== '' ? '<div class="article-excerpt">' . $post_excerpt . '</div>' : '';
                $html .= '</article></div>';

            }
            wp_reset_query();

            $html .= '</div></div>';

            return $html;

        }

    }
    add_shortcode( 'lsvr_articles', 'lsvr_articles_shortcode' );

}
?>