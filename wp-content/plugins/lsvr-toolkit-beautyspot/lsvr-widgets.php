<?php

/* -----------------------------------------------------------------------------

    Add custom widgets

----------------------------------------------------------------------------- */

if ( ! function_exists( 'lsvr_custom_widgets' ) ) {

    function lsvr_custom_widgets() {

        register_widget( 'Lsvr_Mailchimp_Subscribe' );
		register_widget( 'Lsvr_Flickr_Feed' );

    }
    add_action( 'widgets_init', 'lsvr_custom_widgets' );

}


/* -----------------------------------------------------------------------------

    MAILCHIMP SUBSCRIBE WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Mailchimp_Subscribe' ) ) {
class Lsvr_Mailchimp_Subscribe extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'mailchimp-subscribe', 'description' => __( 'Mailchimp Subscribe Form', 'lsvr-toolkit' ) );
        parent::__construct( 'mailchimp_subscribe', __( 'Mailchimp Subscribe', 'lsvr-toolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Our Newsletter', 'lsvr-toolkit' ), 'description' => '', 'mailchimp_link' => '' ) );

        $title = $instance['title'];
        $description = $instance['description'];
        $mailchimp_link = esc_url( $instance['mailchimp_link'] );

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvr-toolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php echo __( 'Description:', 'lsvr-toolkit' ); ?></label>
            <textarea rows="6" class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $description; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'mailchimp_link' ); ?>"><?php echo __( 'Mailchimp Link:', 'lsvr-toolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'mailchimp_link' ); ?>" name="<?php echo $this->get_field_name( 'mailchimp_link' ); ?>" type="text" value="<?php echo $mailchimp_link; ?>" />
        </p>
        <p class="description"><?php _e( 'Please refer to the documentation on how to obtain a correct link.', 'lsvr-toolkit' ); ?></p>
        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['description'] = $new_instance['description'];
        $instance['mailchimp_link'] = esc_url( $new_instance['mailchimp_link'] );
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        if ( empty($title) ) { $title = false; }
        $description = array_key_exists( 'description', $instance ) ? $instance['description'] : '';
        $mailchimp_link = esc_url( $instance['mailchimp_link'] );

        ?>

		<?php echo $before_widget; ?>
            <?php echo $before_title; ?><?php echo $title; ?><?php echo $after_title; ?>
            <div class="widget-content">
                <form action="<?php echo esc_url( $mailchimp_link ); ?>" method="get" id="mailchimp-subscribe-form">
                    <div class="subscribe-inner">

                        <?php if ( $description !== '' ) : ?>
                        <div class="description various-content"><?php echo wpautop( $description ); ?></div>
                        <?php endif; ?>

						<!-- VALIDATION ERROR MESSAGE : begin -->
						<p style="display: none;" class="c-alert-message m-warning m-validation-error"><i class="ico fa fa-exclamation-circle"></i>
						<?php _e( 'Your email address is required.', 'lsvr-toolkit' ); ?></p>
						<!-- VALIDATION ERROR MESSAGE : end -->

						<!-- SENDING REQUEST ERROR MESSAGE : begin -->
						<p style="display: none;" class="c-alert-message m-warning m-request-error"><i class="ico fa fa-exclamation-circle"></i>
						<?php _e( 'There was a connection problem. Try again later.', 'lsvr-toolkit' ); ?></p>
						<!-- SENDING REQUEST ERROR MESSAGE : end -->

						<!-- SUCCESS MESSAGE : begin -->
						<p style="display: none;" class="c-alert-message m-success"><i class="ico fa fa-check-circle"></i>
						<?php _e( '<strong>Form sent successfully!</strong>', 'lsvr-toolkit' ); ?></p>
						<!-- SUCCESS MESSAGE : end -->

                        <div class="form-fields">
                            <input class="m-required m-email" type="text" name="EMAIL" data-placeholder="<?php _e( 'Your Email Address', 'lsvr-toolkit' ); ?>">
                            <button class="c-button submit-btn" type="submit" data-label="<?php _e( 'Subscribe', 'lsvr-toolkit' ); ?>" data-loading-label="<?php _e( 'Sending...' , 'lsvr-toolkit' ); ?>"><?php _e( 'Subscribe', 'lsvr-toolkit' ); ?></button>
                        </div>

                    </div>
                </form>
            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}


/* -----------------------------------------------------------------------------

    Flickr widget

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Flickr_Feed' ) ) {
class Lsvr_Flickr_Feed extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'flickr-feed', 'description' => __( 'Basic Flickr Feed', 'lsvr-toolkit' ) );
        parent::__construct( 'flickr_feed', __( 'Flickr Feed', 'lsvr-toolkit' ), $widget_ops);
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Flickr Feed', 'lsvr-toolkit' ), 'limit' => 10, 'flickr_id' => '' ) );

        $title = esc_html( $instance['title'] );
        $flickr_id = esc_attr( $instance['flickr_id'] );
        $limit = (int) esc_attr( $instance['limit'] );

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvr-toolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'flickr_id' ); ?>"><?php echo __( 'Flickr ID:', 'lsvr-toolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'flickr_id' ); ?>" name="<?php echo $this->get_field_name( 'flickr_id' ); ?>" type="text" value="<?php echo $flickr_id; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php echo __( 'Number of Photos:', 'lsvr-toolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo $limit; ?>" />
        </p>
        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = esc_html( $new_instance['title'] );
        $instance['flickr_id'] = esc_attr( $new_instance['flickr_id'] );
        $instance['limit'] = (int) esc_attr( $new_instance['limit'] );
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', esc_html( $instance['title'] ) );
        if ( empty($title) ) { $title = false; }
        $flickr_id = esc_attr( $instance['flickr_id'] );
        $limit = (int) esc_attr( $instance['limit'] );
        ?>

		<?php echo $before_widget; ?>
			<div class="flickr-feed-inner m-loading" data-id="<?php echo $flickr_id; ?>" data-limit="<?php echo $limit; ?>">
				<?php echo $before_title; ?><?php echo $title; ?><?php echo $after_title; ?>
				<div class="widget-content">

					<span class="c-loading-anim"><span></span></span>
					<div class="widget-feed"></div>

				</div>
			</div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>