<?php
if ( ! class_exists( 'lsvr_gallery_block' ) ) {
class lsvr_gallery_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array(
            'name' => __( 'Gallery', 'lsvr-toolkit' )
        );

		parent::__construct( 'lsvr_gallery_block', $block_options );

        //add ajax functions
        add_action( 'wp_ajax_aq_block_galitem_add_new', array( $this, 'add_galitem' ) );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'galitems' => array(
            1 => array(
                'title' => 'New Item',
				'image' => '',
				'imageid' => ''
            )
        ),
		'crop_thumbs' => false,
		'carousel' => false,
		'items_per_slide' => 4,
		'items_per_slide_desktop' => 4,
		'items_per_slide_smalldesktop' => 3,
		'items_per_slide_tablet' => 2,
		'items_per_slide_mobile' => 1,
        'block_offset' => 0,
		'inview_anim' => 'none',
        'custom_class' => ''
    );

    /* -------------------------------------------------------------------------
        FORM
    ------------------------------------------------------------------------- */

    function form($instance) {

    	$defaults = $this->defaults;

        global $lsvr_inview_animations;
        $inview_anim_arr = $lsvr_inview_animations;

    	$instance = wp_parse_args($instance, $defaults);
    	extract($instance);
    	?>

        <div class="lsvr-form-container">

            <div class="lsvr-form-row">

                <h3 class="lsvr-form-label"><?php _e( 'Items', 'lsvr-toolkit' ); ?></h3>

            	<div class="description cf">
            		<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
            			<?php
            			$galitems = is_array( $galitems ) ? $galitems : $defaults['galitems'];
            			$count = 1;
            			foreach( $galitems as $galitem ) {
            				$this->galitem( $galitem, $count );
            				$count++;
            			}
            			?>
            		</ul>
            		<p></p>
            		<a href="#" rel="galitem" class="lsvr-sortable-add-new button"><?php _e( 'Add New' , 'lsvr-toolkit' ); ?></a>
            		<p></p>
            	</div>

            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'crop_thumbs', $block_id, $crop_thumbs ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'crop_thumbs' ) ?>"><?php _e( 'Crop Thumbnails', 'lsvr-toolkit' ); ?></label>
                </div>
            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'carousel', $block_id, $carousel ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'carousel' ) ?>"><?php _e( 'Display as Carousel', 'lsvr-toolkit' ); ?></label>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'items_per_slide' ) ?>"><?php _e( 'Items Per Slide', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'items_per_slide', $block_id, array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ), $items_per_slide ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'items_per_slide_desktop' ) ?>"><?php _e( 'Items Per Slide Under 1200px', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'items_per_slide_desktop', $block_id, array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ), $items_per_slide_desktop ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'items_per_slide_smalldesktop' ) ?>"><?php _e( 'Items Per Slide Under 992px', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'items_per_slide_smalldesktop', $block_id, array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ), $items_per_slide_smalldesktop ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'items_per_slide_tablet' ) ?>"><?php _e( 'Items Per Slide Under 768px', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'items_per_slide_tablet', $block_id, array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ), $items_per_slide_tablet ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'items_per_slide_mobile' ) ?>"><?php _e( 'Items Per Slide Under 481px', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'items_per_slide_mobile', $block_id, array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6 ), $items_per_slide_mobile ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'block_offset' ) ?>"><?php _e( 'Block Offset', 'lsvr-toolkit' ); ?></label>
                <p class="lsvr-form-description">
                    <?php _e( 'Left offset of this block.', 'lsvr-toolkit' ); ?><br>
                </p>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'block_offset', $block_id, array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ), $block_offset ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'inview_anim' ) ?>"><?php _e( 'InView Animation', 'lsvr-toolkit' ); ?></label>
                <p class="lsvr-form-description">
                    <?php _e( 'Animation fired when element appears in the user\'s viewport.', 'lsvr-toolkit' ); ?><br>
                </p>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'inview_anim', $block_id, $inview_anim_arr, $inview_anim ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'custom_class' ) ?>"><?php _e( 'Custom Class', 'lsvr-toolkit' ); ?></label>
                <p class="lsvr-form-description">
                    <?php _e( 'It can be used for applying custom CSS.', 'lsvr-toolkit' ); ?><br>
                </p>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'custom_class', $block_id, $custom_class ); ?>
                </div>
            </div>

        </div>
    	<?php
    }

	function galitem( $galitem = array(), $count = 0 ) {

		?>
		<li id="<?php echo $this->get_field_id('galitems') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $galitem['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e( 'Open / Close', 'lsvr-toolkit' ); ?></a>
				</div>
			</div>

			<div class="sortable-body">
                <div class="lsvr-form-container">

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('galitems') ?>-<?php echo $count ?>-title"><?php _e( 'Title' , 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('galitems') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('galitems') ?>[<?php echo $count ?>][title]" value="<?php echo $galitem['title'] ?>" />
                        </div>
                    </div>

					<div class="lsvr-form-row">
						<label for="<?php echo $this->get_field_id( 'image' ) ?>"><?php _e( 'Image', 'lsvr-toolkit' ); ?></label>
						<div class="lsvr-form-field">
							<?php $galitem_image_id = $this->get_field_id('galitems') . '-' . $count . '-image'; ?>
                            <?php $galitem_image_name = $this->get_field_name('galitems') . '[' . $count . '][image]'; ?>
                            <?php $galitem_image_field = $galitem['image']; ?>
							<?php $galitem_hidden_id = $this->get_field_id('galitems') . '-' . $count . '-imageid'; ?>
                            <?php $galitem_hidden_name = $this->get_field_name('galitems') . '[' . $count . '][imageid]'; ?>
                            <?php $galitem_hidden_field = $galitem['imageid']; ?>
							<?php echo lsvr_field_upload_tabs( $galitem_image_id, $galitem_image_name, $galitem_image_field, $galitem_hidden_id, $galitem_hidden_name, $galitem_hidden_field ); ?>
						</div>
					</div>

                </div>
                <p class="tab-desc description"><a href="#" class="sortable-delete"><?php _e( 'Delete', 'lsvr-toolkit' ); ?></a></p>
			</div>

		</li>
		<?php
	}

    /* -------------------------------------------------------------------------
        OUTPUT
    ------------------------------------------------------------------------- */

	function block( $instance ) {

    	$defaults = $this->defaults;

    	$instance = wp_parse_args( $instance, $defaults );
    	extract( $instance );

		$carousel = $carousel ? 'yes' : 'no';

		$output = '[lsvr_gallery carousel="' . $carousel . '" items_per_slide="' . $items_per_slide . '" items_per_slide_desktop="' . $items_per_slide_desktop . '" items_per_slide_smalldesktop="' . $items_per_slide_smalldesktop . '" items_per_slide_tablet="' . $items_per_slide_tablet . '" items_per_slide_mobile="' . $items_per_slide_mobile . '" custom_class="' . $custom_class . '" inview_anim="' . $inview_anim . '"]';
		foreach( $galitems as $galitem ){

			if ( $crop_thumbs && array_key_exists( 'imageid', $galitem ) && is_numeric( $galitem['imageid'] ) && $items_per_slide > 1 ) {
				$image_data = lsvr_get_image_data( $galitem['imageid'] );
				$thumb_url = $image_data['medium-cropped'];
				$fullsize_url = $image_data['full'];

			}
			else {
				$thumb_url = htmlspecialchars_decode( $galitem['image'] );
				$fullsize_url = htmlspecialchars_decode( $galitem['image'] );
			}
			$output .= '<div class="gallery-item"><a href="' . $fullsize_url . '" class="lightbox">';
			$output .= '<img src="' . $thumb_url . '" alt="' . htmlspecialchars_decode( $galitem['title'] ) . '"></a>';
			if ( htmlspecialchars_decode( $galitem['title'] ) !== '' ) {
				$output .= '<p class="item-title">' . htmlspecialchars_decode( $galitem['title'] ) . '</p>';
			}
			$output .= '</div>';
		}
		$output .= '[/lsvr_gallery]';

		echo do_shortcode( $output );

	}

    /* -------------------------------------------------------------------------
        UTILS
    ------------------------------------------------------------------------- */

	function add_galitem() {

		$nonce = $_POST['security'];
		if ( ! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset( $_POST['block_id'] ) ? $_POST['block_id'] : 'aq-block-9999';

		//default key/value for the item
		$galitem = array(
            'title' => 'New Item',
			'image' => '',
			'imageid' => ''
		);

		if ( $count ) {
			$this->galitem( $galitem, $count );
		} else {
			die(-1);
		}

		die();

	}

	function update( $new_instance, $old_instance ) {
		$new_instance = aq_recursive_sanitize( $new_instance );
		return $new_instance;
	}

}
}
?>