<?php
if ( ! lsvr_shortcode_exists( 'lsvr_gallery_vc' ) && ! function_exists( 'lsvr_gallery_vc_shortcode' ) ) {

    function lsvr_gallery_vc_shortcode( $atts, $content = null, $generator = false, $check_if_inline = false ) {

        global $lsvr_inview_animations;
        global $lsvr_inview_animations_visible;

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
                'images' => '',
				'carousel' => 'no',
                'items_per_slide' => 4,
				'items_under_1200' => 3,
				'items_under_992' => 2,
				'items_under_768' => 2,
				'items_under_481' => 1,
                'size' => 'medium',
                'crop' => '',
				'crop_aspect_ratio' => '60',
				'click_action' => 'lightbox',
				'inview_anim' => 'none',
                'custom_class' => ''
            ),
            $atts
        );

		$images = esc_attr( $args['images'] );
		$carousel = esc_attr( $args['carousel'] );
		$carousel = $carousel === 'yes' ? true : false;
		$items_per_slide = (int) $args['items_per_slide'];
		$items_under_1200 = (int) $args['items_under_1200'];
		$items_under_992 = (int) $args['items_under_992'];
		$items_under_768 = (int) $args['items_under_768'];
		$items_under_481 = (int) $args['items_under_481'];
        $size = esc_attr( $args['size'] );
		$crop = esc_attr( $args['crop'] );
		$crop = $crop === 'yes' ? true : false;
		$crop_aspect_ratio = (int) esc_attr( $args['crop_aspect_ratio'] );
		$click_action = esc_attr( $args['click_action'] );
		$inview_anim = esc_attr( $args['inview_anim'] );
        $custom_class = esc_attr( $args['custom_class'] );

        /* ---------------------------------------------------------------------
            Generate HTML
        --------------------------------------------------------------------- */

        $inview_anim_data = $inview_anim !== '' && $inview_anim !== 'none'  ? ' data-inview-anim="' . $inview_anim . '" ' : '';
		$inview_anim_class = $inview_anim !== '' && $inview_anim !== 'none' && ! in_array( $inview_anim, $lsvr_inview_animations_visible ) ? 'visibility-hidden' : '';

        $class = $custom_class;
		$class .= $carousel ? ' m-carousel' : '';
		$class .= ! $carousel ? ' m-' . $items_per_slide . '-per-row' : '';
		$class .= $crop ? ' m-crop' : '';
		$class .= $inview_anim_class !== '' ? ' ' . $inview_anim_class : '';
		$class = trim( preg_replace( '/\s+/', ' ', $class ) );
		$class = $class !== '' ? ' ' . $class : '';

		$output = '<div class="c-gallery-vc ' . $class . '" ' . $inview_anim_data;

		if ( $carousel ) {
			$output .= ' data-items="' . $items_per_slide . '"';
			$output .= ' data-items-desktop="' . $items_under_1200 . '"';
			$output .= ' data-items-desktop-small="' . $items_under_992 . '"';
			$output .= ' data-items-tablet="' . $items_under_768 . '"';
			$output .= ' data-items-mobile="' . $items_under_481 . '"';
			$output .= ' data-margin="0"><ul class="c-carousel-items">';
		}
		else {
			$output .= '><ul>';
		}

		if ( $images !== '' ) {
			$images_arr = explode( ',', $images );
			foreach( $images_arr as $id ) {

				$image_data = lsvr_get_image_data( $id );
				$image_url = '';
				$image_url_full = '';
				$image_alt = '';
				$image_caption = '';
				if ( $image_data ) {
					if ( array_key_exists( $size, $image_data ) ) {
						$image_url = esc_url( $image_data[ $size ] );
					}
					else {
						$image_url = esc_url( $image_data[ 'medium' ] );
					}
					$image_url_full = esc_url( $image_data[ 'full' ] );
					$image_alt = $image_data[ 'alt' ];
					$image_caption = $image_data[ 'caption' ];

				}
				if ( $image_url !== '' ) {

					$output .= '<li class="gallery-item"><div class="item-inner"';
					$output .= $crop ? ' style="padding-bottom: ' . $crop_aspect_ratio . '%">' : '>';
					if ( $click_action === 'lightbox' || $click_action === 'tab' ) {
						$output .= '<a title="' . $image_caption . '" href="' . $image_url_full . '"';
						$output .= $click_action === 'lightbox' ? ' class="lightbox">' : '';
						$output .= $click_action === 'tab' ? ' target="_blank">' : '';
					}
					$output .= '<img src="' . $image_url . '" alt="' . $image_alt . '">';
					$output .= $click_action === 'lightbox' || $click_action === 'tab' ? '</a>' : '';
					$output .= '</div></li>';

				}

			}
		}

		$output .= '</ul></div>';

		return $output;

    }
    add_shortcode( 'lsvr_gallery_vc', 'lsvr_gallery_vc_shortcode' );

}
?>