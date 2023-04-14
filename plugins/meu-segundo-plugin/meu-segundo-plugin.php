<?php
/*
Plugin Name: Personalizar Painel
Description: Esta plugin foi feito para personalizar o painel (feito para estudo)
Version: 1.0
Author: Mariana Kaori
*/

//Desativar a action welcome_panel
remove_action('welcome_panel', 'wp_welcome_panel');

add_action('welcome-panel', 'myWelcomePanel');

function myWelcomePanel()
{
    ?>
        <div class="welcome-panel-content">
            <h3>Seja bem-vindo ao painel administrativo</h3>
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