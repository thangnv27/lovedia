<?php get_header(); ?>

<div class="categories">
    <span class="page-title">Search Results</span>
</div>
<!--/.categories-->

<div id="main">
    <div class="entries">
        <?php $counter = 1; ?>
        <?php while(have_posts()) : the_post(); ?>
        <?php if($counter == 1): ?>
        <div class="entry pdt0">
        <?php else: ?>
        <div class="entry">
        <?php endif; ?>
            <div class="thumb">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=132" />
                </a>
            </div>
            <div class="content">
                <div class="title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </div>
                <div class="post-meta">
                    <span class="author"><?php the_author_posts_link(); ?></span>
                    <span> - <?php the_time('d/m/Y'); ?></span>
                </div>
                <div class="description"><?php echo get_short_content(strip_tags(get_the_content('')), 390); ?></div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php $counter++; endwhile;?>
    </div>
    <!--/.entries-->
    <?php if(function_exists('getpagenavi')){ getpagenavi(); } ?>
</div>
<!--/#main-->

<?php get_sidebar(); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>
