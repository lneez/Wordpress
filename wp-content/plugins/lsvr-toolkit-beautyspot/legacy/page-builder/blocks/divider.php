<?php
if ( ! class_exists( 'lsvr_divider_block' ) ) {
class lsvr_divider_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array (
            'name' => __( 'Divider', 'lsvr-toolkit' )
        );
        parent::__construct( 'lsvr_divider_block', $block_options );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'whitespace_size' => 'normal',
		'transparent' => 'no',
        'block_offset' => 0,
        'inview_anim' => 'none',
        'custom_class' => ''
    );

    /* -------------------------------------------------------------------------
        FORM
    ------------------------------------------------------------------------- */

    function form( $instance ) {

        $defaults = $this->defaults;

        $whitespace_size_arr = array( 'm-small' => __( 'Default', 'lsvr-toolkit' ), 'm-x-small' => __( 'Small', 'lsvr-toolkit' ), 'm-medium' => __( 'Medium', 'lsvr-toolkit' ), 'm-large' => __( 'Large', 'lsvr-toolkit' ) );

        global $lsvr_inview_animations;
        $inview_anim_arr = $lsvr_inview_animations;

        $instance = wp_parse_args( $instance, $defaults );
        extract( $instance );

        ?>
        <div class="lsvr-form-container">

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'whitespace_size' ) ?>"><?php _e( 'Whitespace Size', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'whitespace_size', $block_id, $whitespace_size_arr, $whitespace_size ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'transparent', $block_id, $transparent ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'transparent' ) ?>"><?php _e( 'Transparent', 'lsvr-toolkit' ); ?></label>
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

    /* -------------------------------------------------------------------------
        OUTPUT
    ------------------------------------------------------------------------- */

    function block( $instance ) {

    	$defaults = $this->defaults;

    	$instance = wp_parse_args( $instance, $defaults );
    	extract( $instance );

		$transparent = $transparent ? 'yes' : 'no';

        echo do_shortcode( '[lsvr_divider transparent="' . $transparent . '" whitespace_size="' . $whitespace_size . '" inview_anim="' . $inview_anim . '" custom_class="' . $custom_class . '"]' );

    }

}
}
?>