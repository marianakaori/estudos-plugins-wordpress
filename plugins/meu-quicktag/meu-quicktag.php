<?php
/*
Plugin Name: Meu Quicktag
Description: Plugin desenvolvido para inserir quicktag personalizado (feito para estudo)
Version: 1.0
Author: Mariana Kaori
Text Domain: meu-quicktag
*/

if (!defined('ABSPATH')) { header('Location:http://localhost/wordpress'); }
class MeuQuicktag
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
        add_action('admin_print_footer_scripts', array($this, 'myQuicktag'));
    }

    public function myQuicktag()
    {
        if (wp_script_is('quicktag')) {
            echo "AAAAAAAAAAAAA"
            ?>
            <script type="text/javascript">
                //função para recuperar texto selecionado
                function getSel() {
                    var textArea = document.getElementById("content");
                    var start = textArea.selectionStart;
                    var finish = textArea.selectionEnd;
                    return textArea.value.substring(start, finish);
                }

                QTags.addButton('btnPersonalizado', 'Twitter', getT);
                function getT() {
                    var selectedText = getSel();
                    QTags.insertContent('[twitter]')
                }
            </script>
            <?php
        }
    }
}

MeuQuicktag::getInstance();