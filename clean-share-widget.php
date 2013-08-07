<?php
/*
Plugin Name: Clean Social Share Widget
Plugin URI: http://github.com/joshbroton/clean-share-widget
Description: A fast and JavaScript-free social share widget.
Version: 0.1
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
                $icon_color = esc_attr($instance['icon_color']);
                $use_twitter = esc_attr($instance['use_twitter']);
                $use_facebook = esc_attr($instance['use_facebook']);
                $use_google_plus = esc_attr($instance['use_google_plus']);
                $use_pinterest = esc_attr($instance['use_pinterest']);

                // remove first character if it's an '@'
                if ( $twitter_account[0] == '@' ) {
                    $twitter_account = substr( $twitter_account, 1 ) ;
                }
        } else {
            $title = '';
            $twitter_account = '';
            $icon_color = "light";
            $use_twitter = true;
            $use_facebook = true;
            $use_google_plus = true;
            $use_pinterest = true;
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
                <li>
                    Light or dark icons?<br />
                    <input id="<?php echo $this->get_field_id('light_icons'); ?>" name="<?php echo $this->get_field_name('icon_type'); ?>" type="radio" value="light" <?php if ( $icon_color == 'light' ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('light_icons'); ?>">Light Icons</label>
                    <input id="<?php echo $this->get_field_id('dark_icons'); ?>" name="<?php echo $this->get_field_name('icon_type'); ?>" type="radio" value="dark" <?php if ( $icon_color == 'dark' ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('dark_icons'); ?>">Dark Icons</label>
                </li>
                <li>
                    Choose Social Networks:<br />
                    <input id="<?php echo $this->get_field_id('use_twitter'); ?>" name="<?php echo $this->get_field_name('use_twitter'); ?>" type="checkbox" <?php if ( $use_twitter ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_twitter'); ?>">Twitter</label><br />
                    <input id="<?php echo $this->get_field_id('use_facebook'); ?>" name="<?php echo $this->get_field_name('use_facebook'); ?>" type="checkbox" <?php if ( $use_facebook ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_facebook'); ?>">Facebook</label><br />
                    <input id="<?php echo $this->get_field_id('use_google_plus'); ?>" name="<?php echo $this->get_field_name('use_google_plus'); ?>" type="checkbox" <?php if ( $use_google_plus ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_google_plus'); ?>">Facebook</label><br />
                    <input id="<?php echo $this->get_field_id('use_pinterest'); ?>" name="<?php echo $this->get_field_name('use_pinterest'); ?>" type="checkbox" <?php if ( $use_pinterest ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_pinterest'); ?>">Facebook</label>
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

        $instance['icon_color'] = strip_tags($new_instance['icon_type']);

        // remove first character if it's an '@'
        if ( $instance['twitter_account'][0] == '@' ) {
            $instance['twitter_account'] = substr( $instance['twitter_account'], 1 ) ;
        }

        return $instance;
	}

    function get_page_title( $name ) {
        return $name;
    }

	// widget display
    public function widget($args, $instance) {
        extract( $args );
        // these are the widget options
        $title = apply_filters( 'widget_title', $instance['title'] );
        $twitter_account = $instance['twitter_account'];
        $icon_color = $instance['icon_color'];

        // Get the page's info
        $post_url = 'http://' . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
        $post_title = wp_title( '', false );

        // Use get_bloginfo if wp_title isn't set
        if ( $post_title == '' ) {
            $post_title = get_bloginfo( 'name' );
        }

        // remove leading spaces
        while ( $post_title[0] == ' ' ) {
            $post_title = substr( $post_title, 1 );
        }

        while ( $post_title[strlen($post_title) - 1] == ' ' ) {
            $post_title = substr( $post_title, 0, -1 );
        }

        // urlencode the title
        $post_title = $post_title;

        echo $before_widget;
        // Display the widget
        echo '<div class="widget-text wp_widget_plugin_box clean-share-widget-wrapper">';

        // Check if title is set
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        // Check if text is set
        echo '<div class="clean-share-links">';

        if ($icon_color == 'light') {
            echo '<a class="wp_widget_plugin_text" target="_blank" href="https://twitter.com/intent/tweet?url=' . $post_url . '&text=%22' . $post_title . '%22&via=' . $twitter_account . '" title="Share to Twitter"><img src="' . plugins_url( 'images/twitter-for-dark.png' , __FILE__ ) . '" alt="Share to Twitter" /></a>';
            echo '<a class="wp_widget_plugin_text" target="_blank" href="https://facebook.com/sharer.php?u=' . $post_url . '" title="Share to Facebook"><img src="' . plugins_url( 'images/facebook-for-dark.png' , __FILE__ ) . '" alt="Share to Facebook" /></a>';
            echo '<a class="wp_widget_plugin_text" target="_blank" href="https://plus.google.com/share?url=' . $post_url . '" title="Share to Google Plus"><img src="' . plugins_url( 'images/google-plus.png' , __FILE__ ) . '" alt="Share to Google Plus" /></a>';
            echo '<a class="wp_widget_plugin_text" target="_blank" href="http://pinterest.com/pin/create/button/?url=' . $post_url . '&description=' . $post_title . '" title="Pin on Pinterest"><img src="' . plugins_url( 'images/pinterest-for-dark.png' , __FILE__ ) . '" alt="Pin on Pinterest" /></a>';
        } elseif ($icon_color == 'dark') {
            echo '<a class="wp_widget_plugin_text" target="_blank" href="https://twitter.com/intent/tweet?url=' . $post_url . '&text=%22' . $post_title . '%22&via=' . $twitter_account . '" title="Share to Twitter"><img src="' . plugins_url( 'images/twitter-for-light.png' , __FILE__ ) . '" alt="Share to Twitter" /></a>';
            echo '<a class="wp_widget_plugin_text" target="_blank" href="https://facebook.com/sharer.php?u=' . $post_url . '" title="Share to Facebook"><img src="' . plugins_url( 'images/facebook-for-light.png' , __FILE__ ) . '" alt="Share to Facebook" /></a>';
            echo '<a class="wp_widget_plugin_text" target="_blank" href="https://plus.google.com/share?url=' . $post_url . '" title="Share to Google Plus"><img src="' . plugins_url( 'images/google-plus.png' , __FILE__ ) . '" alt="Share to Google Plus" /></a>';
            echo '<a class="wp_widget_plugin_text" target="_blank" href="http://pinterest.com/pin/create/button/?url=' . $post_url . '&description=' . $post_title . '" title="Pin on Pinterest"><img src="' . plugins_url( 'images/pinterest-for-light.png' , __FILE__ ) . '" alt="Pin on Pinterest" /></a>';
        }
        echo '</div></div>';
        echo $after_widget;
	}
}

function clean_share_widget_styles() {
    wp_enqueue_style( 'clean-share-widget-style', plugin_dir_url( __FILE__ ) . 'clean-share-widget-style.css', array(), '0.1', 'screen' );
}

add_action( 'wp_enqueue_scripts', 'clean_share_widget_styles' );

// register widget
add_action( 'widgets_init', function() { register_widget("wp_clean_share_widget_plugin"); } );

?>