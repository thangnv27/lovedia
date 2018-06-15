<?php
global $shortname;
$term = get_queried_object();
$catQAID = intval(get_option( $shortname . '_catQAID'));
if($term->term_id == $catQAID or $term->parent == $catQAID){
    //header("location: " . get_page_link(get_option($shortname . '_pageQAID')));
    include 'category-qa.php';
    exit();
}
?>
<?php get_header(); ?>
<div class="categories">
    <?php 
    $html = "";
    if($term->parent == 0){
        $cur_cat_link = get_category_link($term->term_id);
        $categories = get_categories( array(
            'hide_empty' => 0,
            'child_of' => $term->term_id,
        ));
        $html = <<<HTML
        <a href="{$cur_cat_link}" title="{$term->name}" class="current parent">{$term->name}</a>
HTML;
        foreach ($categories as $category) {
            $cat_link = get_category_link($category->term_id);
            $html .= <<<HTML
            &nbsp;|&nbsp;<a href="{$cat_link}" title="{$category->name}">{$category->name}</a>
HTML;
        }
    }else{
        $categories = get_categories( array(
            'hide_empty' => 0,
            'child_of' => $term->parent,
        ));
        $parent = get_category($term->parent);
        $cur_cat_link = get_category_link($parent->term_id);
        $html = <<<HTML
        <a href="{$cur_cat_link}" title="{$parent->name}" class="current parent">{$parent->name}</a>
HTML;
        foreach ($categories as $category) {
            $cat_link = get_category_link($category->term_id);
            if($term->term_id == $category->term_id){
                $html .= <<<HTML
            &nbsp;|&nbsp;<a href="{$cat_link}" title="{$category->name}" class="current">{$category->name}</a>
HTML;
            }else{
                $html .= <<<HTML
            &nbsp;|&nbsp;<a href="{$cat_link}" title="{$category->name}">{$category->name}</a>
HTML;
            }
        }
    }
    echo $html;
    ?> 
</div>
<!--/.categories-->

<div id="main">
    <?php if(have_posts()): ?>
    <div class="top-archive">
        <?php 
        $counter = 1;
        while(have_posts()) : the_post();
            if($counter == 1): 
        ?>
        <div class="first">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=467&h=280" />
            </a>
            <div class="caption">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
            </div>
        </div>
        <div class="second">
            <?php else: ?>
            <div class="item">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=233&h=140" />
                </a>
                <div class="caption">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </div>
            </div>
            <?php endif; ?>
            <?php 
                $counter++; 
                if($counter == 4){
                    break;
                }
            endwhile;?>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php endif; ?>
    
    <!--Ad archive-->
    <div id="ad_archive"><?php echo stripslashes(get_option('ad_archive')); ?></div>
    <!--/Ad archive-->
    
    <div class="entries">
        <?php 
        $counter = 1;
        while(have_posts()) : the_post();
            if($counter == 1): 
        ?>
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
                    <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
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
