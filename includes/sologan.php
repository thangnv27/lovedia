<?php

# Custom sologan post type
add_action('init', 'create_sologan_post_type');

function create_sologan_post_type(){
    $args = array(
        'labels' => array(
            'name' => __('Sologans'),
            'singular_name' => __('Sologans'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Sologan'),
            'new_item' => __('New Sologan'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Sologan'),
            'view' => __('View Sologan'),
            'view_item' => __('View Sologan'),
            'search_items' => __('Search Sologans'),
            'not_found' => __('No Sologan found'),
            'not_found_in_trash' => __('No Sologan found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 20,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 
            //'editor', 'comments', 'excerpt', 'thumbnail', 'custom-fields'
        ),
        'rewrite' => array('slug' => 'sologan', 'with_front' => false),
        'can_export' => true,
        'description' => __('Sologan description here.')
    );
    
    register_post_type('sologan', $args);
}

# Custom sologan taxonomies
/*add_action('init', 'create_sologan_taxonomies');

function create_sologan_taxonomies(){
    register_taxonomy('sologan_category', 'sologan', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Sologan Categories'),
            'singular_name' => __('Sologan Categories'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Category'),
            'new_item' => __('New Category'),
            'search_items' => __('Search Categories'),
        ),
    ));
}*/

# sologan meta box
$sologan_meta_box = array(
    'id' => 'sologan-meta-box',
    'title' => 'Thông tin',
    'page' => 'sologan',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Tác giả',
            'desc' => '',
            'id' => 'sologan_author',
            'type' => 'text',
            'std' => '',
        ),
));

// Add sologan meta box
add_action('admin_menu', 'sologan_add_box');
add_action('save_post', 'sologan_add_box');
add_action('save_post', 'sologan_save_data');

function sologan_add_box(){
    global $sologan_meta_box;
    add_meta_box($sologan_meta_box['id'], $sologan_meta_box['title'], 'sologan_show_box', $sologan_meta_box['page'], $sologan_meta_box['context'], $sologan_meta_box['priority']);
}

// Callback function to show fields in sologan meta box
function sologan_show_box() {
    // Use nonce for verification
    global $sologan_meta_box, $post;

    custom_output_meta_box($sologan_meta_box, $post);
}

// Save data from sologan meta box
function sologan_save_data($post_id) {
    global $sologan_meta_box;
    
    custom_save_meta_box($sologan_meta_box, $post_id);
}
