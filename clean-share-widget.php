<?php
/*
Plugin Name: Clean Share Widget Plugin
Plugin URI: http://github.com/joshbroton/clean-share-widget
Description: A fast and (mostly) JavaScript-free social share widget.
Version: 0.0.1
Author: Josh Broton
Author URI: http://joshbroton.com
License: GPL2
*/

class wp_clean_share_widget_plugin extends WP_Widget {

    // constructor
    public function __construct() {
        parent::WP_Widget(false, $name = __('Clean Share Widget', 'wp_widget_plugin') );
    }

    // widget form creation
    public function form($instance) {
        // Check values
        if( $instance ) {
                // Set variables from properties inputs
                $title = esc_attr( $instance['title'] );
                $twitter_account = esc_attr($instance['twitter_account']);

                // remove first character if it's an '@'
                if ( $twitter_account[0] == '@' ) {
                    $twitter_account = substr( $twitter_account, 1) ;
                }
        } else {
             $title = '';
             $twitter_account = '';
        }
        ?>
        <div class="wrap">
            <ul>
                <li>
                    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                </li>
                <li>
                    <label for="<?php echo $this->get_field_id('twitter_account'); ?>"><?php _e('"Author" Twitter Account:', 'wp_widget_plugin'); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id('twitter_account'); ?>" name="<?php echo $this->get_field_name('twitter_account'); ?>" type="text" value="<?php echo $twitter_account; ?>" />
                </li>
            </ul>
        </div>
        <?php
    }

    // widget update
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['twitter_account'] = strip_tags($new_instance['twitter_account']);

        // remove first character if it's an '@'
        if ( $instance['twitter_account'][0] == '@' ) {
            $instance['twitter_account'] = substr( $instance['twitter_account'], 1) ;
        }

        return $instance;
    }

    // widget display
    public function widget($args, $instance) {
        extract( $args );
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $twitter_account = $instance['twitter_account'];

        // Get this post's ID
        $post_id = $GLOBALS['post']->ID;
        $post_url = get_permalink( $post_id );
        $post_title = urlencode(get_the_title( $post_id ));

        echo $before_widget;
        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box">';

        // Check if title is set
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        echo 'Post ID: ' . $post_id . '<br>';
        echo 'Post URL: ' . $post_url . '<br>';
        echo 'Post title: ' . $post_title . '<br>';
        // Check if text is set
        if( $twitter_account ) {
            echo '<a class="wp_widget_plugin_text" href="https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $post_title . '&via=' . $twitter_account . '">Share on Twitter</a>';
        }
        echo '</div>';
        echo $after_widget;
    }
}

// register widget
add_action('widgets_init', function() {register_widget("wp_clean_share_widget_plugin");});

?>