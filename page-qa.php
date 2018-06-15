<?php
/*
  Template Name: Page Q&A
 */
?>
<?php get_header(); ?>

<div class="categories">
    <?php 
    global $shortname;
    $catQAID = intval(get_option( $shortname . '_catQAID'));
    if($catQAID > 0): 
        $term = get_category($catQAID);
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
    else:
    ?> 
    <span class="page-title"><?php the_title(); ?></span>
    <?php endif; ?>
</div>
<!--/.categories-->


<div id="main_qa">
    <div class="entries">
        <?php 
        if($catQAID > 0):
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $loop = new WP_Query(array(
            'post_type' => 'post',
            'cat' => $catQAID,
            'paged' => $paged,
        ));
        if($loop->post_count > 0):
        $counter = 1;
        while($loop->have_posts()) : $loop->the_post();
            if($counter == 1): 
        ?>
        <div class="entry pdt0">
        <?php else: ?>
        <div class="entry">
        <?php endif; ?>
            <div class="thumb">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=400" />
                </a>
            </div>
            <div class="content">
                <div class="title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </div>
                <div class="post-meta">
                    <span><?php the_time('d/m/Y'); ?> - </span>
                    <span class="author"><?php the_author_posts_link(); ?></span>
                </div>
                <div class="fb-like" data-href="<?php the_permalink(); ?>" data-width="280" data-show-faces="false" data-send="false"></div>
                <div class="description">
                    <?php 
                    /*global $more;
                    $more = 0; 
                    echo strip_tags(get_the_content('...')); */
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php $counter++; endwhile;?>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    <!--/.entries-->
    <?php if(function_exists('getpagenavi')){ getpagenavi(array( 'query' => $loop )); } ?>
</div>
<!--/#main-->

<?php get_sidebar('qa'); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>
