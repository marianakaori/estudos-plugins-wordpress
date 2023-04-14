<?php

/*
Plugin Name: Review de Filmes
Description: Plugin para review de filmes (feito para estudo)
Version: 1.0
Author: Mariana Kaori
*/

use function PHPSTORM_META\map;

class FilmesReviews
{
    private static $instance;
    
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('init', 'FilmesReviews::registerPostType');
    }

    public static function registerPostType()
    {
        register_post_type('filmes_reviews', array(
            'labels' => array(
                'name' => 'Filmes Reviews',
                'singular_name' => 'Filme Review'
            ),
            'description' => 'Post para cadastro de reviews de filmes.',
            'supports' => array(
                'title', 'editor', 'excerpt', 'author', 'revisions', 'thumbnail', 'custom-fields',
            ),
            'public' => true,
            'menu_icon' => 'dashicons-format-video',
            'menu_position' => 4,
        ));
    }

    public static function activate()
    {
        self::registerPostType();
        flush_rewrite_rules();
    }
}

FilmesReviews::getInstance();

register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
register_activation_hook(__FILE__, 'FilmesReviews::activate');