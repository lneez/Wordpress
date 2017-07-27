<?php
if ( ! class_exists( 'lsvr_team_member_block' ) ) {
class lsvr_team_member_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array(
            'name' => __( 'Team Member', 'lsvr-toolkit' )
        );

		parent::__construct( 'lsvr_team_member_block', $block_options );

        //add ajax functions
        add_action( 'wp_ajax_aq_block_social_icon_add_new', array( $this, 'add_social_icon' ) );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'portrait' => '',
        'person_name' => '',
        'description' => '',
        'html_content' => '',
        'social_icons' => array(
            1 => array(
                'title' => 'Twitter',
                'icon' => 'fa fa-twitter',
                'link' => 'https://'
            )
        ),
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
                <label for="<?php echo $this->get_field_id( 'portrait' ) ?>"><?php _e( 'Portrait', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_upload( 'portrait', $block_id, $portrait ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'person_name' ) ?>"><?php _e( 'Name', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'person_name', $block_id, $person_name ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'description' ) ?>"><?php _e( 'Description', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'description', $block_id, $description ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'html_content' ) ?>"><?php _e( 'Text', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo lsvr_field_editor( 'html_content', $block_id, $html_content ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">

                <h3 class="lsvr-form-label"><?php _e( 'Social Icons', 'lsvr-toolkit' ); ?></h3>

            	<div class="description cf">
            		<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
            			<?php
            			$social_icons = is_array( $social_icons ) ? $social_icons : $defaults['social_icons'];
            			$count = 1;
            			foreach( $social_icons as $social_icon ) {
            				$this->social_icon( $social_icon, $count );
            				$count++;
            			}
            			?>
            		</ul>
            		<p></p>
            		<a href="#" rel="social_icon" class="lsvr-sortable-add-new button"><?php _e( 'Add New' , 'lsvr-toolkit' ); ?></a>
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

	function social_icon( $social_icon = array(), $count = 0 ) {

		?>
		<li id="<?php echo $this->get_field_id('social_icons') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">

			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $social_icon['title']; ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#"><?php _e( 'Open / Close', 'lsvr-toolkit' ); ?></a>
				</div>
			</div>

			<div class="sortable-body">
                <div class="lsvr-form-container">

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('social_icons') ?>-<?php echo $count ?>-icon"><?php _e( 'Title' , 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('social_icons') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('social_icons') ?>[<?php echo $count ?>][title]" value="<?php echo $social_icon['title'] ?>" />
                        </div>
                    </div>

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('social_icons') ?>-<?php echo $count ?>-icon"><?php _e( 'Icon' , 'lsvr-toolkit' ); ?></label>
                        <p class="lsvr-form-description">
                            <?php _e( 'Name of the icon (e.g. "fa fa-twiter"). You will find list of all icons in the documentation.', 'lsvr-toolkit' ); ?><br>
                        </p>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('social_icons') ?>-<?php echo $count ?>-icon" class="input-full" name="<?php echo $this->get_field_name('social_icons') ?>[<?php echo $count ?>][icon]" value="<?php echo $social_icon['icon'] ?>" />
                        </div>
                    </div>

                    <div class="lsvr-form-row">
                        <label for="<?php echo $this->get_field_id('social_icons') ?>-<?php echo $count ?>-icon"><?php _e( 'Link' , 'lsvr-toolkit' ); ?></label>
                        <div class="lsvr-form-field">
                            <input type="text" id="<?php echo $this->get_field_id('social_icons') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('social_icons') ?>[<?php echo $count ?>][link]" value="<?php echo $social_icon['link'] ?>" />
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

        $social_icons_str = '';

        foreach( $social_icons as $social_icon ){

            $social_icons_str .= $social_icon['icon'] . ',' . $social_icon['link'];
            if ( $social_icon !== end($social_icons) ) {
                $social_icons_str .= '|';
            }

        }

        $output = '[lsvr_team_member portrait="' . $portrait . '" person_name="' . $person_name . '" description="' . $description . '" social_icons="' . $social_icons_str . '" custom_class="' . $custom_class . '" inview_anim="' . $inview_anim . '"]';
        $output .= wpautop( do_shortcode( htmlspecialchars_decode( $html_content ) ) );
        $output .= '[/lsvr_team_member]';

		echo do_shortcode( $output );

	}


    /* -------------------------------------------------------------------------
        UTILS
    ------------------------------------------------------------------------- */

	function add_social_icon() {

		$nonce = $_POST['security'];
		if ( ! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');

		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset( $_POST['block_id'] ) ? $_POST['block_id'] : 'aq-block-9999';

		//default key/value for the item
		$social_icon = array(
            'title' => 'New Icon',
            'icon' => '',
			'link' => ''
		);

		if ( $count ) {
			$this->social_icon( $social_icon, $count );
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