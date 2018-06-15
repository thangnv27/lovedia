<?php
/*
  Template Name: Page Login
 */
?>
<?php
if(isset($_SESSION['current_user_login'])) {
    header("location: " . home_url());
}
?>
<?php get_header(); ?>

<div class="categories">
    <span class="page-title"><?php the_title(); ?></span>
</div>
<!--/.categories-->

<div id="main">
    <div id="message"></div>
    <div class="social_login">
        <div class="facebook fblogin">
            <a href="<?php bloginfo( 'siteurl' ); ?>/wp-login.php?loginFacebook=1&redirect=<?php echo (getRequest('redirect_to') != "") ? getRequest('redirect_to') : home_url(); ?>">
                <img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/btn_fb_login.jpg" alt="Đăng nhập bằng Facebook" />
            </a>
        </div>
    </div>
    <div class="reg-form">
        <form action="<?php bloginfo( 'siteurl' ); ?>/wp-login.php" method="post" name="loginform" id="loginform">
            <label for="user_login">Tên đăng nhập *</label>
            <span class="input-text">
                <input type="text" value="" id="user_login" name="log" />
            </span>

            <label for="user_pass">Mật khẩu *</label>
            <span class="input-text">
                <input type="password" value="" id="user_pass" name="pwd" />
            </span>

            <p>
                <label for="rememberme">Ghi nhớ
                    <input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" style="" />
                </label>
            </p>

            <div class="btn-bot">
                <div class="links">
                    <a href="<?php echo get_page_link(get_option('lovedia_pageRegisterID')); ?>">Đăng ký</a>
                    <a href="<?php echo get_page_link(get_option('lovedia_pageForgotPwdID')); ?>">Quên mật khẩu?</a>
                </div>
                <input type="submit" class="btn-submit" name="wp-submit" id="btnLogin" value="Đăng nhập" />
                <div class="clearfix"></div>
                <input type="hidden" name="redirect_to" value="<?php echo (getRequest('redirect_to') != "") ? getRequest('redirect_to') : home_url(); ?>" />
                <input type="hidden" name="testcookie" value="1" />
            </div>
        </form>
    </div>
</div>
<!--/#main-->

<?php get_sidebar('login'); ?>
<div class="clearfix"></div>

<script type="text/javascript">
    $(function(){
        User.login();
    });
</script>

<?php get_footer(); ?>