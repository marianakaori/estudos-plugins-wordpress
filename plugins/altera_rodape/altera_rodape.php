<?php
/*
Plugin Name: Altera Rodapé
Description: Esta plugin altera o rodapé do blog (feito para estudo)
Version: 1.0
Author: Mariana Kaori
*/

function meuPluginAlteraRodape()
{
    echo "Meu primeiro plugin - Mariana";
}

add_action('wp_footer', 'meuPluginAlteraRodape');

add_action('init', 'myUserCheck');

function myUserCheck()
{
    if (is_user_logged_in()) {
        echo "<script> alert(1) </script>";
    }
}

add_filter('the_title', 'myFilteredTitle', 10, 2);

function myFilteredTitle($value)
{
    $value = '[***' . $value . '***]';
    return $value;
}