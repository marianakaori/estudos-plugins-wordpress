<?php
/*
Plugin Name: Media Unzip
Description: Plugin desenvolvido para envio de imagens zipadas
Version: 1.0
Author: Mariana Kaori
Text Domain: media-unzip
*/

if (!defined('ABSPATH')) { header('Location:http://localhost/wordpress'); }
class MediaUnzip
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
        add_action('admin_menu', array($this, 'startMediaFileUnzip'));
    }

    public function startMediaFileUnzip()
    {
        add_menu_page(
            'Upload Media Zip',
            'Upload Media Zip',
            'manage_options',
            'upload-media-zip',
            'MediaUnzip::uploadMediaZips',
            'dashicons-media-archive',
            10
        );
    }

    public function allowedFileTypes($filetype)
    {
        $allowedFileTypes = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

        return in_array($filetype, $allowedFileTypes);
    }

    public static function uploadMediaZips()
    {
        echo '<h3>' . __('Upload de arquivos zip', 'media-unzip') . '</h3>';

        if (isset($_FILES['fileToUpload'])){
            //obter diretoriode upload atual
            $dir = "../wp-content/upload" . wp_upload_dir()['subdir'];

            //carregar o arquivo
            $targetFile = $dir . '/' . basename($_FILES['fileToUpload']['name']);
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile);
            $fileName = basename($_FILES['fileToUpload']['name']);

            //criar a isntancia de um objeto utilitario zip
            $zip = new ZipArchive();

            //abrir o arquivo zip
            $res = $zip-> open($targetFile);
            if ($res) {
                $zip->extractTo($dir);
                echo
                    '<h3 style="color:#090;">
                        O arquivo zip $fileName foi descompactado com sucesso!
                    </h3>' . wp_upload_dir()['url'];
            }
        }

        echo
            '<form
                style="margin-top: 20px;"
                action="/wordpress/wp-admin/admin.php?page=uploadMediaZips"
                enctype="multipart/form-data"
            >
                Selecione o arquivo zip
                <input type="file" name="fileToUpload" id="fileToUpload">
                <br>
                <input type="submit" value="Upload de arquivo ZIP" name="submit">
            </form>';
    }
}

MediaUnzip::getInstance();