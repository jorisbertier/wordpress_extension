<?php
/**
 * Plugin Name:  add_recipe
 * Description:  Créer et gèrer des recettes
 * Version:      1.0.0
 * Author:       Joris Bertier
 * Requires PHP: 8.0
 **/
require 'vendor/autoload.php';

// EXERCICE 1

function add_recipe_post_type() {

    register_post_type('recipe', [
        'label' => 'Recettes',
        'description' => 'Créer et gèrer des recettes',
        'public' => true,
        'hierarchical' => false,
        'show_in_admin_bar' => true,
        'menu_icon' => 'dashicons-food',
        'has_archive' => true,
        'menu_position' => 2,
        'supports' => [
            'title',
            'editor',
            'thumbnail',
            'author',
            'show_in_rest'
        ],
        'taxonomies' => [],
        'show_in_rest' => true
    ]);
}


function register_category_taxonomy() {
    register_taxonomy('category', 'recipe', [

        'labels' => [
            'name' => 'Catégories de Recettes',
            'singular_name' => 'Categories',
            'plural_name' => 'Categories',
            'search_items' => 'Rechercher des catégories',
            'all_items' => 'Toutes les catégories',
            'edit_item' => 'Modifier la catégories',
            'update_item' => 'Mettre à jour la catégorie',
            'add_new_item' => 'Ajouter une catégorie',
            'new_item_name' => 'Nouvelle catégorie',
            'menu_name' => 'Catégories de Recettes',
        ],
        'show_in_rest' => true, 
        'hierarchical' => true, 
        'public' => true, 
        'show_admin_column' => true,
        'capabilities' => [ 
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'manage_categories',
        ],
        'rewrite' => 'slug',
    ]);
}


add_action('init', 'add_recipe_post_type');
add_action('init', 'register_category_taxonomy');


function montheme_supports() {
    add_theme_support('title-tag');
}

function montheme_register_assets() {

    
    wp_register_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css'
    );
    
    wp_register_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js', // src
        ['popper']
    );

    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js');

    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap');

}


add_action('after_setup_theme', 'montheme_supports');
add_action('wp_enqueue_scripts', 'montheme_register_assets');



// Add a filter to 'template_include' hook
add_filter( 'archive_template', 'wpse_force_template' );
function wpse_force_template( $template ) {
    // If the current url is an archive of any kind
    if( is_archive() ) {
        // Set this to the template file inside your plugin folder
        $template = WP_PLUGIN_DIR .'/'. plugin_basename( dirname(__FILE__) ) .'/archive.php';
    }
    // Always return, even if we didn't change anything
    return $template;
}
