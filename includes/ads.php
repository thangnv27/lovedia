<?php

$ads_fields = array(
    "ad_home_category", "ad_home_category2", "ad_above_footer", "ad_archive"
);

add_action('admin_menu', 'add_ads_settings_page');

function add_ads_settings_page(){
    global $menuname, $ads_fields;
    
    add_submenu_page($menuname, //Menu ID – Defines the unique id of the menu that we want to link our submenu to. 
                                    //To link our submenu to a custom post type page we must specify - 
                                    //edit.php?post_type=my_post_type
            __('Ads Options'), // Page title
            __('Ads Options'), // Menu title
            'edit_themes', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            'ads_options', // Submenu ID – Unique id of the submenu.
            'theme_ads_settings_page' // render output function
        );
    
    if ($_GET['page'] == 'ads_options') {
        if (isset($_REQUEST['action']) and 'save' == $_REQUEST['action']) {
            foreach ($ads_fields as $field) {
                if (isset($_REQUEST[$field])) {
                    if(is_array($_REQUEST[$field])){
                        update_option($field, json_encode($_REQUEST[$field]));
                    }else{
                        update_option($field, $_REQUEST[$field]);
                    }
                } else {
                    delete_option($field);
                }
            }
            header("Location: {$_SERVER['REQUEST_URI']}&saved=true");
            die();
        } 
    }
}

function theme_ads_settings_page() {
    global $themename;
?>
    <div class="wrap">
        <div class="opwrap" style="margin-top: 10px;" >
            <div class="icon32" id="icon-options-general"></div>
            <h2 class="wraphead"><?php echo $themename; ?> ads settings</h2>
    <?php
    if (isset($_REQUEST['saved']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings saved.</strong></p></div>';
    ?>
            <form method="post">
                <div style="margin-top: 20px;" class="wp-media-buttons">
                    <a class="button insert-media add_media" id="upload_media_button">
                        <span class="wp-media-buttons-icon"></span>
                        Add Media
                    </a>
                </div>
                <table class="form-table">
                   <tr>
                        <th><label for="ad_home_category">Ad home category</label></th>
                        <td>
                            <textarea name="ad_home_category" id="ad_home_category" cols="80" rows="5"><?php echo stripslashes(get_settings('ad_home_category'));?></textarea>
                            <br />
                            <input type="button" id="upload_ad_home_category_button" class="button button-upload" value="Upload" />
                            <br />
                            <textarea name="ad_home_category2" id="ad_home_category2" cols="80" rows="5"><?php echo stripslashes(get_settings('ad_home_category2'));?></textarea>
                            <br />
                            <input type="button" id="upload_ad_home_category2_button" class="button button-upload" value="Upload" />
                            <br />
                            <span class="description">Ad display after block first in home page.</span>
                        </td>
                    </tr>
                   <tr>
                        <th><label for="ad_above_footer">Ad above footer</label></th>
                        <td>
                            <textarea name="ad_above_footer" id="ad_above_footer" cols="80" rows="5"><?php echo stripslashes(get_settings('ad_above_footer'));?></textarea>
                            <br />
                            <input type="button" id="upload_ad_above_footer_button" class="button button-upload" value="Upload" />
                            <br />
                            <span class="description">Ad display above footer.</span>
                        </td>
                    </tr>
                   <tr>
                        <th><label for="ad_archive">Ad Archive</label></th>
                        <td>
                            <textarea name="ad_archive" id="ad_archive" cols="80" rows="5"><?php echo stripslashes(get_settings('ad_archive'));?></textarea>
                            <br />
                            <input type="button" id="upload_ad_archive_button" class="button button-upload" value="Upload" />
                            <br />
                            <span class="description">Ad display in archive page.</span>
                        </td>
                    </tr>
                </table>
                <div class="submit">
                    <input name="save" type="submit" value="Save changes" class="button button-large button-primary" />
                    <input type="hidden" name="action" value="save" />
                </div>
            </form>
        </div>
    </div>
<?php
}