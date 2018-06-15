<?php get_header(); ?>

<div class="categories">
    <span class="page-title">Q&A</span>
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
        
        <div class="post_bar">
            <div class="like-post">
                <div class="fb-like" data-href="<?php echo getCurrentRquestUrl(); ?>" data-layout="button_count" data-show-faces="false" data-send="true"></div>
                <div class="inline ml10"><g:plusone></g:plusone></div>
                <?php //linkhay_button(1); ?>
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
                <div class="clearfix"></div>
            </div>
            <div class="nav-control">
                <div id="prev_post">
                    <?php next_post_link('%link', '', true); ?>
                    <?php //next_post('%', '', 'no', 'yes'); ?>
                </div>
                <div id="next_post">
                    <?php previous_post_link('%link', '', TRUE); ?> 
                    <?php //previous_post('%', '', 'no', 'yes'); ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        
        <div class="post-content">
            <img src="<?php get_image_url(); ?>" alt="<?php the_title(); ?>" class="mb10" />
            <?php the_content(); ?>
        </div>
        
        <?php if (get_the_tags()): ?>
        <div class="post_tags"><?php the_tags( '<b>Tags: </b>', ', ', ''); ?></div>
        <?php endif; ?>
    </div>
    <!--/.post-->
    <div class="comment_box mt10">
        <h3 class="title">Bình luận</h3>
        <div class="comment_box_ct">
            <div class="fb-comments" data-href="<?php echo getCurrentRquestUrl(); ?>" data-width="695" data-num-posts="10"></div>
        </div>
    </div>
    <?php endwhile;?>
</div>
<!--/#post_main-->

<script type="text/javascript">
    $(function(){
        FixedColumn.singleQA();
        
        $(window).load(function(){
            $("#post_main .post .watch-action .watch-position")
            .removeClass('align-left')
            .addClass('fr').css({
                'margin-top': '-23px'
            })
            .appendTo("#post_main .post_bar .like-post");
        });
        
        // Handling shortcuts keys
        jQuery(document).keyup(function(e){
            switch(e.keyCode){
                case 37:
                    if($("#prev_post a").length > 0){
                        $("#prev_post").addClass('active');
                        window.location = $("#prev_post a").attr('href');
                    }
                    break;
                case 39:
                    if($("#next_post a").length > 0){
                        $("#next_post").addClass('active');
                        window.location = $("#next_post a").attr('href');
                    }
                    break;
                default:
                    break;
            }
        });
    });
</script>

<?php get_sidebar('qa'); ?>
<div class="clearfix"></div>

<?php get_footer(); ?>
