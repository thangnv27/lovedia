<?php 
global $shortname;
$catQAID = array(); 
array_push($catQAID, intval(get_option( $shortname . '_catQAID')));
?>
<div class="r_box">
    <div class="most-posts">
        <ul class="tabs-most-posts">
            <li><a href="#tab-most-read">Đọc nhiều</a></li>
            <li><a href="#tab-most-like">Like nhiều</a></li>
        </ul>
        <div id="tab-most-read" class="tab-most-right">
            <ul class="tab-most-read">
                <?php
                query_posts(array(
                    'post_type' => 'post',
                    'category__in' => $catQAID,
                    'posts_per_page' => 10,
                    'orderby' => 'meta_value_num',
                    'meta_key' => 'views',
                    'order' => 'DESC',
                ));
                while (have_posts()) : the_post();
                    ?>
                    <li>
                        <div class="thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=80&h=48" />
                            </a>
                        </div>
                        <div class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                        <div class="clearfix"></div>
                        <div class="post-meta">
                            <span class="author"><?php the_author_posts_link(); ?></span>
                            <span> - <?php the_time('d/m/Y'); ?></span>
                        </div>
                    </li>
                    <?php
                endwhile;
                wp_reset_query();
                ?>
            </ul>
        </div>
        <!--/#tab-most-read-->
        <div id="tab-most-like" class="tab-most-right">
            <ul class="tab-most-read">
                <?php
                global $wpdb;
                $tblPosts = $wpdb->prefix . "posts";
                $tbl_term_relationships = $wpdb->prefix . "term_relationships";
                $tbl_term_taxonomy = $wpdb->prefix . "term_taxonomy";
                $tblLikePost = $wpdb->prefix . "wti_like_post";
                $catQA_ID = intval(get_option( $shortname . '_catQAID'));
                $sql = "SELECT DISTINCT $tblPosts.*, SUM($tblLikePost.value) as totalLiked FROM $tblPosts LEFT JOIN $tblLikePost ON $tblLikePost.post_id = $tblPosts.ID 
                    WHERE $tblPosts.post_status = 'publish' AND $tblPosts.post_type = 'post' 
                        AND $tblPosts.ID IN ( SELECT DISTINCT $tbl_term_relationships.object_id FROM $tbl_term_relationships
                            WHERE $tbl_term_relationships.term_taxonomy_id IN ( 
                                SELECT DISTINCT $tbl_term_taxonomy.term_taxonomy_id FROM $tbl_term_taxonomy 
                                    WHERE $tbl_term_taxonomy.term_id = $catQA_ID AND $tbl_term_taxonomy.taxonomy = 'category' ) ) 
                    GROUP BY $tblPosts.ID, $tblPosts.post_title, $tblPosts.post_content, $tblPosts.post_author 
                    ORDER BY totalLiked DESC, $tblPosts.post_date DESC LIMIT 10";

                $results = $wpdb->get_results( $sql );

                foreach ($results as $postLike) :
                    $permalink = get_permalink($postLike->ID);
                    $thumbnail_id = get_post_meta($postLike->ID, "_thumbnail_id", true);
                    $image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
                    if($image_url[0] == ""){
                        $image_url[0] = get_bloginfo( 'stylesheet_directory' ) . "/images/no_image_available.jpg";
                    }
                    $content = "";
                    if($postLike->post_content != ""){
                        $content = get_short_content($postLike->post_content, 200);
                    }
                ?>
                <li>
                    <div class="thumb">
                        <a href="<?php echo $permalink; ?>" title="<?php echo $postLike->post_title; ?>">
                            <img alt="<?php echo $postLike->post_title; ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php echo $image_url[0]; ?>&w=80&h=48" />
                        </a>
                    </div>
                    <div class="title"><a href="<?php echo $permalink; ?>" title="<?php echo $postLike->post_title; ?>"><?php echo $postLike->post_title; ?></a></div>
                    <div class="clearfix"></div>
                    <div class="post-meta">
                        <span class="author">
                            <a href="<?php echo get_author_posts_url( $postLike->post_author ); ?>"><?php echo get_the_author_meta( 'display_name', $postLike->post_author ); ?> </a>
                        </span>
                        <span> - <?php echo get_the_time('d/m/Y', $postLike); ?></span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!--/#tab-most-like-->
    </div>
</div>