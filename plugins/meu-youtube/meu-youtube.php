<?php
/*
Plugin Name: Meu Youtube
Description: Plugin desenvolvido para exibir botão de inscrição de canal no youtube (feito para estudos)
Version: 1.0
Author: Mariana Kaori
Text Domain: meu-youtube
*/

class MeuYoutube
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
        add_shortcode('youtube', array($this, 'youtube'));
    }

    public function youtube($parametros)
    {
        $a = shortcode_atts(array('canal' => ''), $parametros);
        $canal = $a['canal'];

        return '<script src="https://apis.google.com/js/platform.js"></script>
                <div class="g-ytsubscribe" data-channel="'.$canal.'" data-layout="full" data-count="default"></div>';
    }
}

MeuYoutube::getInstance();
