<?php
/**
 * Cutstom Theme Panel
 */
$menuname = $shortname . "_settings"; // Required
$zm_categories_obj = get_categories(array('hide_empty' => false));
$zm_categories = array();
foreach ($zm_categories_obj as $zm_cat) {
    $zm_categories[$zm_cat->cat_ID] = $zm_cat->name;
}

$options = array(
    array("name" => "Theo dõi trên mạng xã hội",
        "type" => "title",
        "desc" => "Tùy chỉnh Follow us.",
    ),
    array("type" => "open"),
    array("name" => "Facebook",
        "desc" => "Nhập URL page của bạn trên facebook.",
        "id" => $shortname . "_fbURL",
        "std" => "",
        "type" => "text"),
    array("name" => "Twitter",
        "desc" => "Nhập URL page của bạn trên Twitter.",
        "id" => $shortname . "_twitterURL",
        "std" => "",
        "type" => "text"),
    array("name" => "Google",
        "desc" => "Nhập URL page của bạn trên google.",
        "id" => $shortname . "_googleURL",
        "std" => "",
        "type" => "text"),
    array("type" => "close"),
    
    array("name" => "Tin tức",
        "type" => "title",
        "desc" => "Tùy chọn tin tức.",
    ),
    array("type" => "open"),
    array("name" => "Tin đáng chú ý",
        "desc" => "Nhập ID tin đáng chúy ý. Tin sẽ hiển thị bên cạnh slide tin nổi bật ở trang chủ.",
        "id" => $shortname . "_postHotID",
        "std" => '',
        "type" => "text"),
    array("name" => "Bài viết tuyển chọn từ",
        "desc" => "Bài viết tuyển chọn được lấy từ post, page hay category",
        "id" => $shortname . "_selectivePostType",
        "std" => '',
        "type" => "select",
        "options" => array(
                'post' => "Post or page",
                'cat' => "Category"
            )
        ),
    array("name" => "Bài viết tuyển chọn",
        "desc" => "Mỗi ID cách nhau bởi dấu phẩy. Ví dụ: 1,2,32,45 <br />Sẽ được hiển thị ngẫu nhiên 1 tin tại box \"Bài viết tuyển chọn\".",
        "id" => $shortname . "_selectivePost",
        "std" => '',
        "type" => "text"),
    array("type" => "close"),
    
    array("name" => "Pages",
        "type" => "title",
        "desc" => "Tùy chọn trang.",
    ),
    array("type" => "open"),
    array("name" => "Trang đăng ký",
        "desc" => "Nhập ID trang đăng ký tài khoản.",
        "id" => $shortname . "_pageRegisterID",
        "std" => '',
        "type" => "text"),
    array("name" => "Trang đăng nhập",
        "desc" => "Nhập ID trang đăng nhập.",
        "id" => $shortname . "_pageLoginID",
        "std" => '',
        "type" => "text"),
    array("name" => "Trang lấy lại mật khẩu",
        "desc" => "Nhập ID trang lấy lại mật khẩu.",
        "id" => $shortname . "_pageForgotPwdID",
        "std" => '',
        "type" => "text"),
    array("name" => "Trang Q&A",
        "desc" => "Nhập ID trang danh sách Q&A.",
        "id" => $shortname . "_pageQAID",
        "std" => '',
        "type" => "text"),
    array("name" => "Trang đăng câu hỏi",
        "desc" => "Nhập ID trang đăng câu hỏi - Q&A.",
        "id" => $shortname . "_pagePostQAID",
        "std" => '',
        "type" => "text"),
    array("type" => "close"),
    
    array("name" => "Danh mục",
        "type" => "title",
        "desc" => "Tùy chọn danh mục.",
    ),
    array("type" => "open"),
    array("name" => "Q&A Category",
        "desc" => "Select the category to be Q&A.",
        "id" => $shortname . "_catQAID",
        "std" => "",
        "type" => "select",
        "options" => $zm_categories),
    array("type" => "close"),
    
    array("name" => "Tùy chọn khác",
        "type" => "title",
        "desc" => "Tìm chỉnh website.",
    ),
    array("type" => "open"),
    array("name" => "Email liên hệ",
        "desc" => "Địa chỉ email liên hệ. Ví dụ: chiemtinh@lovedia.vn",
        "id" => $shortname . "_emailContact",
        "std" => '',
        "type" => "text"),
    array("name" => "Link Fanpage trên facebook",
        "desc" => "URL page facebook. Ví dụ: https://www.facebook.com/24khoteam",
        "id" => $shortname . "_fbPage",
        "std" => '',
        "type" => "text"),
    array("name" => "Google Analytics",
        "desc" => "Google Analytics. Ví dụ: UA-23200894-1",
        "id" => $shortname . "_gaID",
        "std" => "UA-23200894-1",
        "type" => "text"),
    array("type" => "close"),
);

$fields = array(
    "keywords_meta", "description_meta", "favicon", "sitelogo", "logo_footer", 
);

/**
 * Add actions
 */
add_action('admin_init', 'theme_settings_init');
add_action('admin_menu', 'add_settings_page');

/**
 * Register settings
 */
function theme_settings_init(){
    register_setting( "theme_settings", "theme_settings");
}

/**
 * Add settings page menu
 */
function add_settings_page(){
    global $themename, $shortname, $menuname, $options, $fields;
    
    add_menu_page(__($themename . ' Settings'), // Page title
            __($themename.' Settings'), // Menu title
            'manage_options', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            $menuname, // menu id - Unique id of the menu
            'theme_settings_page',// render output function
            '', // URL icon, if empty default icon
            null // Menu position - integer, if null default last of menu list
        );
    
    //Add submenu page
    add_submenu_page($menuname, //Menu ID – Defines the unique id of the menu that we want to link our submenu to. 
                                    //To link our submenu to a custom post type page we must specify - 
                                    //edit.php?post_type=my_post_type
            __('Theme Options'), // Page title
            __('Theme Options'), // Menu title
            'edit_themes', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            'theme_options', // Submenu ID – Unique id of the submenu.
            'theme_options_page' // render output function
        );
    add_submenu_page($menuname, //Menu ID – Defines the unique id of the menu that we want to link our submenu to. 
                                    //To link our submenu to a custom post type page we must specify - 
                                    //edit.php?post_type=my_post_type
            __('Home Options'), // Page title
            __('Home Options'), // Menu title
            'edit_themes', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            'home_options', // Submenu ID – Unique id of the submenu.
            'home_options_page' // render output function
        );
    
    //add_theme_page("$themename Options", "$themename Options", 'edit_themes', 'theme_options', 'theme_options_page');

    /*-------------------------------------------------------------------------*/
    # Theme general settings
    /*-------------------------------------------------------------------------*/
    if ($_GET['page'] == $shortname . '_settings') {
        if (isset($_REQUEST['action']) and 'save' == $_REQUEST['action']) {
            foreach ($fields as $field) {
                update_option($field, $_REQUEST[$field]);
            }
            foreach ($fields as $field) {
                if (isset($_REQUEST[$field])) {
                    update_option($field, $_REQUEST[$field]);
                } else {
                    delete_option($field);
                }
            }
            header("Location: {$_SERVER['REQUEST_URI']}&saved=true");
            die();
        } 
    }
    /*-------------------------------------------------------------------------*/
    # Theme options processing
    /*-------------------------------------------------------------------------*/
    if ($_GET['page'] == 'theme_options') {
        if (isset($_REQUEST['action']) and 'save' == $_REQUEST['action']) {
            foreach ($options as $value) {
                update_option($value['id'], $_REQUEST[$value['id']]);
            }
            foreach ($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    update_option($value['id'], $_REQUEST[$value['id']]);
                } else {
                    delete_option($value['id']);
                }
            }
            header("Location: {$_SERVER['REQUEST_URI']}&saved=true");
            die();
        } else if (isset($_REQUEST['action']) and 'reset' == $_REQUEST['action']) {
            foreach ($options as $value) {
                delete_option($value['id']);
                update_option($value['id'], $value['std']);
            }
            header("Location: {$_SERVER['REQUEST_URI']}&reset=true");
            die();
        }
    }
    /*-------------------------------------------------------------------------*/
    # Home options
    /*-------------------------------------------------------------------------*/
    if ($_GET['page'] == 'home_options') {
        if (isset($_REQUEST['action']) and 'save' == $_REQUEST['action']) {
            /*foreach ($home_fields as $field) {
                if (isset($_REQUEST[$field])) {
                    if(is_array($_REQUEST[$field])){
                        update_option($field, json_encode($_REQUEST[$field]));
                    }else{
                        update_option($field, $_REQUEST[$field]);
                    }
                } else {
                    delete_option($field);
                }
            }*/
            $saveContent = stripslashes(getRequest('saveContent'));
            $saveContent = json_decode($saveContent);
            $box1 = $saveContent->box1;
            //$box2 = $saveContent->box2;
            $box3 = $saveContent->box3;
            $box4 = $saveContent->box4;
            $box5 = $saveContent->box5;
            $box6 = $saveContent->box6;
            $cat_box1 = array();
            //$cat_box2 = array();
            $cat_box3 = array();
            $cat_box4 = array();
            $cat_box5 = array();
            $cat_box6 = array();
            foreach ($box1 as $v) {
                if(!in_array($v->term_id, $cat_box1))
                    array_push($cat_box1, $v->term_id);
            }
            /*foreach ($box2 as $v) {
                if(!in_array($v->term_id, $cat_box2))
                    array_push($cat_box2, $v->term_id);
            }*/
            foreach ($box3 as $v) {
                if(!in_array($v->term_id, $cat_box3))
                    array_push($cat_box3, $v->term_id);
            }
            foreach ($box4 as $v) {
                if(!in_array($v->term_id, $cat_box4))
                    array_push($cat_box4, $v->term_id);
            }
            foreach ($box5 as $v) {
                if(!in_array($v->term_id, $cat_box5))
                    array_push($cat_box5, $v->term_id);
            }
            foreach ($box6 as $v) {
                if(!in_array($v->term_id, $cat_box6))
                    array_push($cat_box6, $v->term_id);
            }
            update_option('cat_box1', json_encode($cat_box1));
            //update_option('cat_box2', json_encode($cat_box2));
            update_option('cat_box3', json_encode($cat_box3));
            update_option('cat_box4', json_encode($cat_box4));
            update_option('cat_box5', json_encode($cat_box5));
            update_option('cat_box6', json_encode($cat_box6));
            
            header("Location: {$_SERVER['REQUEST_URI']}&saved=true");
            die();
        } 
    }
    
    /*-------------------------------------------------------------------------*/
    # Retitle for first sub-menu
    /*-------------------------------------------------------------------------*/
    global $submenu;
    if(isset($submenu[$shortname . '_settings'][0][0]) and $submenu[$shortname . '_settings'][0][0] == $themename . ' Settings'){
        $submenu[$shortname . '_settings'][0][0] = 'General Settings';
    }
}

/**
 * Remove an Existing Sub-Menu
 */
function remove_settings_submenu($menu_name, $submenu_name) {
    global $submenu;
    $menu = $submenu[$menu_name];
    if (!is_array($menu)) return;
    foreach ($menu as $submenu_key => $submenu_object) {
        if (in_array($submenu_name, $submenu_object)) {// remove menu object
            unset($submenu[$menu_name][$submenu_key]);
            return;
        }
    }          
}

/**
 * Theme general settings ouput
 * 
 * @global string $themename
 */
function theme_settings_page() {
    global $themename;
?>
    <div class="wrap">
        <div class="opwrap" style="margin-top: 10px;" >
            <div class="icon32" id="icon-options-general"></div>
            <h2 class="wraphead"><?php echo $themename; ?> theme general settings</h2>
    <?php
    if (isset($_REQUEST['saved']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings saved.</strong></p></div>';
    ?>
            <form method="post">
                <h3>Site Options</h3>
                <table class="form-table">
                    <tr>
                        <th><label for="keywords_meta">Keywords meta</label></th>
                        <td>
                            <input type="text" name="keywords_meta" id="keywords_meta" value="<?php echo stripslashes(get_settings('keywords_meta'));?>" class="regular-text" />
                            <br />
                            <span class="description">Enter the meta keywords for all pages. These are used by search engines to index your pages with more relevance.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="description_meta">Description meta</label></th>
                        <td>
                            <input type="text" name="description_meta" id="description_meta" value="<?php echo stripslashes(get_settings('description_meta'));?>" class="regular-text" />
                            <br />
                            <span class="description">Enter the meta description for all pages. This is used by search engines to index your pages more relevantly.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="favicon">Favicon</label></th>
                        <td>
                            <input type="text" name="favicon" id="favicon" value="<?php echo stripslashes(get_settings('favicon'));?>" class="regular-text" />
                            <input type="button" id="upload_favicon_button" class="button button-upload" value="Upload" />
                            <br />
                            <span class="description">An icon associated with a particular website, and typically displayed in the address bar of a browser viewing the site.</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="sitelogo">Logo</label></th>
                        <td>
                            <input type="text" name="sitelogo" id="sitelogo" value="<?php echo stripslashes(get_settings('sitelogo'));?>" class="regular-text" />
                            <input type="button" id="upload_sitelogo_button" class="button button-upload" value="Upload" /><br />
                            <span class="description">Size: 345x80</span>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="logo_footer">Logo Footer</label></th>
                        <td>
                            <input type="text" name="logo_footer" id="logo_footer" value="<?php echo stripslashes(get_settings('logo_footer'));?>" class="regular-text" />
                            <input type="button" id="upload_logo_footer_button" class="button button-upload" value="Upload" /><br />
                            <span class="description">Size: 1525x60</span>
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

/**
 * Home options
 * 
 * @global string $themename
 */
function home_options_page() {
    global $themename, $shortname;
    
    include 'categories.php';
}

/**
 * Theme options ouput
 * 
 * @global string $themename
 * @global array $options
 */
function theme_options_page(){
    global $themename, $options;
?>
    <div class="wrap">
        <div class="opwrap">
            <h2 class="wraphead" style="margin:10px 0px; padding:15px 10px; font-family:arial black; font-style:normal; background:#B3D5EF;"><b><?php echo $themename; ?> theme options</b></h2>
    <?php
    if (isset($_REQUEST['saved']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings saved.</strong></p></div>';
    if (isset($_REQUEST['reset']))
        echo '<div id="message" class="updated fade"><p><strong>' . $themename . ' settings reset.</strong></p></div>';
    ?>
            <form method="post">
    <?php
    foreach ($options as $value) {
        switch ($value['type']) {
            case "image":
                ?>
                            <tr>
                                <td width="30%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                <td width="70%"><img src="<?php echo $value['id']; ?>" /></td>
                            </tr>
                            <tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
            case "open":
                ?>
                            <table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">
                <?php
                break;
            case "close":
                ?>
                            </table><br />
                <?php
                break;
            case "break":
                ?>
                            <tr><td colspan="2" style="border-top:1px solid #C2DCEF;">&nbsp;</td></tr>
                <?php
                break;
            case "title":
                ?>
                            <table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>
                                    <td colspan="2"><h3 style="font-size:18px;font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
                                </tr>
                <?php
                break;
            case 'text':
                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if (get_settings($value['id']) != "") {
                    echo get_settings($value['id']);
                } else {
                    echo $value['std'];
                } ?>" /></td>
                                </tr>
                                <tr>
                                    <td><small><?php echo $value['desc']; ?></small></td>
                                </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
            case 'textarea':
                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if (get_settings($value['id']) != "") {
                    echo stripslashes(get_settings($value['id']));
                } else {
                    echo $value['std'];
                } ?></textarea></td>
                                </tr>
                                <tr>
                                    <td><small><?php echo $value['desc']; ?></small></td>
                                </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
            case 'select':
                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                                        <?php foreach ($value['options'] as $key => $option) { ?>
                                            <option<?php if (get_settings($value['id']) == $key) {
                        echo ' selected="selected"';
                    } elseif ($key == $value['std']) {
                        echo ' selected="selected"';
                        } ?> value="<?php echo $key;?>"><?php echo $option; ?></option><?php } ?></select></td>
                                </tr>
                                <tr>
                                    <td><small><?php echo $value['desc']; ?></small></td>
                                </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
            case "checkbox":
                ?>
                                <tr>
                                    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                    <td width="80%"><? if (get_settings($value['id'])) {
                    $checked = "checked=\"checked\"";
                } else {
                    $checked = "";
                } ?>
                                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
                                    </td>
                                </tr>
                                <tr>
                                    <td><small><?php echo $value['desc']; ?></small></td>
                                </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
                <?php
                break;
        }
    }
    ?>
                <p class="submit">
                    <input name="save" type="submit" value="Save changes" class="button button-large button-primary" />
                    <input type="hidden" name="action" value="save" />
                </p>
            </form>
            <form method="post">
                <input name="reset" type="submit" value="Reset" class="button button-large" />
                <input type="hidden" name="action" value="reset" />
            </form>
        </div>
    </div>
<?php
}