<?php
/*
Plugin Name: Proteger Login
Description: Plugin desenvolvido para proteger tela de login do administrador
Version: 1.0
Author: Mariana Kaori
Text Domain: proteger-login
*/

if (!defined('ABSPATH')) { header('Location:http://localhost/wordpress'); }
class ProtegerLogin
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
        add_action('login_form_login', array($this, 'ptLogin'));
    }

    public function ptLogin()
    {
        if ($_SERVER['SCRIPT_NAME'] == '/wordpress/wp-login.php') {
            $min = Date('i');
            if (!isset($_GET['empresa' . $min])){
                header('Location: http://localhost/wordpress');
            }
        }
    }
}

ProtegerLogin::getInstance();