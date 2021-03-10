<?php
/*
Template Name: Infos Template
Template Post Type: infos
*/
?>

<?php get_header();?>


<div class="container pt-5 pb-5">
    <?php
        $slug = get_post_meta(get_the_ID(), 'slug_input', true);
        $selectField = get_post_meta(get_the_ID(), 'select_field', true);
        $postResult = Helper::getPostFieldsBySlug($slug);

        $postMeta = !empty($postResult) ? get_post_meta($postResult->ID) : [];
        $post = array_merge((array) $postResult, (array) $postMeta);

        $value = '';

        if (gettype($post[$selectField]) === 'array') {
            $value = $post[$selectField][0];
        } else {
            $value = $post[$selectField];
        }

    ?>
    <div><?php echo $value;?></div>

</div>

<?php get_footer();?>

