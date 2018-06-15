<?php
/*
  Template Name: Page Register
 */
?>
<?php
if (isset($_SESSION['current_user_login'])) {
    header("location: " . home_url());
}
$msg = array(
    'warning' => array(),
    'success' => array()
);
if (getRequestMethod() == 'POST') {
    if($_SESSION['security_code'] == getRequest('captcha')){
        $sanitized_user_login = sanitize_user(getRequest('username'));
        $email = getRequest('email');
        $password = getRequest('pwd');
        $password2 = getRequest('repwd');

        if ($sanitized_user_login == "") {
            array_push($msg['warning'], "<p>Vui lòng nhập tài khoản!</p>");
        } elseif (!validate_username($sanitized_user_login)) {
            array_push($msg['warning'], "<p>Tài khoản không hợp lệ, vui lòng nhập tài khoản khác!</p>");
        } elseif (username_exists($sanitized_user_login)) {
            array_push($msg['warning'], "<p>Tài khoản đã tồn tại, vui lòng nhập tài khoản khác!</p>");
        } elseif (!is_email($email)) {
            array_push($msg['warning'], "<p>Địa chỉ email không hợp lệ!</p>");
        } elseif (email_exists($email)) {
            array_push($msg['warning'], "<p>Địa chỉ email này đã tồn tại!</p>");
        } elseif ($password == "") {
            array_push($msg['warning'], "<p>Vui lòng nhập mật khẩu!</p>");
        } elseif ($password2 != $password) {
            array_push($msg['warning'], "<p>Xác nhận mật khẩu không chính xác!</p>");
        } else {
            $user_id = wp_create_user($sanitized_user_login, $password, $email);
            if (!$user_id || is_wp_error($user_id)) {
                array_push($msg['warning'], "Đăng ký lỗi. Vui lòng liên hệ <a href='mailto:" . get_option('admin_email') . "'>quản trị website</a>!");
            } else {
                array_push($msg['success'], "Đăng ký thành công!");
                //Set up the Password change nag.
                update_user_option($user_id, 'default_password_nag', true, true);
                // notification for user
                //wp_new_user_notification($user_id, $password);
                custom_wp_new_user_notification($user_id, $password);
            }
        }
    }else{
        array_push($msg['warning'], "<p>Mã bảo vệ không chính xác!</p>");
    }
}
?>
<?php get_header(); ?>

<div class="categories">
    <span class="page-title"><?php the_title(); ?></span>
</div>
<!--/.categories-->

<div id="main">
    <div id="message" class="<?php
    if (!empty($msg['warning'])) {
        echo 'warning';
    } elseif (!empty($msg['success'])) {
        echo 'success';
    }
    ?>">
    <?php
    if (!empty($msg['warning'])) {
        foreach ($msg['warning'] as $m) {
            echo $m;
        }
    }
    if (!empty($msg['success'])) {
        foreach ($msg['success'] as $m) {
            echo $m;
        }
    }
    ?>
    </div>
    <div class="social_login">
        <div class="facebook fbsignup">
            <a href="<?php bloginfo('siteurl'); ?>/wp-login.php?loginFacebook=1&redirect=<?php echo (getRequest('redirect_to') != "") ? getRequest('redirect_to') : home_url(); ?>">
                <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/btn_fb_reg.jpg" alt="Đăng ký bằng Facebook" />
            </a>
        </div>
    </div>
    <div style="color: #009966; font: 13px Arial; padding: 20px 0 10px;">Hoặc</div>
    <div class="reg-form">
        <form action="" method="post" id="registerform" name="registerform">
            <label for="username">Tên đăng nhập *</label>
            <span class="input-text">
                <input type="text" value="<?php echo getRequest('username'); ?>" name="username" id="username" />
            </span>
            <label for="user_email">Email *</label>
            <span class="input-text">
                <input type="text" value="<?php echo getRequest('email'); ?>" name="email" id="user_email" />
            </span>
            <label for="user_pass">Mật khẩu *</label>
            <span class="input-text">
                <input type="password" value="<?php echo getRequest('pwd'); ?>" name="pwd" id="user_pass" />
            </span>

            <label for="user_pass2">Nhập lại mật khẩu *</label>
            <span class="input-text">
                <input type="password" value="" name="repwd" id="user_pass2" />
            </span>
            <label for="captcha">Mã bảo vệ *</label>
            <span class="input-text">
                <input type="text" value="" name="captcha" id="captcha" style="width: 197px;" class="fl" />
                <img alt="" src="<?php bloginfo('stylesheet_directory'); ?>/includes/captcha.php" width="123" height="50" class="fr" />
                <div class="clearfix"></div>
            </span>
            <div class="btn-bot">
                <div class="links">
                    <a href="<?php echo get_page_link(get_option('lovedia_pageLoginID')); ?>">Đăng nhập</a>
                    <a href="<?php echo get_page_link(get_option('lovedia_pageForgotPwdID')); ?>">Quên mật khẩu?</a>
                </div>
                <input type="submit" class="btn-submit" id="btnReg" value="Đăng ký" />
                <div class="clearfix"></div>
                <input type="hidden" name="token" value="<?php echo random_string(); ?>" />
                <input type="hidden" name="redirect_to" value="<?php echo (getRequest('redirect_to') != "") ? getRequest('redirect_to') : home_url(); ?>" />
            </div>
        </form>
    </div>
</div>
<!--/#main-->

<?php get_sidebar('login'); ?>
<div class="clearfix"></div>

<script type="text/javascript">
    $(function(){
        User.register();
    });
</script>

<?php get_footer(); ?>