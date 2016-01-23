<?php
/**
 * Generic Template Widget
 */
if ( ! class_exists( 'Generic_Template_Widget' ) ) :
class Generic_Template_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'generic_template', 
            __( 'Generic Template Widget', GEN_TEXT_DOMAIN ), 
            array( 'description' => __( 'Generic Template Widget', GEN_TEXT_DOMAIN ), ) 
        );
    }

    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = ( ! empty( $instance['title'] ) ) ? strip_tags( $instance['title'] ) : '';
        $image = ( ! empty( $instance['image'] ) ) ? esc_url_raw( $instance['image'] ) : '';
        $content = ( ! empty( $instance['content'] ) ) ? $instance['content'] : '';
        $url_text = ( ! empty( $instance['url_text'] ) ) ? strip_tags( $instance['url_text'] ) : '';
        $url = ( ! empty( $instance['url'] ) ) ? esc_url_raw( $instance['url'] ) : '';
        ?>
         <div class="widget widget_featured-entry">
            <?php if( ! empty( $image ) ): ?>
                <img src="<?php echo $image; ?>" />
            <?php endif; ?>
            <div class="widget-body">
                <h4 class='entry-title'><?php echo $title; ?></h4>
                <div class="entry-excerpt">
                    <?php echo $content; ?>
                    <?php if ( ! empty( $url_text ) && ! empty( $url ) ) { ?>
                        <a class="read-more" href='<?php echo $url?>' target="_blank"><?php echo $url_text ?><i class='fa fa-chevron-right'></i></a>
                    <?php } ?>
                </div>
            </div>
        </div><!-- /widget -->   
        <?php
    }

    public function update ( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['image'] = ( ! empty( $new_instance['image'] ) ) ? esc_url_raw( $new_instance['image'] ) : '';
        $instance['content'] = ( !empty($new_instance['content']) ? $new_instance['content'] : '' );
        $instance['url_text'] = ( ! empty( $new_instance['url_text'] ) ) ? strip_tags( $new_instance['url_text'] ) : '';
        $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? esc_url_raw( $new_instance['url'] ) : '';

        do_action( 'wp_editor_widget_update', $new_instance, $instance );
        return apply_filters( 'wp_editor_widget_update_instance', $instance, $new_instance );
    }
            
    // Widget Backend 
    public function form( $instance ) {
        $instance_defaults = array(
            'title'     => '',
            'image'     => '',
            'content'   => '',
            'url_text'  => '',
            'url'       => '',
        );

        $instance = wp_parse_args( $instance, $instance_defaults );

        $title = strip_tags( $instance[ 'title' ] );
        $image = esc_url_raw( $instance[ 'image' ] );
        $content =  $instance[ 'content' ];
        $url_text = strip_tags( $instance[ 'url_text' ] );
        $url = strip_tags( $instance[ 'url' ] );
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( "Title:", GEN_TEXT_DOMAIN ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <div>
            <input type="text" id="generic-template-img-url" class="img-holder" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $image; ?>" readonly="readonly" />
            <input type="button" class="button-secondary generic-template-image" id="image-<?php echo $this->get_field_id('content'); ?>" name="risi_generic_template_img" value="<?php _e( 'Choose image.', GEN_TEXT_DOMAIN ) ?>"><br />
        </div>
        <p>
            <textarea id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" style="display:none"><?php echo $content; ?></textarea>
            <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'content' ); ?>');" class="button"><?php _e( 'Edit content', GEN_TEXT_DOMAIN ) ?></a>
        </p>
        <p><label for="<?php echo $this->get_field_id('url_text'); ?>"><?php _e( "URL Text:", GEN_TEXT_DOMAIN ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('url_text'); ?>" name="<?php echo $this->get_field_name('url_text'); ?>" type="text" value="<?php echo $url_text; ?>" /></p>
        <p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e( "URL:", GEN_TEXT_DOMAIN ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" /></p>
    <?php
    }
}

$gt_widget = new Generic_Template_Widget();

// Register the Widget
register_widget( 'Generic_Template_Widget' );
endif;