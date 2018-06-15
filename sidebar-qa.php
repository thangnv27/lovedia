<div id="sidebar">
    <div class="r_box">
        <div class="button-post-qa">
            <?php global $shortname; ?>
            <a href="<?php echo get_page_link(intval(get_option($shortname . "_pagePostQAID"))); ?>">Đăng câu hỏi</a>
        </div>
    </div>
    
    <?php include 'box-most-posts-qa.php'; ?>
    
    <?php include 'box-selective-post.php'; ?>
    
    <?php include 'box-like-facebook.php'; ?>
    
    <?php //include 'box-post-new-liked.php'; ?>
    
    <?php if (function_exists('dynamic_sidebar') and dynamic_sidebar('Sidebar')): ?><?php else: ?><?php endif; ?>
</div>
<!--/#sidebar-->