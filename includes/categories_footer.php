<?php

/**
 * Display category list on footer
 *
 * @author Ngo Van Thang
 * @link http://ngovanthang.info 
 */
class Categories_Footer extends WP_Widget {

    function Categories_Footer() {
        parent::WP_Widget('Categories_Footer_Widget', 'Categories Footer', array('description' => ''));
    }

    function widget($args, $instance) {
        extract($args);
        $category_id = apply_filters('widget_category_id', $instance['category_id'], $instance, $this->id_base);
        $title = apply_filters('widget_title', $instance['title'], $instance);
        $parentLink = get_category_link($category_id);
        echo $before_widget;
        echo $before_title;
        echo "<a href=\"{$parentLink}\">{$title}</a>";
        echo $after_title;
        $categories = get_categories(array(
                        'child_of' => $category_id,
                        'hide_empty' => false,
                        'number' => '3',
                    ));
        if(count($categories) > 0):
            echo "<ul>";
            foreach ($categories as $category) {
                $catLink = get_category_link($category->term_id);
                echo <<<HTML
                <li><a href="{$catLink}" title="{$category->name}">{$category->name}</a></li>
HTML;
            }
            echo "</ul>";
        endif;
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['category_id'] = $new_instance['category_id'];
        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'category_id' => ''));
        $title = format_to_edit($instance['title']);
        $category_id = esc_attr($instance['category_id']);
        $categories = get_categories(array('hide_empty' => false));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tiêu đề:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category_id'); ?>"><?php _e('Select a category:'); ?></label>
            <select name="<?php echo $this->get_field_name('category_id'); ?>" 
                    id="<?php echo $this->get_field_id('category_id'); ?>">
                <?php
                foreach ($categories as $category) {
                    if($category_id == $category->term_id){
                        echo "<option value=\"$category->term_id\" selected=\"selected\">{$category->name}</option>";
                    }else{
                        echo "<option value=\"$category->term_id\">{$category->name}</option>";
                    }
                }
                ?>
            </select>
        </p>
<?php
    }

}

register_widget('Categories_Footer');
