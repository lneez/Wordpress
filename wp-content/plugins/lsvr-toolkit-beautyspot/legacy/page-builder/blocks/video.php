<?php
if ( ! class_exists( 'lsvr_video_block' ) ) {
class lsvr_video_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array (
            'name' => __( 'Video', 'lsvr-toolkit' )
        );
        parent::__construct( 'lsvr_video_block', $block_options );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'embed_code' => '',
        'block_offset' => 0,
        'inview_anim' => 'none',
        'custom_class' => ''
    );

    /* -------------------------------------------------------------------------
        FORM
    ------------------------------------------------------------------------- */

    function form( $instance ) {

        $defaults = $this->defaults;

        global $lsvr_inview_animations;
        $inview_anim_arr = $lsvr_inview_animations;

        $instance = wp_parse_args( $instance, $defaults );
        extract( $instance );

        ?>
        <div class="lsvr-form-container">

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'embed_code' ) ?>"><?php _e( 'Embed Code', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_textarea( 'embed_code', $block_id, $embed_code ); ?>
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

        echo do_shortcode( '[lsvr_video inview_anim="' . $inview_anim . '" custom_class="' . $custom_class . '"]' . $embed_code . '[/lsvr_video]' );

    }

}
}
?>