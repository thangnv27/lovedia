<?php
add_action('init', 'add_custom_js');
add_action( 'wp_ajax_nopriv_' . getRequest('action'), getRequest('action') );  
add_action( 'wp_ajax_' . getRequest('action'), getRequest('action') ); 

function add_custom_js() {
    // code to embed th  java script file that makes the Ajax request  
    //wp_enqueue_script('ajax.js', get_bloginfo('template_directory') . "/js/ajax.js", array('jquery'), false, true);
    wp_enqueue_script('ajax.js', get_bloginfo('template_directory') . "/js/ajax.js");
    // code to declare the URL to the file handling the AJAX request 
    //wp_localize_script( 'ajax-request', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); 
}
    
/**
 * Add new post into Q&A category
 */
function QA_insert_post_content() {
    if($_SESSION['security_code'] == getRequest('captcha')){
        global $current_user, $shortname;
        get_currentuserinfo();

        $post_title = getRequest('post_title');
        $post_content = getRequest('post_content');
        $post_tags = getRequest('post_tags');

        $categories = array();
        array_push($categories, intval(get_option( $shortname . '_catQAID')));

        // Create post object
        $postQA = array(
            'post_type' => 'post',
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_status' => 'draft', // 'publish'
            'post_author' => $current_user->ID,
            'post_category' => $categories,
        );

        // Insert the post into the database
        $post_id = wp_insert_post($postQA);

        // Add tags to this post
        if(trim($post_tags) != ""){
            wp_set_post_tags( $post_id, $post_tags, true );
        }

        Response(json_encode(array(
            'status' => 'success',
        )));
    }else{
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Wrong captcha'
        )));
    }
    die();
}

/**
 * Post new photo into Q&A category
 */
function QA_insert_post_photo() {
    if($_SESSION['security_code'] == getRequest('captcha')){
        global $current_user, $shortname;
        get_currentuserinfo();

        $title = getRequest('title');
        $img_url = getRequest('img_url');
        $img_tags = getRequest('img_tags');

        $categories = array();
        array_push($categories, intval(get_option( $shortname . '_catQAID')));

        // Create post object
        $postQA = array(
            'post_type' => 'post',
            'post_title' => $title,
            'post_content' => '',
            'post_status' => 'draft', // 'publish'
            'post_author' => $current_user->ID,
            'post_category' => $categories,
        );

        // Insert the post into the database
        $post_id = wp_insert_post($postQA);

        if(isset($_SESSION['QA_IMAGE_FILE'])){
            $file = $_SESSION['QA_IMAGE_FILE'];

            set_featured_image_width_handle_sideload($file, $post_id);

            unset($_SESSION['QA_IMAGE_FILE']);
        }elseif(trim($img_url) != ""){
            set_featured_image_width_media_sideload($img_url, $post_id);
        }

        // Add tags to this post
        if(trim($img_tags) != ""){
            wp_set_post_tags( $post_id, $img_tags, true );
        }

        Response(json_encode(array(
            'status' => 'success',
        )));
    }else{
        Response(json_encode(array(
            'status' => 'error',
            'message' => 'Wrong captcha'
        )));
    }
    die();
}

/**
 * Insert new post into Q&A category
 */
function QA_insert_new_post() {
    if($_SESSION['security_code'] == getRequest('captcha')){
        global $current_user, $shortname;
        get_currentuserinfo();

        $limit_title = 150;
        $limit_content = 2000;
        $title = getRequest('title');
        $img_url = getRequest('img_url');
        $post_content = getRequest('post_content');
        $post_tags = getRequest('post_tags');
        
        $errorMsg = "";
        if($title == ""){
            $errorMsg .= "<p>Vui lòng nhập tiêu đề.</p>";
        }elseif(strlen($title) > $limit_title){
            $errorMsg .= "<p>Độ dài tiêu đề giới hạn $limit_title ký tự.</p>";
        }
        if($img_url == "" and !isset($_SESSION['QA_IMAGE_FILE'])){
            $errorMsg .= "<p>Vui lòng tải ảnh lên.</p>";
        }
        if(strlen($post_content) > $limit_content){
            $errorMsg .= "<p>Độ dài nội dung giới hạn $limit_content ký tự.</p>";
        }
        
        if($errorMsg != ""){
            Response(json_encode(array(
                'status' => 'error',
                'message' => $errorMsg,
            )));
            exit();
        }

        $categories = array();
        array_push($categories, intval(get_option( $shortname . '_catQAID')));

        // Create post object
        $postQA = array(
            'post_type' => 'post',
            'post_title' => $title,
            'post_content' => $post_content,
            'post_status' => 'draft', // 'publish'
            'post_author' => $current_user->ID,
            'post_category' => $categories,
        );

        // Insert the post into the database
        $post_id = wp_insert_post($postQA);

        if(isset($_SESSION['QA_IMAGE_FILE'])){
            $file = $_SESSION['QA_IMAGE_FILE'];

            set_featured_image_width_handle_sideload($file, $post_id);

            unset($_SESSION['QA_IMAGE_FILE']);
        }elseif(trim($img_url) != ""){
            set_featured_image_width_media_sideload($img_url, $post_id);
        }

        // Add tags to this post
        if(trim($post_tags) != ""){
            wp_set_post_tags( $post_id, $post_tags, true );
        }
        
        // Scanning and delete all tmp files
        delete_all_tmp_files();

        Response(json_encode(array(
            'status' => 'success',
        )));
    }else{
        Response(json_encode(array(
            'status' => 'error',
            'message' => '<p>Wrong captcha</p>'
        )));
    }
    exit();
}

/**
 * Cancel post Q&A
 */
function QA_post_cancel(){
    if(isset($_SESSION['QA_IMAGE_FILE'])){
        //$file = $_SESSION['QA_IMAGE_FILE'];
        //@unlink($file['tmp_name']);
        unset($_SESSION['QA_IMAGE_FILE']);
    }
    
    delete_all_tmp_files();
    
    Response(json_encode(array(
        'status' => 'success',
    )));
    die();
}

function delete_all_tmp_files(){
    global $current_user;
    get_currentuserinfo();
        
    $upload_dir = wp_upload_dir();
    $dir = $upload_dir['basedir'] . "/" . $current_user->user_login;
    $files = scandir($dir);
    foreach ($files as $filename) {
        $filename = $dir . "/" . $filename;
        if(is_file($filename)){
            @unlink($filename);
        }
    }
}