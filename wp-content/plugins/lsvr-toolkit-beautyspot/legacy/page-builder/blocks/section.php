<?php
if ( ! class_exists( 'lsvr_section_block' ) ) {
class lsvr_section_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array (
            'name' => __( 'Section', 'lsvr-toolkit' )
        );
        parent::__construct( 'lsvr_section_block', $block_options );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
		'fullsize' => 'no',
		'wrap_in_container' => 'no',
        'title' => '',
		'subtitle' => '',
		'button_label' => '',
		'button_link' => '',
        'html_content' => '',
        'block_offset' => 0,
        'inview_anim' => 'none',
        'custom_class' => '',
		'custom_id' => ''
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
                <label for="<?php echo $this->get_field_id( 'subtitle' ) ?>"><?php _e( 'Subtitle', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'subtitle', $block_id, $subtitle ); ?>
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
                <label for="<?php echo $this->get_field_id( 'html_content' ) ?>"><?php _e( 'Content', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo lsvr_field_editor( 'html_content', $block_id, $html_content ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <p class="lsvr-form-description">
                    <?php _e( 'Enable if this section is used in fullsize template.', 'lsvr-toolkit' ); ?><br>
                </p>
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'fullsize', $block_id, $fullsize ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'fullsize' ) ?>"><?php _e( 'Fullsize', 'lsvr-toolkit' ); ?></label>
                </div>
            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'wrap_in_container', $block_id, $wrap_in_container ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'wrap_in_container' ) ?>"><?php _e( 'Wrap Content in Container', 'lsvr-toolkit' ); ?></label>
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

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'custom_id' ) ?>"><?php _e( 'Custom ID', 'lsvr-toolkit' ); ?></label>
                <p class="lsvr-form-description">
                    <?php _e( 'It can be used for applying custom CSS.', 'lsvr-toolkit' ); ?><br>
                </p>
                <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'custom_id', $block_id, $custom_id ); ?>
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
		$wrap_in_container = $wrap_in_container ? 'yes' : 'no';

        echo do_shortcode( '[lsvr_section fullsize="' . $fullsize . '" wrap_in_container="' . $wrap_in_container . '" title="' . $title . '" subtitle="' . $subtitle . '" button_label="' . $button_label . '" button_link="' . $button_link . '" inview_anim="' . $inview_anim . '" custom_class="' . $custom_class . ' custom_id="' . $custom_id . '"]' . lsvr_field_editor_output( $html_content ) . '[/lsvr_section]' );

    }

}
}
?>