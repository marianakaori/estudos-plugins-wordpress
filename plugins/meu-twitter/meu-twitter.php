<?php
/*
Plugin Name: Meu Twitter
Description: Plugin desenvolvido para cadastro do twitter (feito para estudo)
Version: 1.0
Author: Mariana Kaori
Text Domain: meu-twitter
*/

class MeuTwitter
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
        add_action('admin_menu', array($this, 'setCustomFields'));
        add_shortcode('twitter', array($this, 'twitter'));
    }

    public function setCustomFields()
    {
        add_menu_page(
            'Meu Twitter',
            'Meu Twitter',
            'manage_options',
            'meu_twitter',
            'MeuTwitter::saveCustomFields',
            'dashicons-twitter',
            '25'
        );
    }
    
    public static function saveCustomFields()
    {
        echo "<h3> " . __("Cadastro twitter", "meu-twitter") . " </h3>";
        echo "<form method='post'>";

        $campos = array('twitter');

        foreach ($campos as $campo):
            if (isset($_POST[$campo])) {
                update_option($campo, $_POST[$campo]);
            }
            $valor = stripslashes(get_option($campo));
            $label = ucwords(strtolower($campo));

            echo "
                <p>
                    <label> $label </label></br>
                    <textarea cols='100' rows='10' name='$campo'> $valor </textarea>
                </p>
            ";
        endforeach;

        $nomeBotao = (get_option('twitter') == "") ? "Cadastrar" : "Editar";
        echo "<input type='submit' value='" . $nomeBotao ."' ></input>";

        echo "</form>";
    }

    public function twitter($params = null)
    {
        return stripslashes(get_option('twitter'));
    }

}

MeuTwitter::getInstance();