<?php
// create custom plugin settings menu
var_dump();
add_action('admin_menu', 'Posts_Carousel');
function Posts_Carousel() {
	//create new top-level menu
	add_menu_page('Posts Carousel Plugin Settings', 'Posts Carousel', 'administrator', __FILE__, 'Posts_Carousel_Settings'  );
	//call register settings function
	add_action( 'admin_init', 'Register_Posts_Carousel_plugin_settings' );
}
function Register_Posts_Carousel_plugin_settings() {
	//register our settings
	register_setting( 'Posts_Carousel_settings_group', 'posts_number' );
	register_setting( 'Posts_Carousel_settings_group', 'active' );
	register_setting( 'Posts_Carousel_settings_group', 'show_in' );
    register_setting( 'Posts_Carousel_settings_group', 'Slider_Height' );
    register_setting( 'Posts_Carousel_settings_group', 'next_prev' );
    register_setting( 'Posts_Carousel_settings_group', 'pager' );
    register_setting( 'Posts_Carousel_settings_group', 'hover' );
    register_setting( 'Posts_Carousel_settings_group', 'interval' );
    register_setting( 'Posts_Carousel_settings_group', 'Height_Type' );
}
function Posts_Carousel_Settings() {
?>
<div class="wrap">
<h1>Posts Carousel</h1>
<form id="plugin_options" method="post" action="options.php">
    <?php settings_fields( 'Posts_Carousel_settings_group' );?>
    <?php do_settings_sections( 'Posts_Carousel_settings_group' );?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Active</th>
            <td>
                <input type="radio" name="active" value="yes" <?php if(get_option('active')=="yes"){ echo 'checked="checked"'; }?>>Yes
                <input type="radio" name="active" value="no" <?php if(get_option('active')=="no" || get_option('active')==""){ echo 'checked="checked"'; }?> >No<br>
            </td>
        </tr>
 	    <tr valign="top">
        <th scope="row">Display Location</th>
        <td >
            <div>
            <select class="regular-text code" name="show_in">
               <option <?php if(esc_attr( get_option('show_in') ) ==  "wp_head") echo 'selected';?> name="show_in" value="wp_head"> Header</option>
               <option <?php if(esc_attr( get_option('show_in') ) ==  "wp_footer") echo 'selected';?> name="show_in" value="wp_footer"> Footer</option>
               <option <?php if(esc_attr( get_option('show_in') ) ==  "both") echo 'selected';?> name="show_in" value="both"> Both</option>
            </select>
            </div>
        </td>
        </tr>
        <tr valign="top">
            <th scope="row">Number of Images</th>
            <td><input class="regular-text code" type="text" pattern="[0-9]+" name="posts_number" value="<?php echo esc_attr( get_option('posts_number',5) );?>" min="1" required/></td>
        </tr>
        </tr>
         <tr valign="top">
            <th scope="row">Interval In Seconds</th>
                <td><input class="regular-text code" type="text" pattern="[0-9]+" name="interval" value="<?php echo esc_attr( get_option('interval',3) );?>" min="1" required/></td>
            </th>
        </tr>
        <tr valign="top">
            <th scope="row">Slider Height</th>
                <td>
                <div >
                    <span>
                        <input class="regular-text code" type="text" pattern="[0-9]+" id="Slider_Height" name="Slider_Height" value="<?php echo esc_attr( get_option('Slider_Height',100) );?>" min="1" required/>
                    </span>
                    <span >
                    <select class="small-text" id="Height_Type" name="Height_Type" >
                        <option <?php if(esc_attr( get_option('Height_Type') ) ==  "px") echo 'selected';?> name="Height_Type" value="px"> px</option>
                        <option <?php if(esc_attr( get_option('Height_Type') ) ==  "%") echo 'selected';?> name="Height_Type" value="%"> %</option>
                    </select>
                    </span>
                </div>
                </td>
            </th>
        <tr>
        <tr valign="top">
            <th scope="row">Display Next/Previous Navigation</th>
            <td>
                <input type="radio" name="next_prev" value="null" <?php if(get_option('next_prev')=="null" || get_option('next_prev')==""){ echo 'checked="checked"'; }?>>Yes
                <input type="radio" name="next_prev" value="false" <?php if(get_option('next_prev')=="false"){ echo 'checked="checked"'; }?> >No
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Show Pager</th>
            <td>
               <input type="radio" name="pager" value="true" <?php if(get_option('pager')=="true"){ echo 'checked="checked"'; }?>>Yes
               <input type="radio" name="pager" value="false" <?php if(get_option('pager')=="false" || get_option('pager')==""){ echo 'checked="checked"'; }?>>No
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Stop Motion On Mouse Hover</th>
            <td>
                <input type="radio" name="hover" value="true" <?php if(get_option('hover')=="true" || get_option('hover')==""){ echo 'checked="checked"'; }?>>Yes
                <input type="radio" name="hover" value="false" <?php if(get_option('hover')=="false"){ echo 'checked="checked"'; }?>>No
            </td>
        </tr>
        <tr valign="top">
            <td colspan=2>
                <a target="blank" href="https://www.lnksync.com/posts-carousel-premium-for-wordpress/"><img src="<?php echo  plugins_url()?>/posts-carousel/images/premium.png"></a>
            </td>
        </tr>
    </table>
     <script>

        jQuery('#plugin_options').submit(function(){
        if(jQuery('select[name="Height_Type"]').val() == "%"  && jQuery('input[name="Slider_Height"]').val()>100 )
        {
            alert('% must be less than 100');
            return false;
        }
        if (jQuery('input[name="posts_number"]').val() <= 0) {
            alert('Number of images must be greater than zero');
            return false;
        }
        });
        </script>
        
    <?php submit_button();?>
</form>
</div>
<?php }
?>