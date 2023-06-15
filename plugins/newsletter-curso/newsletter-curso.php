<?php
/*
Plugin Name: Newsletter Curso
Description: Plugin de newsletter (feito para estudo)
Version: 1.0
Author: Mariana Kaori
Text Domain: newsletter-curso
*/

if (!defined('ABSPATH')) { header('Location:http://localhost/wordpress'); }

// load scripts
require_once(plugin_dir_path(__FILE__).'includes/newsletter-scripts.php');

// load Class
require_once(plugin_dir_path(__FILE__).'includes/newsletter-curso-class.php');

// register widget
function registerNewsletterCurso()
{
    register_widget('NewsletterCursoWidget');
}

add_action('widgets_init', 'registerNewsletterCurso');