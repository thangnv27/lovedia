<?php get_header(); ?>

<div class="categories">
    <span class="page-title"><?php the_title(); ?></span>
</div>
<!--/.categories-->

<div id="post_main">
    <?php while(have_posts()) : the_post(); ?>
    <div class="post">
        <h1 class="title"><?php the_title(); ?></h1>
        <div class="post-meta">
            <?php the_time('d/m/Y'); ?> - <span class="author"><?php the_author_posts_link(); ?></span>
            <?php if (get_the_tags()): ?>
            &nbsp;|&nbsp;<span class="post_tags"><?php the_tags( '<b>Tags: </b>', ', ', ''); ?></span>
            <?php endif; ?>
        </div>
        
        <?php include 'like-post.php'; ?>
        
        <div class="post-content"><?php the_content(); ?></div>
        
        <?php if (get_the_tags()): ?>
        <div class="post_tags"><?php the_tags( '<b>Tags: </b>', ', ', ''); ?></div>
        <?php endif; ?>
    </div>
    <!--/.post-->
    <div class="comment_box mt20">
        <!--<h3 class="title">Bình luận</h3>-->
        <div class="comment_box_ct">
            <div class="fb-comments" data-href="<?php echo getCurrentRquestUrl(); ?>" data-width="700" data-num-posts="10"></div>
        </div>
    </div>
    <?php endwhile;?>
</div>
<!--/#post_main-->

<?php get_sidebar(); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>
