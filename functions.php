<?php

ob_start();
ob_start("ob_gzhandler");
if (!isset($_SESSION)) session_start();

/* ----------------------------------------------------------------------------------- */
# Set default timezone
/* ----------------------------------------------------------------------------------- */
date_default_timezone_set('Asia/Ho_Chi_Minh');
/* ----------------------------------------------------------------------------------- */
# Set memory limit
/* ----------------------------------------------------------------------------------- */
ini_set("memory_limit","128M");

//if (extension_loaded('gd') && function_exists('gd_info')) {
//    echo "PHP GD library is installed on your web server";
//} else {
//    echo "PHP GD library is NOT installed on your web server";
//}

$themename = "Lovedia";
$shortname = "lovedia";

include 'includes/HttpFoundation/Request.php';
include 'includes/HttpFoundation/Response.php';
include 'includes/HttpFoundation/Session.php';
include 'includes/custom.php';
include 'includes/theme_functions.php';
include 'includes/common-scripts.php';
include 'includes/categories_footer.php';
if(is_admin()){
    include 'includes/meta-box.php';
    include 'includes/theme_settings.php';
    include 'includes/ads.php';
    include 'includes/custom-user.php';
    include 'includes/postMeta.php';
    include 'includes/sologan.php';
}else{
    include 'includes/social-post-link.php';
    include 'ajax.php';
    
    if(!isset($_SESSION['UPLOAD_DIR'])){
        $_SESSION['UPLOAD_DIR'] = wp_upload_dir();
    }
}

add_action('init', 'user_check_login_status');

function user_check_login_status(){
    global $current_user;
    get_currentuserinfo();
    if (is_user_logged_in()) {
        $_SESSION['current_user_login'] = $current_user;
        
        $role = $current_user->roles[0];
        if(in_array($role, array('author', 'contributor',))){
            add_action( 'admin_menu', 'custom_remove_menu_pages' );
            add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
        }
    }else{
        if(isset($_SESSION['current_user_login'])){
            unset($_SESSION['current_user_login']);
        }
    }
}

function custom_remove_menu_pages() {
    remove_menu_page('index.php');
    remove_menu_page('edit.php');
    remove_menu_page('edit.php?post_type=sologan');
    remove_menu_page('upload.php');
    remove_menu_page('tools.php');
    remove_menu_page('edit-comments.php');
}
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    //$wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    //$wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    //$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}

add_action('init', 'redirect_after_logout');

function redirect_after_logout() {
    if (preg_match('#(wp-login.php)?(loggedout=true)#', $_SERVER['REQUEST_URI']))
        wp_redirect(get_option('siteurl'));
}

add_action('wp_login_failed', 't_redirect_to_login_page');

function t_redirect_to_login_page() {
    global $shortname, $pagenow;
    
    $login_url = get_page_link(get_option($shortname . '_pageLoginID'));
    
    if( 'wp-login.php' == $pagenow ) {
        wp_redirect($login_url);
        exit;
    }
}

// Redefine user notification function
if (!function_exists('custom_wp_new_user_notification')) {
    function custom_wp_new_user_notification($user_id, $plaintext_pass = '') {
        global $shortname;

        $user = new WP_User($user_id);

        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);

        $message = sprintf(__('New user registration on %s:'), get_option('blogname')) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

        @wp_mail(
                        get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message
        );

        if (empty($plaintext_pass))
            return;

        $login_url = get_page_link(get_option($shortname . '_pageLoginID'));
        
        $message = sprintf(__('Hi %s,'), $user->display_name) . "\r\n\r\n";
        $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
        $message .= ($login_url == "") ? wp_login_url() : $login_url . "\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n";
        $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n\r\n";

        wp_mail(
                $user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message
        );
    }
}

function get_month_icon(){
    $day = date("D");
    $d = date("d");
    $m = date("m");
    $name = "aquarius";
    $title = "Aquarius";
    switch ($day) {
        case "Mon": $day = "Thứ hai"; break;
        case "Tue": $day = "Thứ ba"; break;
        case "Wed": $day = "Thứ tư"; break;
        case "Thu": $day = "Thứ năm"; break;
        case "Fri": $day = "Thứ sáu"; break;
        case "Sat": $day = "Thứ bảy"; break;
        case "Sun": $day = "Chủ nhật"; break;
        default: break;
    }
    if( ($m == 1 and $d > 19) or ($m == 2 and $d < 20) ){
        $name = "aquarius";
        $title = "Bảo Bình";
    } elseif (($m == 2 and $d > 19) or ($m == 3 and $d < 21)) {
        $name = "pisces";
        $title = "Song Ngư";
    } elseif (($m == 3 and $d > 20) or ($m == 4 and $d < 21)) {
        $name = "aries";
        $title = "Bạch Dương";
    } elseif (($m == 4 and $d > 20) or ($m == 5 and $d < 21)) {
        $name = "taurus";
        $title = "Kim Ngưu";
    } elseif (($m == 5 and $d > 20) or ($m == 6 and $d < 21)) {
        $name = "gemini";
        $title = "Song Tử";
    } elseif (($m == 6 and $d > 20) or ($m == 7 and $d < 23)) {
        $name = "cancer";
        $title = "Cự Giải";
    } elseif (($m == 7 and $d > 22) or ($m == 8 and $d < 23)) {
        $name = "leo";
        $title = "Sư Tử";
    } elseif (($m == 8 and $d > 22) or ($m == 9 and $d < 23)) {
        $name = "virgo";
        $title = "Xử Nữ";
    } elseif (($m == 9 and $d > 22) or ($m == 10 and $d < 23)) {
        $name = "libra";
        $title = "Thiên Bình";
    } elseif (($m == 10 and $d > 22) or ($m == 11 and $d < 23)) {
        $name = "scorpio";
        $title = "Bò Cạp";
    } elseif (($m == 11 and $d > 22) or ($m == 12 and $d < 22)) {
        $name = "sagittarius";
        $title = "Nhân Mã";
    } elseif (($m == 12 and $d > 21) or ($m == 1 and $d < 20)) {
        $name = "capricorn";
        $title = "Ma Kết";
    }
    //$title = ucwords($name);
    echo "<img src=\"" . get_bloginfo('stylesheet_directory') . "/images/icons/horo_icon/{$name}.png\" alt=\"$title\" title=\"$title\" />";
    echo "<span>" .$day . date(" - d/m/Y")."</span>";
}

/**
 * Output like count of the post
 * 
 * @global object $wpdb
 * @global object $post
 * @param object $post
 */
function get_like_count($post = null){
    global $wpdb;
    
    if($post == NULL){
        global $post;
    }
    $like_count = $wpdb->get_var( "SELECT SUM(value) FROM wp_wti_like_post WHERE post_id = $post->ID" );
    if(!$like_count) {
        $like_count = 0;
    }
    echo $like_count . " like";
}
/**
 * Output views count of the post
 * 
 * @global object $post
 * @param object $post
 */
function get_views_count($post = null){
    if($post == NULL){
        global $post;
    }   
    $views_count = intval(get_post_meta($post->ID, "views", true));
    echo $views_count . " views";
}

/* ----------------------------------------------------------------------------------- */
# Post Thumbnails
/* ----------------------------------------------------------------------------------- */
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}
/*if (function_exists('add_image_size')) {
    add_image_size('thumb60x60', 60, 60, FALSE);
    add_image_size('thumb80x80', 80, 80, FALSE);
    add_image_size('thumb117x70', 117, 70, FALSE);
}*/

/* ----------------------------------------------------------------------------------- */
# Register Sidebar
/* ----------------------------------------------------------------------------------- */
register_sidebar(array(
    'name' => __('Sidebar'),
    'before_widget' => '<div id="%1$s" class="widget-container r_box %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title r_box_head">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'name' => __('Footer Column 1'),
    'before_widget' => '<div id="%1$s" class="widget-footer-container %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'name' => __('Footer Column 2'),
    'before_widget' => '<div id="%1$s" class="widget-footer-container %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'name' => __('Footer Column 3'),
    'before_widget' => '<div id="%1$s" class="widget-footer-container %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<div class="widget-title">',
    'after_title' => '</div>',
));

//add_action( 'admin_footer', 'thang_admin_footer' );
//function thang_admin_footer(){
//     echo get_num_queries(); 
//     echo " queries in ";
//     timer_stop(1);
//     echo " seconds.";
//}