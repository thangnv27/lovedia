<div id="sidebar">
    <?php include 'box-most-posts.php'; ?>
    
    <?php include 'box-selective-post.php'; ?>
    
    <?php include 'box-like-facebook.php'; ?>
    
    <?php //include 'box-post-new-liked.php'; ?>
    
    <?php if (function_exists('dynamic_sidebar') and dynamic_sidebar('Sidebar')): ?><?php else: ?><?php endif; ?>
</div>
<!--/#sidebar-->