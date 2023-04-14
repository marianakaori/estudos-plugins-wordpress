<?php
/*
Plugin Name: Personalizar Painel
Description: Esta plugin foi feito para personalizar o painel (feito para estudo)
Version: 1.0
Author: Mariana Kaori
*/

class SegundoPlugin
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
    }

    private function __construct()
    {
        //Desativar a action welcome_panel
        add_action('admin_init', 'hideWelcomePanel');

        function hideWelcomePanel()
        {
            remove_action('welcome_panel', 'wp_welcome_panel');
        }

        add_action('welcome_panel', array($this, 'welcomePanel'));
        add_action('admin_enqueue_scripts', array($this, 'addCss'));
    }

    public function welcomePanel()
    {
        ?>
            <div class="welcome-panel-content">
                <h1>Seja bem-vindo ao painel administrativo</h1>
                <p>Siga-nos nas redes sociais</p>
                <div id="icons">
                    <a href="#" target="_blank">
                        <img src="http://localhost/wordpress/wp-content/uploads/2023/04/012-1474968150_facebook_circle_color.png">
                    </a>
                    <a href="#" target="_blank">
                        <img src="http://localhost/wordpress/wp-content/uploads/2023/04/012-1474968161_youtube_circle_color.png">
                    </a>
                </div>
            </div>
        <?php
    }

    public function addCss()
    {
        wp_register_style('meu-segundo-plugin', plugin_dir_url(__FILE__).'css/meu-segundo-plugin.css');
        wp_enqueue_style('meu-segundo-plugin');
    }

}

SegundoPlugin::getInstance();