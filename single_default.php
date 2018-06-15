<?php get_header(); ?>

<div class="categories">
    <?php
    $terms = get_the_category();
    $cat = array();
    $html = "";
    $show_cat = array();
    foreach ($terms as $term) :
        array_push($cat, $term->term_id);
    
        if($term->parent == 0){
            if(!in_array($term->term_id, $show_cat)){
                $show_cat['parent-' . $term->term_id] = $term->term_id;
            }else{
                if (($key = array_search($term->term_id, $show_cat)) !== false) {
                    unset($show_cat[$key]);
                }
                $show_cat['parent-' . $term->term_id] = $term->term_id;
            }
            $categories = get_categories( array(
                'hide_empty' => 0,
                'child_of' => $term->term_id,
            ));
            foreach ($categories as $category) {
                if(!in_array($category->term_id, $show_cat)){
                    array_push($show_cat, $category->term_id);
                }
            }
        }else{
            if(!in_array($term->term_id, $show_cat)){
                $show_cat['current-' . $term->term_id] = $term->term_id;
            }else{
                if (($key = array_search($term->term_id, $show_cat)) !== false) {
                    unset($show_cat[$key]);
                }
                $show_cat['current-' . $term->term_id] = $term->term_id;
            }
            if(!in_array($term->parent, $show_cat)){
                $show_cat['parent-' . $term->parent] = $term->parent;
            }
            $categories = get_categories( array(
                'hide_empty' => 0,
                'child_of' => $term->parent,
            ));
            foreach ($categories as $category) {
                if(!in_array($category->term_id, $show_cat)){
                    array_push($show_cat, $category->term_id);
                }
            }
        }
    endforeach;
    
    $i = 0;
    asort($show_cat);
    foreach ($show_cat as $k => $v) {
        $cat = get_category($v);
        $cat_link = get_category_link($v);
        if(!is_numeric($k)){
            if(strpos($k, "current") !== false){
                $k = 'current';
            }elseif(strpos($k, "parent") !== false){
                $k = 'parent';
            }
        }
        if($i == 0){
            $html .= <<<HTML
    <a href="{$cat_link}" title="{$cat->name}" class="{$k}">{$cat->name}</a>
HTML;
        }else{
            $html .= <<<HTML
    &nbsp;|&nbsp;<a href="{$cat_link}" title="{$cat->name}" class="{$k}">{$cat->name}</a>
HTML;
        }
        $i++;
    }
   
    echo $html;
    ?>
</div>
<!--/.categories-->

<div id="post_main">
    <?php while(have_posts()) : the_post(); ?>
    <div class="post">
        <h1 class="title"><?php the_title(); ?></h1>
        <div class="post-meta">
            <?php the_time('d/m/Y'); ?> - <span class="author"><?php the_author_posts_link(); ?></span>
            &nbsp;|&nbsp;<span><?php get_like_count(); ?></span>
            <?php if(function_exists('the_views')) { echo '&nbsp;|&nbsp;<span>'; the_views(); echo '</span>'; } ?>
            <?php if (get_the_tags()): ?>
            &nbsp;|&nbsp;<span class="post_tags"><?php the_tags( '<b>Tags: </b>', ', ', ''); ?></span>
            <?php endif; ?>
        </div>
        
        <?php include 'like-post.php'; ?>
        
        <div class="post-content"><?php the_content(); ?></div>
        
        <?php if (get_the_tags()): ?>
        <div class="post_tags"><?php the_tags( '<b>Tags: </b>', ', ', ''); ?></div>
        <?php endif; ?>
        
        <div class="like-post-bottom">
            <div class="fb-like" data-href="<?php echo getCurrentRquestUrl(); ?>" data-width="450" data-show-faces="false" data-send="true"></div>
            <div class="fr">
                <div class="mrk-LH-embed-holder"></div>
                <script language="javascript" type="text/javascript">
                    if (typeof LHClass_Link_Post_Embed == 'undefined') {
                        if (typeof LH_Link_Post_Embed_Loader == 'undefined') {
                            var LH_Link_Post_Embed_Loader = document.createElement('script');

                            LH_Link_Post_Embed_Loader.type = 'text/javascript';
                            LH_Link_Post_Embed_Loader.src = 'http://linkhay2.vcmedia.vn/live/js/link/post/adapter/embed/main.js';

                            document.getElementsByTagName('head')[0].appendChild(LH_Link_Post_Embed_Loader);
                        }
                    } else {
                        LH_Link_Post_Embed_Scan();
                    }
                </script>
                <div class="inline"><g:plusone></g:plusone></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="author-box">
            <div class="avatar">
                <?php echo get_avatar( $post->post_author, 100 ); ?>
            </div>
            <div class="info">
                <div class="name">Tác giả: <?php the_author_posts_link(); ?></div>
                <div class="description">
                    <?php echo get_the_author_meta( 'description', $post->post_author ); ?>
                </div>
                <div class="view-all-posts"><a href="<?php echo get_author_posts_url( $post->post_author ); ?>">Xem tất cả bài viết</a></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!--/.post-->
    <div class="related_posts">
        <h3 class="title">Bài viết liên quan</h3>
        <div class="posts">
            <?php
            $excludeID = array();
            array_push($excludeID, get_the_ID());
            $args = array(
                'post_type' => 'post',
                'post__not_in' => $excludeID,
                'posts_per_page' => 4,
                'category__in' => $cat,
            );
            $loop = new WP_Query($args);
            if($loop->post_count > 0):
            $counter = 1;
            while($loop->have_posts()) : $loop->the_post();
                if($counter == $loop->post_count):
            ?>
            <div class="item mr0">
                <?php else: ?>
            <div class="item">
                <?php endif; ?>
                <div class="thumb">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=160&h=96" />
                    </a>
                </div>
                <div class="title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </div>
            </div>
            <?php $counter++; endwhile;?>
            <?php wp_reset_query(); ?>
            <div class="clearfix"></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="comment_box">
        <h3 class="title">Bình luận</h3>
        <div class="comment_box_ct">
            <div class="fb-comments" data-href="<?php echo getCurrentRquestUrl(); ?>" data-width="695" data-num-posts="10"></div>
        </div>
    </div>
    <?php endwhile;?>
</div>
<!--/#post_main-->

<?php get_sidebar(); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>
