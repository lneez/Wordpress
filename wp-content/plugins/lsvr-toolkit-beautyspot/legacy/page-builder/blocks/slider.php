<?php
if ( ! class_exists( 'lsvr_slider_block' ) ) {
class lsvr_slider_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array (
            'name' => __( 'Slider', 'lsvr-toolkit' )
        );
        parent::__construct( 'lsvr_slider_block', $block_options );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'slider' => '',
        'fullsize' => false,
        'interval' => 0,
        'block_offset' => 0,
        'custom_class' => ''
    );

    /* -------------------------------------------------------------------------
        FORM
    ------------------------------------------------------------------------- */

    function form( $instance ) {

        $defaults = $this->defaults;

        // check for slides groups taxonomy terms
        $slides_group_tax = get_terms( 'lsvrslider', 'hide_empty=0&hierarchical=0&parent=0' ) ;
        $slides_groups_arr = array( 'none' => __( 'None', 'lsvr-toolkit' ) );
        if ( count( $slides_group_tax ) > 0 ) {
            foreach ( $slides_group_tax as $value ) {
                $slides_groups_arr[$value->slug] = $value->name;
            }
        }
        $instance = wp_parse_args( $instance, $defaults );
        extract( $instance );

        ?>
        <div class="lsvr-form-container">

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'slider' ) ?>"><?php _e( 'Slider', 'lsvr-toolkit' ); ?></label>
                <p class="lsvr-form-description">
                    <?php _e( 'Which slider will be used. You can manage sliders under <strong>Slider / Sliders</strong>. Choose <strong>None</strong> to load all slides.', 'lsvr-toolkit' ); ?><br>
                </p>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'slider', $block_id, $slides_groups_arr, $slider ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'fullsize', $block_id, $fullsize ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'fullsize' ) ?>"><?php _e( 'Fullsize', 'lsvr-toolkit' ); ?></label>
                </div>
                <p class="lsvr-form-description">
                    <?php _e( 'Enable if you are using this slider in Fullsize template.', 'lsvr-toolkit' ); ?><br>
                </p>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'interval' ) ?>"><?php _e( 'Interval', 'lsvr-toolkit' ); ?></label>
                <p class="lsvr-form-description">
                    <?php _e( 'Duration between transitions in seconds. Add 0 to disable automatic slideshow.', 'lsvr-toolkit' ); ?><br>
                </p>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'interval', $block_id, array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20 ), $interval ); ?>
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

        $fullsize = $fullsize ? 'yes' : 'no';

        echo do_shortcode( '[lsvr_slider slider="' . $slider . '" fullsize="' . $fullsize . '" interval="' . $interval . '" custom_class="' . $custom_class . '"]' );

    }

}
}
?>