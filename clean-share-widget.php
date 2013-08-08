<?php
/*
Plugin Name: Clean Social Share Widget
Plugin URI: http://github.com/joshbroton/clean-share-widget
Description: A fast and JavaScript-free social share widget.
Version: 0.2
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
                $use_email = esc_attr($instance['use_email']);
                $use_linkedin = esc_attr($instance['use_linkedin']);
                $use_digg = esc_attr($instance['use_digg']);
                $use_reddit = esc_attr($instance['use_reddit']);

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
            $use_email = false;
            $use_linkedin = false;
            $use_digg = false;
            $use_reddit = false;
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
                    <input id="<?php echo $this->get_field_id('use_google_plus'); ?>" name="<?php echo $this->get_field_name('use_google_plus'); ?>" type="checkbox" <?php if ( $use_google_plus ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_google_plus'); ?>">Google+</label><br />
                    <input id="<?php echo $this->get_field_id('use_pinterest'); ?>" name="<?php echo $this->get_field_name('use_pinterest'); ?>" type="checkbox" <?php if ( $use_pinterest ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_pinterest'); ?>">Pinterest</label><br />
                    <input id="<?php echo $this->get_field_id('use_email'); ?>" name="<?php echo $this->get_field_name('use_email'); ?>" type="checkbox" <?php if ( $use_email ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_email'); ?>">Email</label><br />
                    <input id="<?php echo $this->get_field_id('use_linkedin'); ?>" name="<?php echo $this->get_field_name('use_linkedin'); ?>" type="checkbox" <?php if ( $use_linkedin ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_linkedin'); ?>">LinkedIn</label><br />
                    <input id="<?php echo $this->get_field_id('use_digg'); ?>" name="<?php echo $this->get_field_name('use_digg'); ?>" type="checkbox" <?php if ( $use_digg ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_digg'); ?>">Digg</label><br />
                    <input id="<?php echo $this->get_field_id('use_reddit'); ?>" name="<?php echo $this->get_field_name('use_reddit'); ?>" type="checkbox" <?php if ( $use_reddit ): echo 'checked="checked"'; endif; ?> /><label for="<?php echo $this->get_field_id('use_reddit'); ?>">Reddit</label>
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

        $instance['use_twitter'] = strip_tags($new_instance['use_twitter']);
        $instance['use_facebook'] = strip_tags($new_instance['use_facebook']);
        $instance['use_google_plus'] = strip_tags($new_instance['use_google_plus']);
        $instance['use_pinterest'] = strip_tags($new_instance['use_pinterest']);
        $instance['use_email'] = strip_tags($new_instance['use_email']);
        $instance['use_linkedin'] = strip_tags($new_instance['use_linkedin']);
        $instance['use_digg'] = strip_tags($new_instance['use_digg']);
        $instance['use_reddit'] = strip_tags($new_instance['use_reddit']);

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

        $use_twitter = $instance['use_twitter'];
        $use_facebook = $instance['use_facebook'];
        $use_google_plus = $instance['use_google_plus'];
        $use_pinterest = $instance['use_pinterest'];
        $use_email = $instance['use_email'];
        $use_linkedin = $instance['use_linkedin'];
        $use_digg = $instance['use_digg'];
        $use_reddit = $instance['use_reddit'];

        // Variable used to build content string
        $widget_content = '';

        // Variable used to store social network count
        $count = 0;

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
        $post_title = urlencode($post_title);

        // Display the widget
        echo $before_widget;
        echo '<div class="widget-text wp_widget_plugin_box clean-share-widget-wrapper">';

        // Check if title is set
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        // Build content string
        if ( $use_twitter ) {
            $widget_content .= '<a class="wp_widget_plugin_text" target="_blank" href="https://twitter.com/intent/tweet?url=' . $post_url . '&text=%22' . $post_title . '%22&via=' . $twitter_account . '" title="Share to Twitter"><img src="';
            if ($icon_color == 'light') {
                $widget_content .= plugins_url( 'images/twitter-for-dark.png' , __FILE__ );
            } else {
                $widget_content .= plugins_url( 'images/twitter-for-light.png' , __FILE__ );
            }
            $widget_content .= '" alt="Share to Twitter" /></a>';
            $count++;
        }

        if ( $use_facebook ) {
            $widget_content .= '<a class="wp_widget_plugin_text" target="_blank" href="https://facebook.com/sharer.php?u=' . $post_url . '" title="Share to Facebook"><img src="';
            if ( $icon_color ==  'light' ) {
                $widget_content .= plugins_url( 'images/facebook-for-dark.png' , __FILE__ );
            } else {
                $widget_content .= plugins_url( 'images/facebook-for-light.png' , __FILE__ );
            }
            $widget_content .= '" alt="Share to Facebook" /></a>';
            $count++;
        }

        if ( $use_google_plus ) {
            $widget_content .= '<a class="wp_widget_plugin_text" target="_blank" href="https://plus.google.com/share?url=' . $post_url . '" title="Share to Google Plus"><img src="' . plugins_url( 'images/google-plus.png' , __FILE__ ) . '" alt="Share to Google Plus" /></a>';
            $count++;
        }

        if ( $use_pinterest ) {
            $widget_content .= '<a class="wp_widget_plugin_text" target="_blank" href="https://pinterest.com/pin/create/button/?url=' . $post_url . '&description=' . $post_title . '" title="Pin on Pinterest"><img src="';
            if ( $icon_color == 'light' ) {
                $widget_content .= plugins_url( 'images/pinterest-for-dark.png' , __FILE__ );
            } else {
                $widget_content .= plugins_url( 'images/pinterest-for-light.png' , __FILE__ );
            }
            $widget_content .= '" alt="Pin on Pinterest" /></a>';
            $count++;
        }

        if ( $use_email ) {
            $widget_content .= '<a class="wp_widget_plugin_text" target="_blank" href="mailto:?subject=I%20am%20Sharing%20A%20Webpage%20With%20You%20From%20joshbroton.com&body=%3Ca%20href%3D%22' . $post_url . '%22%3E' . $post_title . '%3C%2Fa%3E" title="Send via email"><img src="';
            if ( $icon_color == 'light' ) {
                $widget_content .= plugins_url( 'images/email-for-dark.png' , __FILE__ );
            } else {
                $widget_content .= plugins_url( 'images/email-for-light.png' , __FILE__ );
            }
            $widget_content .= '" alt="Send via Email" /></a>';
            $count++;
        }

        if ( $use_linkedin ) {
            $widget_content .= '<a class="wp_widget_plugin_text" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $post_url . '" title="Share on LinkedIn"><img src="' . plugins_url( 'images/linkedin.png' , __FILE__ ) . '" alt="Share on LinkedIn" /></a>';
            $count++;
        }

        if ( $use_digg ) {
            $widget_content .= '<a class="wp_widget_plugin_text" target="_blank" href="https://digg.com/submit?url=' . $post_url . '" title="Digg This"><img src="';
            if ( $icon_color == 'light' ) {
                $widget_content .= plugins_url( 'images/digg-for-dark.png' , __FILE__ );
            } else {
                $widget_content .= plugins_url( 'images/digg-for-light.png' , __FILE__ );
            }
            $widget_content .= '" alt="Digg This" /></a>';
            $count++;
        }

        if ( $use_reddit ) {
            $widget_content .= '<a class="wp_widget_plugin_text" target="_blank" href="http://reddit.com/submit?url=' . $post_url . '&title=' . $post_title . '" title="Share on Reddit"><img src="' . plugins_url( 'images/reddit.png' , __FILE__ ) . '" alt="Share on Reddit" /></a>';
            $count++;
        }

        // Output content
        echo '<div class="clean-share-links count_' . $count . '">';
        echo $widget_content . '</div></div>';
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