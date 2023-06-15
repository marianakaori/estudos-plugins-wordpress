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
            'upload_media_zips',
            'MediaUnzip::uploadMediaZips',
            'dashicons-media-archive',
            10
        );
    }

    public static function allowedFileTypes($filetype)
    {
        $allowedFileTypes = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

        return in_array($filetype, $allowedFileTypes);
    }

    public static function uploadMediaZips()
    {
        _e('<h3> Upload de arquivos zip </h3>', 'media-unzip');

        if (isset($_FILES['fileToUpload'])) {
            //obter diretorio de upload atual
            $dir = "../wp-content/uploads" . wp_upload_dir()['subdir'];

            //carregar o arquivo
            $targetFile = $dir . '/' . basename($_FILES['fileToUpload']['name']);
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile);
            $fileName = basename($_FILES['fileToUpload']['name']);

            //criar a isntancia de um objeto utilitario zip
            $zip = new ZipArchive();

            //abrir o arquivo zip
            $res = $zip->open($targetFile);
            if ($res) {
                $zip->extractTo($dir);
                echo
                    '<h3 style="color:#090;">
                        O arquivo zip '.$fileName.' foi descompactado com sucesso! ' .wp_upload_dir()['url'].
                    '</h3>' ;

                echo "Tem " . $zip->numFiles . " arquivos neste arquivo zip. <br>";
                for ($i=0; $i < $zip->numFiles; $i++) {
                    //obter url do arquivo de mídia
                    $mediaFileName = wp_upload_dir()['url'].'/'.$zip->getNameIndex($i);

                    //obter o tipo do arquivo de mídia
                    $filetype =wp_check_filetype(basename($mediaFileName), null);
                    $allowed = MediaUnzip::allowedFileTypes($filetype['type']);

                    if ($allowed) {
                        //exibir um link para ver o arquivo upload
                        echo
                            '<a href="' .$mediaFileName. '"target="_blank">' .$mediaFileName. '</a>
                            Tipo: ' . $filetype['type'] . '<br>';

                        //informações dos anexos que serão utilizadas pela biblioteca de mídia
                        $attachment = array(
                            'guid' => $mediaFileName,
                            'post_mime_type' => $filetype['type'],
                            'post_title' => preg_replace('/\.[^.]+$/', '', $zip->getNameIndex($i)),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );

                        $attachId = wp_insert_attachment($attachment, $dir .'/'. $zip->getNameIndex($i));

                        //metadados para o anexo
                        $attachData = wp_generate_attachment_metadata($attachId, $dir .'/'. $zip->getNameIndex($i));
                        wp_update_attachment_metadata($attachId, $attachData);
                    } else {
                        echo
                            $zip->getNameIndex($i) .'não pôde ser enviado, o tipo'.
                            $filetype['type'] . 'não é permitido. <br>';
                    }
                }
            } else {
                echo '<h3 style="color:#F00;"> O arquivo zip NÃO foi descompactado com sucesso</h3>';
            }

            $zip->close();
        }

        echo
            '<form
                style="margin-top: 20px;"
                action="/wordpress/wp-admin/admin.php?page=upload_media_zips"
                enctype="multipart/form-data"
                method="post"
            >
                Selecione o arquivo zip
                <input type="file" name="fileToUpload" id="fileToUpload">
                <br>
                <input type="submit" value="Upload de arquivo ZIP" name="submit">
            </form>';
    }
}

MediaUnzip::getInstance();