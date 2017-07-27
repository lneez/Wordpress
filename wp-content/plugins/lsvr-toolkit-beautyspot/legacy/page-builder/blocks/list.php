<?php
if ( ! class_exists( 'lsvr_list_block' ) ) {
class lsvr_list_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array(
            'name' => __( 'List', 'lsvr-toolkit' )
        );

		parent::__construct( 'lsvr_list_block', $block_options );

        //add ajax functions
        add_action( 'wp_ajax_aq_block_item_add_new', array( $this, 'add_item' ) );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'items' => array(
            1 => array(
                'icon' => '',
                'icon_color' => '#ff007c',
                'content' => ''
            )
        ),
        'type' => 'arrows',
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
            			$items = is_array( $items ) ? $items : $defaults['items'];
            			$count = 1;
            			foreach( $items as $item ) {
            				$this->item( $item, $count );
            				$count++;
            			}
            			?>
            		</ul>
            		<p></p>
            		<a href="#" rel="item" class="lsvr-sortable-add-new button"><?php _e( 'Add New' , 'lsvr-toolkit' ); ?></a>
            		<p></p>
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

	function item( $item = array(), $count = 0 ) {

		?>
		<li id="<?php echo $this->get_field_id('items') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo sprintf( __( 'List Item %d', 'lsvr-toolkit' ), $count ); ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e( 'Open / Close', 'lsvr-toolkit' ); ?></a>
				</div>
			</div>

			<div class="sortable-body">
                <div class="lsvr-form-container">

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content"><?php _e( 'Content', 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <?php $item_content_id = $this->get_field_id('items') . '-' . $count . '-content'; ?>
                            <?php $item_content_name = $this->get_field_name('items') . '[' . $count . '][content]'; ?>
                            <?php $item_content_html = $item['content']; ?>
                            <?php echo lsvr_field_editor_tabs( $item_content_id, $item_content_name, $item_content_html ); ?>
                        </div>
                    </div>

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icon"><?php _e( 'Item Icon' , 'lsvr-toolkit' ); ?></label>
                        <p class="lsvr-form-description">
                            <?php _e( 'Name of the icon (e.g. "fa fa-cog"). You will find list of all icons in the documentation.', 'lsvr-toolkit' ); ?><br>
                        </p>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icon" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][icon]" value="<?php echo $item['icon'] ?>" />
                        </div>
                    </div>

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icon"><?php _e( 'Icon Color' , 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <?php $item_content_id = $this->get_field_id('items') . '-' . $count . '-icon_color'; ?>
                            <?php $item_content_name = $this->get_field_name('items') . '[' . $count . '][icon_color]'; ?>
                            <?php echo lsvr_field_color_picker_tabs( $item_content_id, $item_content_name, $item['icon_color'], '#61677A' ); ?>
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

		extract( $instance );

		$output = '';

        $output = '[lsvr_list custom_class="' . $custom_class . '" inview_anim="' . $inview_anim . '"]';
        foreach( $items as $item ){
            $output .= '[lsvr_list_item icon="' . $item['icon'] . '" icon_color="' . $item['icon_color'] . '"]' . wpautop( do_shortcode( htmlspecialchars_decode( $item['content'] ) ) ) . '[/lsvr_list_item]';
        }
        $output .= '[/lsvr_list]';

		echo do_shortcode( $output );

	}


    /* -------------------------------------------------------------------------
        UTILS
    ------------------------------------------------------------------------- */

	function add_item() {

		$nonce = $_POST['security'];
		if ( ! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset( $_POST['block_id'] ) ? $_POST['block_id'] : 'aq-block-9999';

		//default key/value for the item
		$item = array(
			'title' => sprintf( __( 'List Item %d', 'lsvr-toolkit' ), $count ),
            'icon' => '',
            'icon_color' => '#ff007c',
			'content' => ''
		);

		if ( $count ) {
			$this->item( $item, $count );
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