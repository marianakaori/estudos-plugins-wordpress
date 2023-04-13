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