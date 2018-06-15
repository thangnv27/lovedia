<div class="r_box">
    <?php 
    global $shortname;
    $fbPage = get_option($shortname . '_fbPage'); 
    ?>
    <div class="fb-like-box" data-href="<?php echo ($fbPage == '') ? 'https://www.facebook.com/24khoteam' : $fbPage; ?>" data-width="220" data-height="320" data-show-faces="true" data-stream="false" data-show-border="true" data-header="false"></div>
</div>