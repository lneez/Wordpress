<?php
if ( ! class_exists( 'lsvr_tabs_block' ) ) {
class lsvr_tabs_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array(
            'name' => __( 'Tabs &amp; Accordion', 'lsvr-toolkit' )
        );

		parent::__construct( 'lsvr_tabs_block', $block_options );

        //add ajax functions
        add_action( 'wp_ajax_aq_block_tab_add_new', array( $this, 'add_tab' ) );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'tabs' => array(
            1 => array(
                'title' => 'My New Tab',
				'price' => '',
				'oldprice' => '',
                'content' => '',
				'opened' => false
            )
        ),
        'type' => 'tab_horizontal',
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

    	$tab_types = array(
    		'tab_horizontal' => __( 'Tabs', 'lsvr-toolkit' ),
    		'toggle' => __( 'Toggles', 'lsvr-toolkit' ),
    		'accordion' => __( 'Accordion', 'lsvr-toolkit' )
    	);

    	?>

        <div class="lsvr-form-container">

            <div class="lsvr-form-row">

                <h3 class="lsvr-form-label"><?php _e( 'Tabs', 'lsvr-toolkit' ); ?></h3>

            	<div class="description cf">
            		<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
            			<?php
            			$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
            			$count = 1;
            			foreach($tabs as $tab) {
            				$this->tab($tab, $count);
            				$count++;
            			}
            			?>
            		</ul>
            		<p></p>
            		<a href="#" rel="tab" class="lsvr-sortable-add-new button"><?php _e( 'Add New' , 'lsvr-toolkit' ); ?></a>
            		<p></p>
            	</div>

            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'type' ) ?>"><?php _e( 'Tabs Style', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'type', $block_id, $tab_types, $type ); ?>
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

	function tab($tab = array(), $count = 0) {

		?>
		<li id="<?php echo $this->get_field_id('tabs') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $tab['title'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e( 'Open / Close', 'lsvr-toolkit' ); ?></a>
				</div>
			</div>

			<div class="sortable-body">
                <div class="lsvr-form-container">

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title"><?php _e( 'Title' , 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][title]" value="<?php echo $tab['title'] ?>" />
                        </div>
                    </div>

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-price"><?php _e( 'Price Info' , 'lsvr-toolkit' ); ?></label>
						<p class="lsvr-form-description">
							<?php _e( 'For Accordion/Toggle only.', 'lsvr-toolkit' ); ?><br>
						</p>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-price" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][price]" value="<?php echo $tab['price'] ?>" />
                        </div>
                    </div>

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-oldprice"><?php _e( 'Old Price Info' , 'lsvr-toolkit' ); ?></label>
						<p class="lsvr-form-description">
							<?php _e( 'For Accordion/Toggle only.', 'lsvr-toolkit' ); ?><br>
						</p>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-oldprice" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][oldprice]" value="<?php echo $tab['oldprice'] ?>" />
                        </div>
                    </div>

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content"><?php _e( 'Content', 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <?php $tab_content_id = $this->get_field_id('tabs') . '-' . $count . '-content'; ?>
                            <?php $tab_content_name = $this->get_field_name('tabs') . '[' . $count . '][content]'; ?>
                            <?php $tab_content_html = $tab['content']; ?>
                            <?php echo lsvr_field_editor_tabs( $tab_content_id, $tab_content_name, $tab_content_html ); ?>
                        </div>
                    </div>

					<?php if ( ! array_key_exists( 'opened', $tab ) ) { $tab['opened'] = false; } ?>
                    <div class="lsvr-form-row">
						<div class="lsvr-form-field">
							<input type="checkbox"
								id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-opened"
								name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][opened]"
								<?php if ( $tab['opened'] ) { echo ' checked'; } ?>>
							<label style="display: inline;" for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-opened"><?php _e( 'Opened' , 'lsvr-toolkit' ); ?></label>
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

		if ( $type == 'tab_horizontal' ) {

            $output = '[lsvr_tabs custom_class="' . $custom_class . '" inview_anim="' . $inview_anim . '"]';
            foreach( $tabs as $tab ){
                $output .= '[lsvr_tab_item title="' . $tab['title'] . '"]' . htmlspecialchars_decode( $tab['content'] ) . '[/lsvr_tab_item]';
			}
            $output .= '[/lsvr_tabs]';

        } elseif ( $type == 'toggle' ) {

            $output = '[lsvr_accordion custom_class="' . $custom_class . '" toggle="yes" inview_anim="' . $inview_anim . '"]';
            foreach( $tabs as $tab ){

				$state = array_key_exists( 'opened', $tab ) && $tab['opened'] ? 'opened' : 'closed';
                $output .= '[lsvr_accordion_item title="' . $tab['title'] . '" price="' . $tab['price'] . '" oldprice="' . $tab['oldprice'] . '" state="' . $state . '"]' . htmlspecialchars_decode( $tab['content'] ) . '[/lsvr_accordion_item]';

			}
            $output .= '[/lsvr_accordion]';

		} elseif ( $type == 'accordion' ) {

            $output = '[lsvr_accordion custom_class="' . $custom_class . '" inview_anim="' . $inview_anim . '"]';
            foreach( $tabs as $tab ){

				$state = array_key_exists( 'opened', $tab ) && $tab['opened'] ? 'opened' : 'closed';
                $output .= '[lsvr_accordion_item title="' . $tab['title'] . '" price="' . $tab['price'] . '" oldprice="' . $tab['oldprice'] . '" state="' . $state . '"]' . htmlspecialchars_decode( $tab['content'] ) . '[/lsvr_accordion_item]';

			}
            $output .= '[/lsvr_accordion]';

		}

		echo do_shortcode( $output );

	}

    /* -------------------------------------------------------------------------
        UTILS
    ------------------------------------------------------------------------- */

	function add_tab() {

		$nonce = $_POST['security'];
		if ( ! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset( $_POST['block_id'] ) ? $_POST['block_id'] : 'aq-block-9999';

		//default key/value for the tab
		$tab = array(
			'title' => __( 'New Tab', 'lsvr-toolkit' ),
			'price' => '',
			'oldprice' => '',
			'content' => '',
			'opened' => false
		);

		if ( $count ) {
			$this->tab( $tab, $count );
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