<?php

/*
Plugin Name: Review de Filmes
Description: Plugin para review de filmes (feito para estudo)
Version: 1.0
Author: Mariana Kaori
*/

use MetaBox\Support\Arr;

require_once dirname(__FILE__).'/lib/class-tgm-plugin-activation.php';

class FilmesReviews
{
    private static $instance;
    const FIELD_PREFIX = 'fr_';
    
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('init', 'FilmesReviews::registerPostType');
        add_action('init', 'FilmesReviews::registerTaxonomies');
        add_action('tgmpa_register', array($this, 'checkRequiredPlugins'));
        add_filter('rwmb_meta_boxes', array($this, 'metaboxCustomFields'));

        /* TEMPLATE CUSTOMIZADO */
        add_action('template_include', array($this, 'addCPTTemplate'));
        add_action('wp_enqueue_scripts', array($this, 'addStyleScripts'));
    }

    public static function registerPostType()
    {
        register_post_type('filmes_reviews', array(
            'labels' => array(
                'name' => 'Filmes Reviews',
                'singular_name' => 'Filme Review'
            ),
            'description' => 'Post para cadastro de reviews de filmes.',
            'supports' => array(
                'title', 'editor', 'excerpt', 'author', 'revisions', 'thumbnail', 'custom-fields',
            ),
            'public' => true,
            'menu_icon' => 'dashicons-format-video',
            'menu_position' => 4,
        ));
    }

    public static function registerTaxonomies()
    {
        register_taxonomy('generos_filme', array('filmes_reviews'), array(
            'labels' => array(
                'name' => __('Gêneros de filme'),
                'singular_name' => __('Gênero de filme')
            ),
            'public' => true,
            'hierarchical' => true,
            'rewrite' => array('slug' => 'generos_filme')
        ));
    }

    /* Checar plugins requeridos */
    public function checkRequiredPlugins()
    {
        $plugins = array(
            array(
                'name' => 'Meta Box',
                'slug' => 'meta-box',
                'required' => true,
                'force_activation' => false,
                'force_deactivation' => false
            )
        );
        /*Config*/
        $config  = array(
            'domain'           => 'filmes-reviews',
            'default_path'     => '',
            'parent_slug'      => 'plugins.php',
            'capability'       => 'update_plugins',
            'menu'             => 'install-required-plugins',
            'has_notices'      => true,
            'is_automatic'     => false,
            'message'          => '',
            'strings'          => array(
                'page_title'                      => __('Instalar plugins requeridos', 'filmes-reviews'),
                'menu_title'                      => __('Instalar Plugins', 'filmes-reviews'),
                'installing'                      => __('Instalando Plugin: %s', 'filmes-reviews'),
                'oops'                            => __('Algo deu errado com a API do plug-in.', 'filmes-reviews'),
                'notice_can_install_required'     => _n_noop('O plugin Filmes Reviews depende do seguinte plugin: %1$s.', 'O plugin Filmes Reviews depende dos seguintes plugins:%1$s.'),
                'notice_can_install_recommended'  => _n_noop('O plugin Filmes review recomenda o seguinte plugin: %1$s.', 'O plugin Filmes review recomenda os seguintes plugins: %1$s.'),
                'notice_cannot_install'           => _n_noop('Desculpe, mas você não tem as permissões corretas para instalar o plugin %s. Entre em contato com o administrador deste site para obter ajuda sobre como instalá-lo', 'Desculpe, mas você não tem as permissões corretas para instalar os plugins %s. Entre em contato com o administrador deste site para obter ajuda sobre como instalá-los.'),
                'notice_can_activate_required'    => _n_noop('O seguinte plugin necessário está inativo: %1$s.', 'Os seguintes plugins necessários estão inativos: %1$s.'),
                'notice_can_activate_recommended' => _n_noop('O seguinte plugin recomendado está inativo: %1$s.', 'Os seguintes plugins recomendados estão inativos: %1$s.'),
                'notice_cannot_activate'          => _n_noop('Desculpe, mas você não tem as permissões corretas para ativar o plugin %s. Entre em contato com o administrador deste site para obter ajuda sobre como ativá-lo.', 'Desculpe, mas você não tem as permissões corretas para ativar os plugins %s. Entre em contato com o administrador deste site para obter ajuda sobre como ativá-los.'),
                'notice_ask_to_update'            => _n_noop('O plugin a seguir precisa ser atualizado para sua versão mais recente para garantir a compatibilidade máxima com este tema: %1$s.', 'Os plugins a seguir precisam ser atualizados para sua versão mais recente para garantir a compatibilidade máxima com este tema: %1$s.'),
                'notice_cannot_update'            => _n_noop('Desculpe, mas você não tem as permissões corretas para atualizar o plugin %s. Entre em contato com o administrador deste site para obter ajuda sobre como atualizá-lo.', 'Desculpe, mas você não tem as permissões corretas para atualizar os plugins %s. Entre em contato com o administrador deste site para obter ajuda sobre como atualizá-los.'),
                'install_link'                    => _n_noop('Comece a instalação de plugin', 'Comece a instalação dos plugins'),
                'activate_link'                   => _n_noop('Ativar o plugin instalado', 'Ativar os plugins instalados'),
                'return'                          => __('Voltar para os plugins requeridos instalados', 'filmes-reviews'),
                'plugin_activated'                => __('Plugin ativado com sucesso.', 'filmes-reviews'),
                'complete'                        => __('Todos os plugins instalados e ativados com sucesso. %s', 'filmes-reviews'),
                'nag_type'                        => 'updated',
                )
            );
        tgmpa($plugins, $config);
        /*Fim Config*/
    }

    /* METABOX */
    public function metaboxCustomFields()
    {
        $metaBoxes[] = array(
            'id' => 'data_filme',
            'title' => __('Informações Adicionais', 'filmes-reviews'),
            'pages' => array('filmes_reviews', 'post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Ano de lançamento', 'filmes-reviews'),
                    'desc' => __('Ano que o filme foi lançado', 'filmes-reviews'),
                    'id' => self::FIELD_PREFIX.'filme_ano',
                    'type' => 'number',
                    'std' => date('Y'),
                    'min' => '1880'
                ),
                array(
                    'name' => __('Diretor', 'filmes-reviews'),
                    'desc' => __('Quem dirigiu o filme', 'filmes-reviews'),
                    'id' => self::FIELD_PREFIX.'filme_diretor',
                    'type' => 'text',
                    'std' => ''
                ),
                array(
                    'name' => 'Site',
                    'desc' => 'Link do site do filme',
                    'id' => self::FIELD_PREFIX.'filme_site',
                    'type' => 'url',
                    'std' => ''
                )
            )
        );

        $metaBoxes[] = array(
            'id' => 'avaliacao_data',
            'title' => __('Avaliação do Filme', 'filmes-reviews'),
            'pages' => array('filmes_reviews'),
            'context' => 'side',
            'priority' => 'high',
            'fields' => array(
                array(
                    'name' => __('Avaliação', 'filmes-reviews'),
                    'desc' => __('Em uma escala de 1 a 5 (5 é a melhor nota)', 'filmes-reviews'),
                    'id' => self::FIELD_PREFIX.'filme_nota',
                    'type' => 'select',
                    'options' => array(
                        '' => __('Avalie aqui', 'filmes-reviews'),
                        1 => __('1 - Não gostei', 'filmes-reviews'),
                        2 => __('2 - Gostei pouco', 'filmes-reviews'),
                        3 => __('3 - Gostei mais ou menos', 'filmes-reviews'),
                        4 => __('4 - Gostei', 'filmes-reviews'),
                        5 => __('5 - Gostei muito', 'filmes-reviews'),
                        6 => __('6 - Fantástico!', 'filmes-reviews'),
                        7 => __('7 - Clássico inesquecível', 'filmes-reviews'),
                        8 => __('8 - Magnífico', 'filmes-reviews'),
                        9 => __('9 - Obra-prima', 'filmes-reviews'),
                        10 => __('10 - Perfeito', 'filmes-reviews')
                    ),
                    'std' => ''
                )
            )
        );

        return $metaBoxes;
    }

    public function addCPTTemplate($template)
    {
        if (is_singular('filmes_reviews')) {
            if (file_exists(get_stylesheet_directory().'single-filme-review.php')) {
                return get_stylesheet_directory().'single-filme-review.php';
            }
            return plugin_dir_path(__FILE__).'single-filme-review.php';
        }
        return $template;
    }

    public function addStyleScripts()
    {
        wp_enqueue_style('filme-review-style', plugin_dir_url(__FILE__). 'filme-review.css');
    }

    public static function activate()
    {
        self::registerPostType();
        self::registerTaxonomies();
        flush_rewrite_rules();
    }
}

FilmesReviews::getInstance();

register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
register_activation_hook(__FILE__, 'FilmesReviews::activate');