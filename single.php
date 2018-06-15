<?php
global $shortname;
$catQAID = intval(get_option( $shortname . '_catQAID'));

$post = $wp_query->post;

if (in_category($catQAID)) {
    include(TEMPLATEPATH . '/single_qa.php');
} else {
    include(TEMPLATEPATH . '/single_default.php');
}
?>