<?php
if ( ! class_exists( 'lsvr_pricing_table_block' ) ) {
class lsvr_pricing_table_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array (
            'name' => __( 'Pricing Table', 'lsvr-toolkit' )
        );
        parent::__construct( 'lsvr_pricing_table_block', $block_options );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'title' => '',
        'price' => '',
        'price_description' => '',
        'button_label' => '',
        'button_link' => '',
        'block_offset' => 0,
        'inview_anim' => 'none',
        'custom_class' => '',
		'html_content' => ''
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
                <label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'title', $block_id, $title ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'price' ) ?>"><?php _e( 'Price', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'price', $block_id, $price ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'price_description' ) ?>"><?php _e( 'Price Description', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'price_description', $block_id, $price_description ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'html_content' ) ?>"><?php _e( 'Content', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo lsvr_field_editor( 'html_content', $block_id, $html_content ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'button_label' ) ?>"><?php _e( 'Button Label', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'button_label', $block_id, $button_label ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'button_link' ) ?>"><?php _e( 'Button Link', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'button_link', $block_id, $button_link ); ?>
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

        echo do_shortcode( '[lsvr_pricing_table title="' . $title . '" price="' . $price . '" price_description="' . $price_description . '" button_label="' . $button_label . '" button_link="' . $button_link . '" inview_anim="' . $inview_anim . '" custom_class="' . $custom_class . '"]' . lsvr_field_editor_output( $html_content ) . '[/lsvr_pricing_table]' );

    }

}
}
?>