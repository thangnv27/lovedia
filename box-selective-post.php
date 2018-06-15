<div class="r_box">
    <div class="r_box_head">Bài viết tuyển chọn</div>
    <?php 
    global $shortname;
    $selectiveType = get_option($shortname . '_selectivePostType');
    $selectiveID = explode(',', get_option($shortname . '_selectivePost'));
    $args = array(
        'post_type' => array( 'post', 'page', ),
        'post__in' => $selectiveID,
        'orderby' => 'rand',
        'posts_per_page' => 1,
    );
    if($selectiveType == 'cat'){
        $args = array(
            'post_type' => array( 'post', ),
            'category__in' => $selectiveID,
            'orderby' => 'rand',
            'posts_per_page' => 1,
        );
    }
    $loop = new WP_Query($args); 
    while ($loop->have_posts()) : $loop->the_post();
    ?>
    <div class="selective-post">
        <div class="thumb">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=200" />
            </a>
        </div>
        <div class="title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
        </div>
        <div class="description">
            <?php 
                global $more;
                $more = 0; 
                echo strip_tags(get_the_content('...')); 
            ?>
        </div>
        <div class="post-meta">
            <span class="author"><?php the_author_posts_link(); ?></span>
            <span> - <?php the_time('d/m/Y'); ?></span>
        </div>
    </div>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
</div>