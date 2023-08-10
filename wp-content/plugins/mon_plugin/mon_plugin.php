<?php
/**
 * Plugin Name:  Mon plugin
 * Description:  Mon premier plugin
 * Version:      0.1.0
 * Author:       Joris Bertier
 * Requires PHP: 8.0
 */

require 'vendor/autoload.php';

function censor_word($content)
{
    $balcklist = ['nique', 'mere', 'vos'];
    $content = get_the_content(); 
    return str_ireplace($balcklist, '****', $content);
}

add_filter('the_content', 'censor_word');

function ajout_menu_censure() 
{
    add_options_page(
        "Gestion de la censure",
        "Censure",
        "manage_options",
        "menu_censure",
        "render_menu_censure",
    );
}

function render_menu_censure()
{
    ?>

    <h1>Gestion de la censure des posts</h1>
    <form action="options.php" method="post">
        <?php
            settings_fields('censure_option');

            do_settings_sections('censure_option');

            submit_button();
        ?>
    </form>

    <?php
}

add_action('admin_menu', 'ajout_menu_censure');
add_action('admin_init', 'ajout_censure_settings');

add_action('', '');
