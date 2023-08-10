<?php





//Ajout des themes supports
function montheme_supports()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
}

function register_my_menu()
{
    register_nav_menu('header', 'Menu du haut'); // (location, desciption)
    register_nav_menu('footer', 'Menu du bas');
}

function montheme_register_assets()
{
    wp_register_style(
        'montheme',
        get_template_directory_uri() . '/assets/style/css/main.css'
    );
    wp_enqueue_style('montheme');
}


// filter 
function change_separator($sep) {
    return '|';
}

function change_excerpt_length($length) {
    return 2;
}

function allCapsTitle($title)
{
    return '"'. mb_strtoupper($title) . '"';
}

function atg_menu_classes($classes)
{
    $classes[] = 'nav-item';
    return $classes;
}

function change_menu_link_attr($atts)
{
    $atts['class'] = "nav-link";
    return $atts;
}

function montheme_register_products()
{
    register_post_type('product', [
        'label' => 'Produits',
        // 'labels' => [
        //     'edit_item' => 'Editer le produit',
        //     'add_new' => 'Ajouter un nouveau produit'
        // ]
        'description' => 'Les produits en vente sur le site',
        'public' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_position' => 4,
        'menu_icon' => 'dashicons-products',
        'supports' => [
            'title',
            'editor',
            'thumbnail',
            'comments',
        ],
        'taxonomies' => [

        ],
        'has_archive' => true
    ]);
}   

function montheme_register_gamme()
{
    register_taxonomy('gamme', ['product'], [
        'labels' => [
            'singular_name' => 'Gamme',
            'name' => 'Gamme',
            'add_new' => "Ajout d'nouvelle gamme",
            'edit_item' => 'Editer la gamme',
            'view_item' => "Voir la gamme"
        ],
        'description' => 'Une gamme de produit',
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
    ]);
}

add_shortcode('shortcode', 'short_code');

function short_code()
{
    return 'Voici un short code';
}


// hook action ($hookname, $callback function de retour)
add_action('after_setup_theme', 'montheme_supports');
add_action('wp_enqueue_scripts', 'montheme_register_assets');
add_action('after_setup_theme', 'register_my_menu');
add_action('init', 'montheme_register_products');
add_action('init', 'montheme_register_gamme');


//hook filter ($hookname, $callback function de retour)
add_filter('the_title',  'allCapsTitle');

add_filter("document_title_separator", "change_separator");
add_filter("excerpt_length", "change_excerpt_length");

add_filter('nav_menu_css_class', 'atg_menu_classes');
add_filter('nav_menu_link_attributes', 'change_menu_link_attr');
