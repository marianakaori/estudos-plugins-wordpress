<?php

function nsAddScripts()
{
    wp_enqueue_style('ns-main-style', plugins_url().'/newsletter-curso/css/style.css');
    wp_enqueue_script('ns-main-script', plugins_url().'/newsletter-curso/js/main.js', array('jquery'));
}

add_action('wp_enqueue_scripts', 'nsAddScripts');