<?php


class Init
{
    public function __construct()
    {
        require_once 'includes/Helper.php';
        require_once 'includes/Cpt.php';
        if( wp_doing_ajax() ) {
            require_once 'includes/AjaxHandler.php';
        }

        add_action( 'admin_enqueue_scripts', [$this, 'loadScriptAndStyles'], 10, 1 );
    }

    public function loadScriptAndStyles($hook)
    {
        global $post;

        if ($hook == 'post-new.php' || $hook == 'post.php') {
            if ($post->post_type === 'infos') {
                wp_enqueue_style( 'mas&pas_css', get_template_directory_uri() . '/css/admin.css',false,'1.1','all');
                wp_enqueue_script( 'mas&pas_js', get_stylesheet_directory_uri().'/js/admin.js', ['jquery'], '1.0.0', true );
            }
        }
    }

}

new Init();
