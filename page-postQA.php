<?php
/*
  Template Name: Page Post Question
 */
?>
<?php
global $shortname;
if(!isset($_SESSION['current_user_login'])) {
    header("location: " . get_page_link(get_option($shortname . '_pageLoginID')) . "?redirect_to=" . getCurrentRquestUrl());
    exit();
}
?>

<?php get_header(); ?>

<div class="categories">
    <span class="page-title"><?php the_title(); ?></span>
</div>
<!--/.categories-->

<script type="text/javascript">
    $(function(){
        var redirect = true;
        $(window).bind('beforeunload', function(e){
            if(!disabledConfirm_exit){
                //var e = e || window.event;
                //var message = "Bạn có thật sự muốn rời khỏi trang này không?";
                Post.leavePagePostQA();
                alert("Click OK để rời khỏi trang này!")
                /*
                if(confirm(message)){
                    Post.leavePagePostQA();
                }else{
                    // For IE and Firefox prior to version 4
                    if (e) {
                        e.returnValue = message ;
                    }
                    // For Safari
                    return message;
                }*/
            }
        });
    });
</script>

<div id="main">
    <div id="message"></div>
    <div id="post_qa">
        <form method="post" name="upload" id="upload" action="<?php bloginfo( 'stylesheet_directory' ); ?>/upload.php" enctype="multipart/form-data">
            <div class="photo-form">
                <div class="input-wrap">
                    <input type="text" name="post_title" id="post_title" value="" class="title" placeholder="Tiêu đề"/>
                </div>
                <div class="wrap-file">
                    <div id="drop">
                        <a></a>
                        <input type="file" name="upl" />
                        <ul><!-- The file uploads will be shown here --></ul>
                    </div>
                </div>
                <div class="input-wrap">
                    <label for="img_url">URL: </label>
                    <input type="text" name="img_url" id="img_url" value="" class="img_url" placeholder="Có thể dẫn link ảnh khác vào đây" />
                </div>
            </div>
            <div class="content-form">
                <div class="wrap-content">
                    <div style="font-family: Arial; padding-top: 5px; float: left;">Nội dung</div>
                    <?php 
                        wp_editor("", 'post_content', array(
                            'textarea_name' => 'post_content',
                            'media_buttons' => false,
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
                <div class="input-wrap" style="border-bottom: 1px solid #eaeaea; border-left: 1px solid #eaeaea; border-right: 1px solid #eaeaea;">
                    <label for="post_tags" class="tags"></label>
                    <input type="text" name="post_tags" id="post_tags" class="tags" value="" />
                </div>
            </div>
            <div class="btnAction">
                <div class="input-wrap fl">
                    <input type="text" name="captcha" id="captcha" value="" class="captcha" />
                    <img id="captcha_img" alt="" src="<?php bloginfo('stylesheet_directory'); ?>/includes/captcha.php" width="125" height="50" class="fr" />
                    <div class="clearfix"></div>
                </div>
                <div class="fr">
                    <input type="button" name="btnCancel" class="button btn-cancel" value="Hủy bỏ" onclick="disabledConfirm_exit=true;" />
                    <input type="button" name="btnPost" class="button btn-submit" value="Đăng bài" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div style="color: #ff6633; margin: 10px 0; font: 12px Arial; float: left; text-align: left;">
                <p>Chỉ cho phép các định dạng ( jpg, png và gif ).</p>
                <p>Chỉ đăng được 1 hình ảnh.</p>
            </div>
        </form>
    </div>
    <!--/#post_qa-->
</div>
<!--/#main-->

<?php get_sidebar('login'); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>