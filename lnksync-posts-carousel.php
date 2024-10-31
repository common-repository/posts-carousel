<?php
/**
 * Plugin Name:       Posts Carousel
 * Plugin URI:        https://www.lnksync.com/posts-carousel-premium-for-wordpress/
 * Description:       Posts Carousel This plugin show carousel of images in your websites from your latest featured images in your posts.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.0
 * Author:            LnkSync
 * Author URI:        https://lnksync.com
 * Text Domain:       lnksync-posts-carousel
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
if (!file_exists("../wp-content/plugins/lnksync-posts-carousel") ) {       
    defined('ABSPATH') or die;
    require( dirname(__FILE__).'/settings.php');
    add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'lspc_add_plugin_page_settings_link');
    if(get_option('active') == 'yes')
    {
        $show_in = get_option('show_in');
        
        if(isset($show_in) && $show_in != 'both')
        {                
            add_action( get_option('show_in'), 'lspc_get_featured_images' );        
            add_action( 'wp_footer', 'lspc_my_footer_scripts' );
        }
        else if($show_in == 'both')
        {
            add_action( 'wp_head', 'lspc_get_featured_images' );
            add_action( 'wp_footer', 'lspc_get_featured_images' );
            add_action( 'wp_footer', 'lspc_my_footer_scripts' );
        }
    }
    function lspc_add_plugin_page_settings_link( $links ) 
    {
        $links[] = '<a href="'.admin_url().'options-general.php?page=posts-carousel/settings.php">' . __('Settings') . '</a>';
        return $links;
    }
    function lspc_get_featured_images()
    {
            
        $posts_number = get_option('posts_number');
        $recent_posts = wp_get_recent_posts(array(
            'numberposts' => get_option('posts_number'), // Number of recent posts thumbnails to display
            'post_status' => 'publish', // Show only the published posts
        ));
        $height = esc_attr(get_option('Slider_Height',100));
        echo get_option('wporg');
        echo '<div id="film_roll">';
        foreach($recent_posts as $post)
        {
            lspc_draw_images($post,$height);   
        }
        echo '</div>';
        if(get_option('show_in') == 'both')
        {
            echo '<div id="film_roll_2">';
            foreach($recent_posts as $post)
            {
                lspc_draw_images($post,$height);
            }
            echo '</div>';
        }
    }
    function lspc_draw_images($post,$height)
    {
        echo '<li>';
        echo '<a href="'.get_permalink($post['ID']).'" title ="'.$post['post_title'].'">';
        if(get_option('Height_Type') == "px")
        {
            if($height<=get_option('thumbnail_size_w'))
            {
                echo get_the_post_thumbnail($post['ID'],'thumbnail');
            }
            else if($height > get_option('thumbnail_size_w') && $height <= get_option('medium_size_w'))
            {
                echo get_the_post_thumbnail($post['ID'], 'medium');
            }
            else if($height > get_option('medium_size_w') && $height <= get_option('medium_large_size_w'))
            {
                echo get_the_post_thumbnail($post['ID'], 'medium_large');
            }
            else if($height > get_option('medium_large_size_w') && $height <= get_option('large_size_h'))
            {
                echo get_the_post_thumbnail($post['ID'], 'large');
            }
            else
            {
                echo get_the_post_thumbnail($post['ID'], 'full');
            }
        }
        else
        {
            if($height<=25)
            {
                echo get_the_post_thumbnail($post['ID'],'thumbnail');
            }
            else if($height > 25 && $height <= 50)
            {
                echo get_the_post_thumbnail($post['ID'], 'medium');
            }
            else if($height > 50 && $height <= 75)
            {
                echo get_the_post_thumbnail($post['ID'], 'medium_large');
            }
            else if($height > 75 && $height <= 100)
            {
                echo get_the_post_thumbnail($post['ID'], 'large');
            }
            else
            {
                echo get_the_post_thumbnail($post['ID'], 'full');
            }
        }
        echo '<p class="slider-caption-class"><?php echo $post["post_title"] ?></p>';
        echo'</a> </li>';
    }

    function lspc_my_footer_scripts(){   

        if (  ! wp_script_is( 'jquery', 'enqueued' )) 
        {               
            wp_enqueue_script('jquery');

        }
        wp_register_script('film_roll',plugin_dir_url(__FILE__).'js/jquery.film_roll.min.js');
        wp_enqueue_script('film_roll');
        wp_register_script('intilize_filmroll',plugin_dir_url(__FILE__).'js/intilize_filmroll.js');
        wp_enqueue_script('intilize_filmroll');
        

        ?>
        <script>
            var Height_type = "<?php echo get_option('Height_Type');?>";
            var lsCareouselHeight = lsCareouselHeight = <?php echo get_option('Slider_Height');?>;
            if(Height_type == "%")
            {
                lsCareouselHeight = "<?php echo get_option('Slider_Height')."%";?>";
            }
            var lsCareouselPager = (<?php echo get_option('pager');?>==true)?true:false;
            var lsCareouselInterval = 1000*<?php echo get_option('interval');?>;
            var lsCareouselHover = (<?php echo get_option('hover');?>==true)?true:false;
            var lsCareouselPrev = (<?php echo get_option('next_prev');?>==null)?null:false;
            var lsCareouselNext = (<?php echo get_option('next_prev');?>==null)?null:false;
            var show_in = "wp_footer";
            if("<?php echo get_option('show_in');?>" == "wp_head")
            {
                show_in = "wp_head";
            }
            else if("<?php echo get_option('show_in');?>" =="both")
            {
                show_in = "both";
            }
            else
            {
                show_in = "wp_footer";
            }
        </script>
        <?php
    }
}