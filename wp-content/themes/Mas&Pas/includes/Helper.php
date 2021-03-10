<?php


class Helper
{
    public static function getPostFieldsBySlug($postSlug): array
    {
        $postResult = get_posts([
            'name' => $postSlug,
            'post_type'   => 'post',
            'post_status' => 'publish',
            'numberposts' => 1
        ]);

        $postMeta = !empty($postResult) ? get_post_meta($postResult[0]->ID) : [];
        return array_merge((array) $postResult[0], (array) $postMeta);
    }
}
