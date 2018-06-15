<?php
//include('includes/bbit-compress.php');
global $shortname;
$siteurl = get_bloginfo( 'siteurl' );
$stylesheet_directory = get_bloginfo('stylesheet_directory');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi-VN">
<head>
<meta http-equiv="cache-control" content="no-store" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="content-language" content="vi-VN"/>
<?php get_the_pages_title(); ?>
<meta name="robots" content="index, follow" /> 
<meta name="keywords" content="<?php echo get_option('keywords_meta'); ?>" />
<meta name="description" content="<?php echo get_option('description_meta'); ?>" />
<meta name="author" content="fotu.vn" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic|Roboto+Condensed:300italic,300,400,400italic,700,700italic&subset=latin,vietnamese' rel='stylesheet' type='text/css' />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $stylesheet_directory; ?>/css/wp-default.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $stylesheet_directory; ?>/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $stylesheet_directory; ?>/css/nivo-slider.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo $stylesheet_directory; ?>/css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $stylesheet_directory; ?>/css/upload.css" />

<script>
    var siteUrl = "<?php echo $siteurl; ?>";
    var themeUrl = "<?php echo $stylesheet_directory; ?>";
    //var loginUrl = "<?php echo wp_login_url(getCurrentRquestUrl() ); ?>";
    var loginUrl = "<?php echo get_page_link(get_option($shortname . '_pageLoginID')); ?>?redirect_to=<?php echo getCurrentRquestUrl(); ?>";
    var registerUrl = "<?php echo get_page_link(get_option($shortname . '_pageRegisterID')); ?>";
    var pageQAUrl = "<?php echo get_page_link(get_option($shortname . '_pageQAID')); ?>";
</script>
<script type="text/javascript" src="<?php echo $stylesheet_directory; ?>/js/jquery.min.js"></script>
<!--<script type="text/javascript" src="<?php echo $stylesheet_directory; ?>/js/jquery-1.9.1.js"></script>-->
<script type="text/javascript" src="<?php echo $stylesheet_directory; ?>/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $stylesheet_directory; ?>/js/jquery-scrolltofixed-min.js"></script>
<script type="text/javascript" src="<?php echo $stylesheet_directory; ?>/js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="<?php echo $stylesheet_directory; ?>/js/jquery.lightbox-0.5.js"></script>
<script type="text/javascript" src="<?php echo $stylesheet_directory; ?>/js/custom.js"></script>
<script type="text/javascript" src="<?php echo $stylesheet_directory; ?>/js/app.js"></script>

<?php if(get_the_ID() == intval(get_option($shortname . "_pagePostQAID"))): ?>
<!-- JavaScript Includes -->
<script src="<?php echo $stylesheet_directory; ?>/js/upload/jquery.knob.js"></script>

<!-- jQuery File Upload Dependencies -->
<script src="<?php echo $stylesheet_directory; ?>/js/upload/jquery.ui.widget.js"></script>
<script src="<?php echo $stylesheet_directory; ?>/js/upload/jquery.iframe-transport.js"></script>
<script src="<?php echo $stylesheet_directory; ?>/js/upload/jquery.fileupload.js"></script>

<!-- Our main JS file -->
<script src="<?php echo $stylesheet_directory; ?>/js/upload/script.js"></script>
<?php endif; ?>

<?php 
if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
wp_head();
?>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=691189397562749";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="wrapper">
    <div id="header">
        <div class="top-header">
            <div class="logo">
                <a href="<?php echo $siteurl; ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
                    <img src="<?php echo get_option('sitelogo'); ?>" alt="<?php bloginfo( 'name' ); ?>"/>
                </a>
            </div>
            <div class="head-right">
                <div class="toplinks">
                    <?php if(!isset($_SESSION['current_user_login'])): ?>
                    <a href="<?php echo get_page_link(get_option($shortname . '_pageLoginID')); ?>">Đăng nhập</a> | 
                    <a href="<?php echo get_page_link(get_option($shortname . '_pageRegisterID')); ?>">Đăng ký</a>
                    <?php else: 
                        global $current_user;
                        get_currentuserinfo();
                    ?>
                    Xin chào, <a href="<?php echo get_author_posts_url( $current_user->ID ); ?>" 
                                 style="color: #ff6633;"><?php echo $current_user->display_name; ?></a>
                    <?php endif; ?>
                </div>
                <div class="search-box">
                    <div class="date"><?php get_month_icon(); ?></div>
                    <div class="search-form">
                        <!--<form action="<?php echo $siteurl; ?>">
                            <input type="text" name="s" />
                            <input type="submit" value="" />
                        </form>-->
                        <?php include 'searchform.php'; ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!--/.top-header-->
        <div class="top-nav">
            <div class="menu-home <?php if(is_home()) echo 'active'; ?>">
                <a href="<?php echo $siteurl; ?>" title="Trang chủ">
                    <img src="<?php echo $stylesheet_directory; ?>/images/home.png" alt="<?php bloginfo( 'name' ); ?>" />
                </a>
            </div>
            <?php 
            $topMenu = wp_nav_menu(array(
                'menu' => 'Top Menu',
                'container' => '',
                'fallback_cb' => '__return_false'
            )); 
            if(!empty($topMenu)){
                echo $topMenu;
            }
            ?>
        </div>
        <!--/.top-nav-->
    </div>
