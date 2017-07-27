<?php
if ( ! class_exists( 'lsvr_carousel_block' ) ) {
class lsvr_carousel_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array(
            'name' => __( 'Carousel', 'lsvr-toolkit' )
        );

		parent::__construct( 'lsvr_carousel_block', $block_options );

        //add ajax functions
        add_action( 'wp_ajax_aq_block_caritem_add_new', array( $this, 'add_caritem' ) );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'caritems' => array(
            1 => array(
                'title' => 'New Item',
                'content' => ''
            )
        ),
		'wrap_in_container' => false,
		'transparent_bg' => true,
		'bg_color' => '',
		'items_per_slide' => 1,
		'items_per_slide_desktop' => 1,
		'items_per_slide_smalldesktop' => 1,
		'items_per_slide_tablet' => 1,
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
            			$caritems = is_array( $caritems ) ? $caritems : $defaults['caritems'];
            			$count = 1;
            			foreach( $caritems as $caritem ) {
            				$this->caritem( $caritem, $count );
            				$count++;
            			}
            			?>
            		</ul>
            		<p></p>
            		<a href="#" rel="caritem" class="lsvr-sortable-add-new button"><?php _e( 'Add New' , 'lsvr-toolkit' ); ?></a>
            		<p></p>
            	</div>

            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'wrap_in_container', $block_id, $wrap_in_container ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'wrap_in_container' ) ?>"><?php _e( 'Wrap in Container', 'lsvr-toolkit' ); ?></label>
                </div>
            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'transparent_bg', $block_id, $transparent_bg ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'transparent_bg' ) ?>"><?php _e( 'Transparent Background', 'lsvr-toolkit' ); ?></label>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'bg_color' ) ?>"><?php _e( 'Background Color', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_color_picker( 'bg_color', $block_id, $bg_color, '#FFFFFF' ); ?>
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

	function caritem( $caritem = array(), $count = 0 ) {

		?>
		<li id="<?php echo $this->get_field_id('caritems') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $caritem['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e( 'Open / Close', 'lsvr-toolkit' ); ?></a>
				</div>
			</div>

			<div class="sortable-body">
                <div class="lsvr-form-container">

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('caritems') ?>-<?php echo $count ?>-title"><?php _e( 'Title' , 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('caritems') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('caritems') ?>[<?php echo $count ?>][title]" value="<?php echo $caritem['title'] ?>" />
                        </div>
                    </div>

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('caritems') ?>-<?php echo $count ?>-content"><?php _e( 'Content', 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <?php $caritem_content_id = $this->get_field_id('caritems') . '-' . $count . '-content'; ?>
                            <?php $caritem_content_name = $this->get_field_name('caritems') . '[' . $count . '][content]'; ?>
                            <?php $caritem_content_html = $caritem['content']; ?>
                            <?php echo lsvr_field_editor_tabs( $caritem_content_id, $caritem_content_name, $caritem_content_html ); ?>
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

		$wrap_in_container = $wrap_in_container ? 'yes' : 'no';
		$transparent_bg = $transparent_bg ? 'yes' : 'no';

		$output = '';
		$output = '[lsvr_carousel wrap_in_container="' . $wrap_in_container . '" transparent_bg="' . $transparent_bg . '" bg_color="' . $bg_color . '" items_per_slide="' . $items_per_slide . '" items_per_slide_desktop="' . $items_per_slide_desktop . '" items_per_slide_smalldesktop="' . $items_per_slide_smalldesktop . '" items_per_slide_tablet="' . $items_per_slide_tablet . '" items_per_slide_mobile="' . $items_per_slide_mobile . '" custom_class="' . $custom_class . '" inview_anim="' . $inview_anim . '"]';
		foreach( $caritems as $caritem ){
			$output .= '<div class="carousel-item">' . htmlspecialchars_decode( $caritem['content'] ) . '</div>';
		}
		$output .= '[/lsvr_carousel]';

		echo do_shortcode( $output );

	}

    /* -------------------------------------------------------------------------
        UTILS
    ------------------------------------------------------------------------- */

	function add_caritem() {

		$nonce = $_POST['security'];
		if ( ! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset( $_POST['block_id'] ) ? $_POST['block_id'] : 'aq-block-9999';

		//default key/value for the item
		$caritem = array(
            'title' => 'New Item',
            'content' => ''
		);

		if ( $count ) {
			$this->caritem( $caritem, $count );
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