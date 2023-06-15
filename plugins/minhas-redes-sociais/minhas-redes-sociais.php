<?php
/*
Plugin Name: Minhas Redes Sociais
Description: Plugin desenvolvido para exibir as minhas redes sociais (feito para estudos)
Version: 1.0
Author: Mariana Kaori
Text Domain: minhas-redes-sociais
*/

require_once(dirname(__FILE__).'/widgets/meu-widget.php');
class MinhasRedes
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
        add_action('widgets_init', array($this, 'registerWidgets'));
    }

    public function registerWidgets()
    {
        register_widget('MeuWidget');
    }
}

MinhasRedes::getInstance();
