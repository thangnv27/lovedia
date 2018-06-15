<?php
/*
  Template Name: Page forgot password
 */
?>
<?php get_header(); ?>

<div class="categories">
    <span class="page-title"><?php the_title(); ?></span>
</div>
<!--/.categories-->

<div id="main">
    <div class="reg-form" style="width: 500px;">
        <div style="color: #ff6633; margin: 10px 0; font: 12px Arial;">Bạn sẽ nhận được một link tạo mật khẩu mới từ email đăng ký của bạn.</div>
        <form action="<?php bloginfo( 'siteurl' ); ?>/wp-login.php?action=lostpassword" 
              method="post" name="lostpasswordform" id="lostpasswordform">
            <label for="user_login">Email hoặc tài khoản *</label>
            <span class="input-text">
                <input type="text" value="" id="user_login" name="user_login" />
            </span>
            
            <input type="submit" class="btn-submit mt10 pdt13 pdb13" name="wp-submit" id="wp-submit" value="Giúp tôi" />
            <div class="clearfix"></div>

            <div class="btn-bot">
                <input type="hidden" name="token" value="<?php echo random_string(); ?>" />
                <input type="hidden" name="redirect_to" value="<?php echo (getRequest('redirect_to') != "") ? getRequest('redirect_to') : home_url(); ?>" />
                <input type="hidden" name="testcookie" value="1" />
            </div>
        </form>
    </div>
</div>
<!--/#main-->

<?php get_sidebar('login'); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>