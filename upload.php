<?php
if (!isset($_SESSION)) session_start();

include 'includes/custom.php';

// A list of permitted file extensions
//$allowed = array('png', 'jpg', 'gif','zip');
$allowed = array('png', 'jpg', 'gif');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
    $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

    if (!in_array(strtolower($extension), $allowed)) {
        echo '{"status":"error"}';
        exit;
    }
    
    if(isset($_SESSION['current_user_login'])) {
        $max_size = 5 * 1024 * 1024;
        $file_size = $_FILES['upl']['size'];
        if($file_size > $max_size){
            echo json_encode(array(
                "status" => "error",
                "message" => "<p>File quá lớn, kích thước file giới hạn 5M.</p>",
            ));
            exit;
        }
        
        $user = $_SESSION['current_user_login'];
        $user = TObjectToArray($user);
        $username = $user['data']->user_login;
        $upload_dir = $_SESSION['UPLOAD_DIR'];
        $path = $upload_dir['basedir'] . "/" . $username;
        if (!is_dir($path)){
            mkdir($path, 0755);
        }
        
        $name = random_string() . "_" . $_FILES['upl']['name'];
        $tmp_name = $path . '/' . $name;

        if (move_uploaded_file($_FILES['upl']['tmp_name'], $tmp_name )) {
            $tmp_url = $upload_dir['baseurl'] . "/" . $username . "/" . $name;
            $_FILES['upl']['name'] = $name;
            $_FILES['upl']['tmp_name'] = $tmp_name;
            $_FILES['upl']['tmp_url'] = $tmp_url;
            
            // Unlink old tmp file
            if(isset($_SESSION['QA_IMAGE_FILE'])){
                $file = $_SESSION['QA_IMAGE_FILE'];
                @unlink($file['tmp_name']);
            }
                
            $_SESSION['QA_IMAGE_FILE'] = $_FILES['upl'];
            
            echo json_encode(array(
                "status" => "success",
                "filename" => $name,
                "tmp_url" => $tmp_url,
            ));
            exit;
        }
    }else{
        echo '{"status":"error"}';
        exit;
    }
}

echo '{"status":"error"}';
exit;