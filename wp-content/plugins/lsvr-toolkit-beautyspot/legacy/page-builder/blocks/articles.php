<?php
if ( ! class_exists( 'lsvr_articles_block' ) ) {
class lsvr_articles_block extends lsvr_block {

    /* -------------------------------------------------------------------------
        CONSTRUCTOR
    ------------------------------------------------------------------------- */

    function __construct() {

        $block_options = array (
            'name' => __( 'Articles', 'lsvr-toolkit' )
        );
        parent::__construct( 'lsvr_articles_block', $block_options );

    }

    /* -------------------------------------------------------------------------
        DEFAULTS
    ------------------------------------------------------------------------- */

    private $defaults = array(
        'title' => '',
        'category' => '',
        'number_of_items' => 3,
        'show_post_date' => true,
        'show_post_media' => true,
        'show_post_excerpt' => true,
        'excerpt_length' => 40,
        'block_offset' => 0,
        'inview_anim' => 'none',
        'custom_class' => ''
    );

    /* -------------------------------------------------------------------------
        FORM
    ------------------------------------------------------------------------- */

    function form( $instance ) {

        $defaults = $this->defaults;

        // check for slides groups taxonomy terms
        $categories_tax = get_categories( 'hide_empty=1&hierarchical=0&parent=0' ) ;
        $categories_arr = array( 'none' => __( 'None', 'lsvr-toolkit' ) );
        if ( count( $categories_tax ) > 0 ) {
            foreach ( $categories_tax as $value ) {
                $categories_arr[$value->slug] = $value->name;
            }
        }

        global $lsvr_inview_animations;
        $inview_anim_arr = $lsvr_inview_animations;

        $instance = wp_parse_args( $instance, $defaults );
        extract( $instance );

        ?>
        <div class="lsvr-form-container">

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'category' ) ?>"><?php _e( 'Category', 'lsvr-toolkit' ); ?></label>
                <p class="lsvr-form-description">
                    <?php _e( 'Category to load posts from. Choose <strong>None</strong> to load posts regardless of category.', 'lsvr-toolkit' ); ?><br>
                </p>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'category', $block_id, $categories_arr, $category ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'number_of_items' ) ?>"><?php _e( 'Number of Items', 'lsvr-toolkit' ); ?></label>
                <div class="lsvr-form-field">
                    <?php echo aq_field_select( 'number_of_items', $block_id, array( '1' => 1, '2' => 2, '3' => 3, '4' => 4 ), $number_of_items ); ?>
                </div>
            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'show_post_date', $block_id, $show_post_date ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'show_post_date' ) ?>"><?php _e( 'Show Post Date', 'lsvr-toolkit' ); ?></label>
                </div>
            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'show_post_media', $block_id, $show_post_media ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'show_post_media' ) ?>"><?php _e( 'Show Post Media', 'lsvr-toolkit' ); ?></label>
                </div>
            </div>

            <div class="lsvr-form-row">
                <div class="lsvr-form-field">
                    <?php echo aq_field_checkbox( 'show_post_excerpt', $block_id, $show_post_excerpt ); ?>
                    <label class="lsvr-checkbox-label" for="<?php echo $this->get_field_id( 'show_post_excerpt' ) ?>"><?php _e( 'Show Post Excerpt', 'lsvr-toolkit' ); ?></label>
                </div>
            </div>

            <div class="lsvr-form-row">
                <label for="<?php echo $this->get_field_id( 'excerpt_length' ) ?>"><?php _e( 'Excerpt Length', 'lsvr-toolkit' ); ?></label>
                  <div class="lsvr-form-field">
                    <?php echo aq_field_input( 'excerpt_length', $block_id, $excerpt_length ); ?>
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

        $show_post_date = $show_post_date ? 'show' : 'hide';
        $show_post_media = $show_post_media ? 'show' : 'hide';
        $show_post_excerpt = $show_post_excerpt ? 'show' : 'hide';

        echo do_shortcode( '[lsvr_articles category="' . $category . '" number_of_items="' . $number_of_items . '" show_post_date="' . $show_post_date . '" show_post_media="' . $show_post_media . '" show_post_excerpt="' . $show_post_excerpt . '" excerpt_length="' . $excerpt_length . '" inview_anim="' . $inview_anim . '" custom_class="' . $custom_class . '"]' );

    }

}
}
?>