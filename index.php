<?php get_header(); ?>

<?php 
global $shortname;
$catQAID = array(); 
array_push($catQAID, intval(get_option( $shortname . '_catQAID')));
?>

<div id="top_content">
    <script type="text/javascript">
        $(function(){
            TSlider.home();
        });
    </script>
    <div id="main_slider">
        <?php
        $slider = new WP_Query(array(
                'post_type' => array('post', 'page'),
                'posts_per_page' => 5,
                'category__not_in' => $catQAID,
                'meta_query' => array(
                    array(
                        'key' => 'is_most',
                        'value' => '1',
                    )
                ),
            ));
        ?>
        <div id="home_slider" class="nivoSlider">
            <?php while($slider->have_posts()) : $slider->the_post(); ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=600&h=360" 
                     data-thumb="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=120&h=72" 
                     alt="<?php the_title(); ?>" title="#htmlcaption-<?php the_ID(); ?>" />
            </a>
            <?php endwhile; ?>
        </div>
        <?php while($slider->have_posts()) : $slider->the_post(); ?>
        <div id="htmlcaption-<?php the_ID(); ?>" class="nivo-html-caption">
            <a href="<?php the_permalink(); ?>">
                <span class="title"><?php the_title(); ?></span>
                <span class="description"><?php echo get_short_content(get_the_content(''), 300); ?></span>
            </a>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
        <div class="clearfix"></div>
    </div>
    <div class="hot-post">
        <?php
        $hotPostID = intval(get_option($shortname . '_postHotID'));
        if($hotPostID > 0):
            $post = get_post($hotPostID);
            $permalink = get_permalink($hotPostID);
            $thumbnail_id = get_post_meta($hotPostID, "_thumbnail_id", true);
            $image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
            if($image_url[0] == ""){
                $image_url[0] = get_bloginfo( 'stylesheet_directory' ) . "/images/no_image_available.jpg";
            }
        ?>
        <div class="thumb">
            <a href="<?php echo $permalink; ?>" title="<?php echo $post->post_title; ?>">
                <img alt="<?php echo $post->post_title; ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php echo $image_url[0]; ?>&w=220&h=132" />
            </a>
        </div>
        <div class="content">
            <h2 class="title">
                <a href="<?php echo $permalink; ?>" title="<?php echo $post->post_title; ?>"><?php echo $post->post_title; ?></a>
                <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
            </h2>
            <div class="description"><?php echo get_short_content(strip_tags($post->post_content), 330); ?></div>
        </div>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>
</div>
<!--/#top_content-->

<div id="tabs_news">
    <ul class="tabs-news">
        <li><a href="#tab-top-new">Mới nhất</a></li>
        <li><a href="#tab-top-reading">Đọc nhiều nhất</a></li>
        <li><a href="#tab-top-like">Ưa thích nhất</a></li>
    </ul>
    <div id="tab-top-new" class="tab-news">
        <?php
        query_posts(array(
            'post_type' => 'post',
            'posts_per_page' => 4,
            'category__not_in' => $catQAID,
        ));
        while(have_posts()) : the_post();
        ?>
        <div class="item">
            <div class="thumb">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=235&h=141" />
                </a>
            </div>
            <div class="content">
                <div class="title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </div>
                <div class="post-meta">
                    <span class="author"><?php the_author_posts_link(); ?></span>
                    <span> - <?php the_time('d/m/Y'); ?></span>
                    <span> - <?php get_like_count(); ?></span>
                    <span> - <?php get_views_count(); ?></span>
                    <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                </div>
                <div class="description"><?php echo get_short_content(get_the_content(''), 170); ?></div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
        <div class="clearfix"></div>
    </div>
    <!--/#tab-top-new-->
    <div id="tab-top-reading" class="tab-news">
        <?php
        query_posts(array(
            'post_type' => 'post',
            'posts_per_page' => 4,
            'category__not_in' => $catQAID,
            'orderby' => 'meta_value_num', 
            'meta_key' => 'views',
            'order' => 'DESC',
        ));
        while(have_posts()) : the_post();
        ?>
        <div class="item">
            <div class="thumb">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=235&h=141" />
                </a>
            </div>
            <div class="content">
                <div class="title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </div>
                <div class="post-meta">
                    <span class="author"><?php the_author_posts_link(); ?></span>
                    <span> - <?php the_time('d/m/Y'); ?></span>
                    <span> - <?php get_like_count(); ?></span>
                    <span> - <?php get_views_count(); ?></span>
                    <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                </div>
                <div class="description"><?php echo get_short_content(get_the_content(''), 170); ?></div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
        <div class="clearfix"></div>
    </div>
    <!--/#tab-top-reading-->
    <div id="tab-top-like" class="tab-news">
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
                                WHERE $tbl_term_taxonomy.term_id <> $catQA_ID AND $tbl_term_taxonomy.taxonomy = 'category' ) ) 
                GROUP BY $tblPosts.ID, $tblPosts.post_title, $tblPosts.post_content, $tblPosts.post_author 
                ORDER BY totalLiked DESC, $tblPosts.post_date DESC LIMIT 4";
        
        $results = $wpdb->get_results( $sql );
        
        if(count($results) > 0):
        foreach ($results as $postLike) :
            $permalink = get_permalink($postLike->ID);
            $thumbnail_id = get_post_meta($postLike->ID, "_thumbnail_id", true);
            $image_url = wp_get_attachment_image_src($thumbnail_id, 'full');
            if($image_url[0] == ""){
                $image_url[0] = get_bloginfo( 'stylesheet_directory' ) . "/images/no_image_available.jpg";
            }
            $content = "";
            if($postLike->post_content != ""){
                $content = get_short_content($postLike->post_content, 170);
            }
        ?>
        <div class="item">
            <div class="thumb">
                <a href="<?php echo $permalink; ?>" title="<?php echo $postLike->post_title; ?>">
                    <img alt="<?php echo $postLike->post_title; ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php echo $image_url[0]; ?>&w=235&h=141" />
                </a>
            </div>
            <div class="content">
                <div class="title">
                    <a href="<?php echo $permalink; ?>" title="<?php echo $postLike->post_title; ?>"><?php echo $postLike->post_title; ?></a>
                </div>
                <div class="post-meta">
                    <span class="author"><a rel="author" title="Posts by <?php the_author_meta( 'display_name', $postLike->post_author ); ?> " href="<?php echo get_author_posts_url($postLike->post_author); ?>">
                             <?php the_author_meta( 'display_name', $postLike->post_author ); ?> 
                        </a></span>
                    <span> - <?php echo  get_the_time( 'd/m/Y', $postLike ); ?></span>
                    <span> - <?php get_like_count($postLike); ?></span>
                    <span> - <?php get_views_count($postLike); ?></span>
                    <?php if(isset($_SESSION['current_user_login'])): ?>
                    <span> - <a title="Edit Post" href="<?php echo get_edit_post_link($postLike->ID); ?>" class="post-edit-link">Edit</a></span>
                    <?php endif; ?>
                </div>
                <div class="description"><?php echo $content; ?></div>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="clearfix"></div>
        <?php endif; ?>
    </div>
    <!--/#tab-top-like-->
</div>
<!--/#tabs_news-->

<!--Block quote main-->
<div id="block_quote">
    <div class="sologan">
        <?php
        $loop = new WP_Query(array(
            'post_type' => 'sologan',
            'posts_per_page' => 1,
            'orderby' => 'rand',
        ));
        while($loop->have_posts()) : $loop->the_post();
        ?>
        <div class="content"><?php the_title(); ?></div>
        <div class="author">- <?php echo get_post_meta(get_the_ID(), "sologan_author", true); ?></div>
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>
    </div>
    <?php $fbPage = get_option($shortname . '_fbPage'); ?>
    <div class="fb-like-box" data-href="<?php echo ($fbPage == '') ? 'https://www.facebook.com/24khoteam' : $fbPage; ?>" data-width="220" data-height="110" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
    <div class="clearfix"></div>
</div>
<!--/Block quote main-->

<div id="home_main">
    <div id="home_block_first">
        <div class="blocks-news">
            <?php
            $boxArr = json_decode(get_option('cat_box1'));
            if(count($boxArr) > 0):
            $args = array(
                'hide_empty' => 0,
                'include' => implode(",", $boxArr),
            );
            $categories = get_categories( $args );
            foreach ($categories as $key => $category) :
                if($key % 2 == 0):
            ?>
            <div class="block mr20">
                <?php else: ?>
            <div class="block">
                <?php endif; ?>
                <div class="block-title"><a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></div>
                <div class="block-links">
                    <?php
                    $catChilds = get_categories(array(
                        'child_of' => $category->term_id,
                        'hide_empty' => false,
                        'number' => '3',
                    ));
                    foreach ($catChilds as $k => $child) :
                        $catLink = get_category_link($child->term_id);
                        if($k == 0 and $k != count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdl0\">{$child->name}</a> | ";
                        }elseif($k == 0 and $k == count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdl0 pdr0\">{$child->name}</a>";
                        }elseif($k == count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdr0\">{$child->name}</a>";
                        }else{
                            echo "<a href=\"{$catLink}\">{$child->name}</a> | ";
                        }
                    endforeach; ?>
                </div>
                <div class="block-content">
                    <?php
                    $loop = new WP_Query(array(
                        'post_type' => 'post',
                        'cat' => $category->term_id,
                        'posts_per_page' => 4,
                    ));
                    if($loop->post_count > 0):
                    $counter = 1;
                    while($loop->have_posts()) : $loop->the_post();
                        if($counter == 1):
                        $content = get_short_content(get_the_content(''), 250);
                    ?>
                    <div class="first">
                        <div class="thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=132" />
                            </a>
                        </div>
                        <h3 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-meta">
                            <span class="author"><?php the_author_posts_link(); ?></span>
                            <span class="date"> - <?php the_time('d/m/Y'); ?></span>
                            <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                        </div>
                        <div class="description"><?php echo $content; ?></div>
                    </div>
                    <div class="second">
                        <ul>
                            <?php else: ?>
                            <li>
                                <div class="thumb">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=110&h=66" />
                                    </a>
                                </div>
                                <div class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                                <div class="clearfix"></div>
                                <div class="post-meta">
                                    <span class="author"><?php the_author_posts_link(); ?></span>
                                    <span class="date"> - <?php the_time('d/m/Y'); ?></span>
                                    <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php $counter++; endwhile;?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <?php endif; ?>
                <?php wp_reset_query(); ?>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
            
            <div class="clearfix"></div>
        </div>
        <!--/.blocks-news-->
    </div>
    <!--/#home_block_first-->
    
    <!--Ad block first-->
    <div id="ad_home_block">
        <div class="ad_home_category fl mr20">
            <?php echo stripslashes(get_option('ad_home_category')); ?>
        </div>
        <div class="ad_home_category fr">
            <?php echo stripslashes(get_option('ad_home_category2')); ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <!--/Ad block first-->
    
    <div class="mainLeft">
        <div class="blocks-news">
            <?php
            $boxArr = json_decode(get_option('cat_box3'));
            if(count($boxArr) > 0):
            $args = array(
                'hide_empty' => 0,
                'include' => implode(",", $boxArr),
            );
            $categories = get_categories( $args );
            foreach ($categories as $category) :
            ?>
            <div class="block">
                <div class="block-title"><a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></div>
                <div class="block-links">
                    <?php
                    $catChilds = get_categories(array(
                        'child_of' => $category->term_id,
                        'hide_empty' => false,
                        'number' => '3',
                    ));
                    foreach ($catChilds as $k => $child) :
                        $catLink = get_category_link($child->term_id);
                        if($k == 0 and $k != count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdl0\">{$child->name}</a> | ";
                        }elseif($k == 0 and $k == count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdl0 pdr0\">{$child->name}</a>";
                        }elseif($k == count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdr0\">{$child->name}</a>";
                        }else{
                            echo "<a href=\"{$catLink}\">{$child->name}</a> | ";
                        }
                    endforeach; ?>
                </div>
                <div class="block-content">
                    <?php
                    $loop = new WP_Query(array(
                        'post_type' => 'post',
                        'cat' => $category->term_id,
                        'posts_per_page' => 4,
                    ));
                    if($loop->post_count > 0):
                    $counter = 1;
                    while($loop->have_posts()) : $loop->the_post();
                        if($counter == 1):
                        $content = get_short_content(get_the_content(''), 250);
                    ?>
                    <div class="first">
                        <div class="thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=132" />
                            </a>
                        </div>
                        <h3 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-meta">
                            <span class="author"><?php the_author_posts_link(); ?></span>
                            <span class="date"> - <?php the_time('d/m/Y'); ?></span>
                            <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                        </div>
                        <div class="description"><?php echo $content; ?></div>
                    </div>
                    <div class="second">
                        <ul>
                            <?php else: ?>
                            <li>
                                <div class="thumb">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=110&h=66" />
                                    </a>
                                </div>
                                <div class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                                <div class="clearfix"></div>
                                <div class="post-meta">
                                    <span class="author"><?php the_author_posts_link(); ?></span>
                                    <span class="date"> - <?php the_time('d/m/Y'); ?></span>
                                    <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php $counter++; endwhile;?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <?php endif; ?>
                <?php wp_reset_query(); ?>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!--/.blocks-news-->
    </div>
    <!--/.mainLeft-->
    
    <div class="mainRight">
        <div class="blocks-news">
            <?php
            $boxArr = json_decode(get_option('cat_box4'));
            if(count($boxArr) > 0):
            $args = array(
                'hide_empty' => 0,
                'include' => implode(",", $boxArr),
            );
            $categories = get_categories( $args );
            foreach ($categories as $category) :
            ?>
            <div class="block">
                <div class="block-title"><a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></div>
                <div class="block-links">
                    <?php
                    $catChilds = get_categories(array(
                        'child_of' => $category->term_id,
                        'hide_empty' => false,
                        'number' => '3',
                    ));
                    foreach ($catChilds as $k => $child) :
                        $catLink = get_category_link($child->term_id);
                        if($k == 0 and $k != count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdl0\">{$child->name}</a> | ";
                        }elseif($k == 0 and $k == count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdl0 pdr0\">{$child->name}</a>";
                        }elseif($k == count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdr0\">{$child->name}</a>";
                        }else{
                            echo "<a href=\"{$catLink}\">{$child->name}</a> | ";
                        }
                    endforeach; ?>
                </div>
                <div class="block-content">
                    <?php
                    $loop = new WP_Query(array(
                        'post_type' => 'post',
                        'cat' => $category->term_id,
                        'posts_per_page' => 4,
                    ));
                    if($loop->post_count > 0):
                    $counter = 1;
                    while($loop->have_posts()) : $loop->the_post();
                        if($counter == 1):
                        $content = get_short_content(get_the_content(''), 250);
                    ?>
                    <div class="first">
                        <div class="thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220&h=132" />
                            </a>
                        </div>
                        <h3 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-meta">
                            <span class="author"><?php the_author_posts_link(); ?></span>
                            <span class="date"> - <?php the_time('d/m/Y'); ?></span>
                            <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                        </div>
                        <div class="description"><?php echo $content; ?></div>
                    </div>
                    <div class="second">
                        <ul>
                            <?php else: ?>
                            <li>
                                <div class="thumb">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=110&h=66" />
                                    </a>
                                </div>
                                <div class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
                                <div class="clearfix"></div>
                                <div class="post-meta">
                                    <span class="author"><?php the_author_posts_link(); ?></span>
                                    <span class="date"> - <?php the_time('d/m/Y'); ?></span>
                                    <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php $counter++; endwhile;?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <?php endif; ?>
                <?php wp_reset_query(); ?>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!--/.blocks-news-->
    </div>
    <!--/.mainRight-->
    <div class="clearfix"></div>
    
    <div class="mainLeft">
        <div class="blocks-news">
            <?php
            $boxArr = json_decode(get_option('cat_box5'));
            if(count($boxArr) > 0):
            $args = array(
                'hide_empty' => 0,
                'include' => implode(",", $boxArr),
            );
            $categories = get_categories( $args );
            foreach ($categories as $category) :
            ?>
            <div class="block2">
                <div class="block-title"><a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></div>
                <div class="block-content">
                    <?php
                    $loop = new WP_Query(array(
                        'post_type' => 'post',
                        'cat' => $category->term_id,
                        'posts_per_page' => 5,
                    ));
                    if($loop->post_count > 0):
                    $counter = 1;
                    while($loop->have_posts()) : $loop->the_post();
                        if($counter == 1):
                        $content = get_short_content(get_the_content(''), 300);
                    ?>
                    <div class="first">
                        <div class="thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=460" />
                            </a>
                        </div>
                        <h3 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-meta">
                            <span class="author"><?php the_author_posts_link(); ?></span>
                            <span class="date"> - <?php the_time('d/m/Y'); ?></span>
                            <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                        </div>
                        <div class="description"><?php echo $content; ?></div>
                    </div>
                    <div class="second">
                        <ul>
                            <?php else: ?>
                            <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                            <?php endif; ?>
                            <?php $counter++; endwhile;?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!--/.blocks-news-->
    </div>
    <!--/.mainLeft-->
    
    <div class="mainRight">
        <div class="blocks-news">
            <?php
            $boxArr = json_decode(get_option('cat_box6'));
            if(count($boxArr) > 0):
            $args = array(
                'hide_empty' => 0,
                'include' => implode(",", $boxArr),
            );
            $categories = get_categories( $args );
            foreach ($categories as $category) :
            ?>
            <div class="block3">
                <div class="block-title"><a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></div>
                <div class="block-links">
                    <?php
                    $catChilds = get_categories(array(
                        'child_of' => $category->term_id,
                        'hide_empty' => false,
                        'number' => '3',
                    ));
                    foreach ($catChilds as $k => $child) :
                        $catLink = get_category_link($child->term_id);
                        if($k == 0 and $k != count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdl0\">{$child->name}</a> | ";
                        }elseif($k == 0 and $k == count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdl0 pdr0\">{$child->name}</a>";
                        }elseif($k == count($catChilds) - 1){
                            echo "<a href=\"{$catLink}\" class=\"pdr0\">{$child->name}</a>";
                        }else{
                            echo "<a href=\"{$catLink}\">{$child->name}</a> | ";
                        }
                    endforeach; ?>
                </div>
                <div class="block-content">
                    <?php
                    $loop = new WP_Query(array(
                        'post_type' => 'post',
                        'cat' => $category->term_id,
                        'posts_per_page' => 4,
                    ));
                    if($loop->post_count > 0):
                    $counter = 1;
                    while($loop->have_posts()) : $loop->the_post();
                        if($counter == 1):
                        $content = get_short_content(get_the_content(''), 250);
                    ?>
                    <div class="first">
                        <div class="thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <img alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=220" />
                            </a>
                        </div>
                        <h3 class="title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        <div class="post-meta">
                            <span class="author"><?php the_author_posts_link(); ?></span>
                            <span class="date"> - <?php the_time('d/m/Y'); ?></span>
                            <span><?php edit_post_link('Edit', ' - ', ''); ?></span>
                        </div>
                        <div class="description"><?php echo $content; ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="second">
                        <ul>
                            <?php else: ?>
                            <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                            <?php endif; ?>
                            <?php $counter++; endwhile;?>
                        </ul>
                    </div>
                    <?php endif;
                    wp_reset_query(); ?>
                </div>
            </div>
            <?php endforeach; 
            endif; ?>
        </div>
        <!--/.blocks-news-->
    </div>
    <!--/.mainRight-->
    <div class="clearfix"></div>
    
</div>
<!--/#home_main-->

<!--Ad above footer-->
<div id="ad_above_footer"><?php echo stripslashes(get_option('ad_above_footer')); ?></div>
<!--/Ad above footer-->

<?php get_footer(); ?>
