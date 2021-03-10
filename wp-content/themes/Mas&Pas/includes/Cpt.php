<?php

class Cpt
{
    public function __construct()
    {
        add_action('init', [$this, 'createPostType']);
        add_action('add_meta_boxes', [$this, 'addMetaBoxes']);
        add_action('wp_insert_post_data', [$this, 'saveMetaBoxData'], 10, 2);
    }

    public function createPostType()
    {
        $labels = array(
            'name' => _x('Infos', 'Post Type General Name', 'mas&pas'),
            'singular_name' => _x('Info', 'Post Type Singular Name', 'mas&pas'),
            'menu_name' => __('Infos', 'mas&pas'),
            'parent_item_colon' => __('Parent Info', 'mas&pas'),
            'all_items' => __('All Infos', 'mas&pas'),
            'view_item' => __('View Info', 'mas&pas'),
            'add_new_item' => __('Add New Info', 'mas&pas'),
            'add_new' => __('Add New', 'mas&pas'),
            'edit_item' => __('Edit Info', 'mas&pas'),
            'update_item' => __('Update Info', 'mas&pas'),
            'search_items' => __('Search Info', 'mas&pas'),
            'not_found' => __('Not Found', 'mas&pas'),
            'not_found_in_trash' => __('Not found in Trash', 'mas&pas'),
        );

        $args = array(
            'label' => __('infos', 'mas&pas'),
            'description' => __('Info', 'mas&pas'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'page-attributes'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'post',
            'show_in_rest' => false,
        );

        register_post_type('infos', $args);
        flush_rewrite_rules();
    }

    public function addMetaBoxes()
    {
        add_meta_box(
            'slug-field-inputs',
            __('Inputs', 'mas&pas'),
            [$this, 'addMetaBoxesHTML'],
            'infos'
        );
    }

    public function addMetaBoxesHTML($post)
    {
        $slug = get_post_meta($post->ID, 'slug_input', true);
        $field = get_post_meta($post->ID, 'select_field', true);
        $options = [];

        if (!empty($slug)) {
            $options = Helper::getPostFieldsBySlug($slug);
        }

        ?>
        <div class="container">
            <div class="item">
                <label for="slug_input">
                    <?php _e('Slug Input', 'mas&pas'); ?>
                </label>
                <input type="text" id="slug_input" name="slug_input" value="<?php echo esc_attr($slug) ?>" size="25"/>
            </div>
            <div class="item">
                <label for="slug_field">
                    <?php _e('Select', 'mas&pas'); ?>
                </label>
                <select id="select_field" name="select_field">
                    <option value="">Empty</option>
                    <?php

                    if (!empty($options)) {
                        foreach ($options as $key => $value): ?>
                            <option value="<?php echo $key; ?>"
                            <?php selected($key, $field, true); ?>
                            ><?php echo $key; ?></option>
                        <?php endforeach;
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php
    }

    public function saveMetaBoxData($data, $post)
    {
        if ($post['post_type'] === 'infos') {
            if (isset($post['slug_input'])) {
                update_post_meta($post['ID'], 'slug_input', sanitize_text_field($post['slug_input']));
            }

            if (isset($post['select_field'])) {
                update_post_meta($post['ID'], 'select_field', sanitize_text_field($post['select_field']));
            }
        }
        return $data;
    }
}

new CPT();
