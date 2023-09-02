<?php
/**
 * Plugin Name:  Manage Recipe
 * Description:  Plugin recipe
 * Version:      0.1.0
 * Author:       Joris Bertier
 * Requires PHP: 8.0
 */

require 'vendor/autoload.php';

// function censor_word($content)
// {
//     $balcklist = ['nique', 'mere', 'vos'];
//     $content = get_the_content(); 
//     return str_ireplace($balcklist, '****', $content);
// }

// add_filter('the_content', 'censor_word');

// function ajout_menu_censure() 
// {
//     add_options_page(
//         "Gestion de la censure",
//         "Censure",
//         "manage_options",
//         "menu_censure",
//         "render_menu_censure",
//     );
// }

// function render_menu_censure()
// {
//    

function plugin_manage_recipe() {
    add_menu_page(
        'Gérer et publier recette de cuisine',
        'Recipe',
        'manage_options',
        'mon-plugin-manage-recipe',
        'mon_plugin_manage_recipe',
        'dashicons-products',
        1
        
    );
        // Nous demandons à créer un nouveau type: le "Héros"
    // On commence par lui donner une clé unique (TRES IMPORTANT): "hero"
    register_post_type('recipe', [
        'label' => 'Recipe', // Le nom qui apparait un peu partout sur notre site
        // On peut aussi fournir tout un tableau contenant les différentes appellation de notre PostType
        // selon le contexte mais cela demande plus de travail
        // 'labels' => [],
        'description' => 'Manage recipe', // Description du post type
        'public' => true, // Est-ce que les visiteurs ont le droit d'accéder aux pages relatives aux "heros"
        'hierarchical' => false, // Est-ce que des héros peuvent être des "enfants" (des variations) de héros existants ?
        'menu_icon' => 'dashicons-products', // L'icone qui apparait dans le menu du backoffice
        'has_archive' => true, // Peut-on accéder à une page "archive" de ce type de post ?
        'menu_position' => 2, // Permet de choisir l'emplacement de notre sous-menu dans le menu principale
        'supports' => [ // On détermine ce que supporte notre custom post type
            'title', // Il a un titre
            'editor', // Il a un éditeur de texte
            'thumbnail', // Il a une miniature
        ],
        'taxonomies' => [], // Liste des "catégories" disponibles pour ce Post Type
        'show_in_rest' => true, // Accessible depuis API et permet d'avoir l'éditeur sous forme de bloc
        // il existe d'autres options, consultez la documentation officielle !
    ]);
}
// add_action('init', 'plugin_manage_recipe');
add_action('admin_menu', 'plugin_manage_recipe');

function mon_plugin_manage_recipe() {
    if(!current_user_can('manage_options')) {
        return;
    }

    if(isset($_POST['mon_plugin_add_text'])) {
        $options = sanitize_text_field($_POST['mon_plugin_add_text']);


        update_option('mon_plugin_add_text_options', $options);
        echo '<div class="notice-success">Options enregistrée avec succès</div>';
    }

    $options = get_option('mon_plugin_add_text_options', '');

    ?>
    <div class="wrap">
        <h1>Créer ta recette de cuisine</h1>
        <form method="post">

            <label for="mon_plugin_add_text">Titre :</label><br>
            <input type="text" name="titre"><br>

            <label for="mon_plugin_add_text">Description :</label><br>
            <textarea name="contenu"></textarea><br>

            <label for="mon_plugin_add_text">Image mise en avant</label><br>
            <input type="file" name="image"><br>

            <input type="text" name="mon_plugin_add_text" id="mon_plugin_add_text" value="<?php echo esc_attr($options)?>" class="regular-text">
            <?php submit_button('Enregistrer les options', 'primary', 'submit', true)?>
        </form>
    </div>

    <?php

}


function mon_plugin_add_text($content) {
    $options = get_option('mon_plugin_add_text_options', '');
    $add = '<p>' . esc_html($options) . '</p>';
    $content = $add . $content ;
    return $content;
}

add_filter('the_content', 'mon_plugin_add_text');