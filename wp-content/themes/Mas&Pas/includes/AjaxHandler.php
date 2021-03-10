<?php


class AjaxHandler
{
    public function __construct()
    {
        add_action('wp_ajax_search_post', [$this, 'handleSearch']);
    }

    public function handleSearch()
    {
        if (!empty($_POST['slug_input'])) {

            $response = [
                'message' => Helper::getPostFieldsBySlug($_POST['slug_input']),
            ];

            echo json_encode($response);
            wp_die();

        } else {

            $response = [
                'message' => '',
            ];
            echo json_encode($response);
            wp_die();
        }
    }
}
new AjaxHandler();
