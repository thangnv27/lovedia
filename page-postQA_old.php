<?php
if(!isset($_SESSION['current_user_login'])) {
    header("location: " . get_page_link(get_option('lovedia_pageLoginID')) . "?redirect_to=" . getCurrentRquestUrl());
}
?>
<?php get_header(); ?>

<div class="categories">
    <span class="page-title"><?php the_title(); ?></span>
</div>
<!--/.categories-->

<div id="main">
    <div id="message"></div>
    <div id="tabs_post_question">
        <ul class="tabs-post-qa">
            <li class="content"><a href="#tab-content">Nội dung</a></li>
            <li class="photo"><a href="#tab-photo">Hình ảnh</a></li>
        </ul>
        <div id="tab-content">
            <form method="post" action="" id="frmPostContent">
                <div class="content-form">
                    <input type="text" name="post_title" id="post_title" value="" placeholder="Tiêu đề"/>
                    <div class="wrap-content">
                        <?php 
                            wp_editor("", 'post_content', array(
                                'textarea_name' => 'post_content',
                                'tinymce' => array(
                                    'theme_advanced_buttons1' => 'undo,redo,|,formatselect,|,bold,italic,underline,|,' .
                                        'bullist,numlist,blockquote,outdent,indent,|,justifyleft,justifycenter' .
                                        ',justifyright,justifyfull,|,link,unlink,|' .
                                        ',image,media,|,code',
                                    'theme_advanced_buttons2' => '',
                                )
                            ));
                        ?>
                    </div>
                    <div class="input-wrap" style="border-bottom: 1px solid #cccccc;">
                        <label for="post_tags">Tags: </label>
                        <input type="text" name="post_tags" id="post_tags" value="" />
                    </div>
                    <div class="input-wrap">
                        <label class="fl mt12" for="captcha_content">Captcha: </label>
                        <div>
                            <input type="text" name="captcha" id="captcha_content" value="" />
                            <img id="captcha_content_img" alt="" src="<?php bloginfo('stylesheet_directory'); ?>/includes/captcha.php" width="125" height="50" class="fr" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="btnAction">
                    <input type="button" name="btnCancel" class="btnCancel" value="Hủy bỏ" />
                    <input type="button" name="btnPost" id="btnPostContent" value="Đăng bài" />
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
        <!--/#tab-content-->
        <div id="tab-photo">
            <form method="post" name="upload" id="upload" action="<?php bloginfo( 'stylesheet_directory' ); ?>/upload.php" enctype="multipart/form-data">
                <div class="photo-form">
                    <input type="text" name="title" id="photo_title" value="" class="photo-title" placeholder="Tiêu đề"/>
                    <div class="wrap-file">
                        <div id="drop">
                            <a>Tải hình ảnh lên</a>
                            <input type="file" name="upl" />
                            <ul><!-- The file uploads will be shown here --></ul>
                        </div>
                    </div>
                    <div class="img_url">
                        <label for="img_url">URL: </label>
                        <input type="text" name="img_url" id="img_url" value="" placeholder="Có thể dẫn link ảnh khác vào đây" />
                    </div>
                    <div class="img_tags">
                        <label for="img_tags">Tags: </label>
                        <input type="text" name="img_tags" id="img_tags" value="" />
                    </div>
                    <div class="input-wrap">
                        <label class="fl mt12" for="captcha_photo">Captcha: </label>
                        <div>
                            <input type="text" name="captcha" id="captcha_photo" value="" />
                            <img id="captcha_photo_img" alt="" src="<?php bloginfo('stylesheet_directory'); ?>/includes/captcha.php" width="125" height="50" class="fr" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="btnAction">
                    <div style="color: #ff6633; margin: 10px 0; font: 12px Arial; float: left; text-align: left;">
                        <p>Chỉ cho phép các định dạng ( jpg, png và gif ).</p>
                        <p>Chỉ đăng được 1 hình ảnh.</p>
                    </div>
                    <input type="button" name="btnCancel" class="btnCancel" value="Hủy bỏ" />
                    <input type="button" name="btnPost" id="btnPostPhoto" value="Đăng" />
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
        <!--/#tab-photo-->
    </div>
</div>
<!--/#main-->

<?php get_sidebar('login'); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>