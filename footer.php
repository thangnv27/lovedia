    <div id="footer">
        <div class="info">
            <div class="footer_column1">
                <div class="logo_footer">
                    <a href="<?php bloginfo( 'siteurl' ); ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
                        <img src="<?php echo get_option('logo_footer'); ?>" alt="<?php bloginfo( 'name' ); ?>"/>
                    </a>
                </div>
                <?php global $shortname; ?>
                <div class="contact">Liên hệ: <?php echo get_option($shortname . '_emailContact'); ?></div>
                <div class="follow_us">
                    <span class="fl">Follow us</span>
                    <span class="fr social">
                        <a href="<?php echo get_option($shortname . '_fbURL'); ?>" class="fb_icon"></a>
                        <a href="<?php echo get_option($shortname . '_twitterURL'); ?>" class="tw_icon"></a>
                        <a href="<?php echo get_option($shortname . '_googleURL'); ?>" class="google_icon"></a>
                    </span>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="footer_column">
                <?php if (function_exists('dynamic_sidebar') and dynamic_sidebar('Footer Column 1')): ?><?php else: ?><?php endif; ?>
            </div>
            <div class="footer_column">
                <?php if (function_exists('dynamic_sidebar') and dynamic_sidebar('Footer Column 2')): ?><?php else: ?><?php endif; ?>
            </div>
            <div class="footer_column" style="border-right: none; width: 219px; padding-right: 0;">
                <?php if (function_exists('dynamic_sidebar') and dynamic_sidebar('Footer Column 3')): ?><?php else: ?><?php endif; ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="copyright">Copyright © 2013 Lovedia. All rights reserved.</div>
    </div>
</div>
<!--/.wrapper-->
 
<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>

<?php wp_footer(); ?>
<!--/Coded by Ngo Van Thang, ngothangit@gmail.com, http://ngovanthang.info-->
</body>
</html>