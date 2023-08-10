# Wordpress

## Mise en place du Virtual host
Quand on utilise un serveur Apache (fourni avec Wamp / Xampp), il faut 
normalement accéder à nos projets en passant par le localhost.

Ainsi, pour accéder au projet "exemple", il faut se rendre sur l'url :
>> http://localhost/exemple

Pas toujours très pratique...
L'idée du Virtual Host et de nous permettre d'accéder à notre projet "exemple" en se rendant simplement
sur une url factice comme :
>> http://exemple.local
 
Beaucoup plus parlant et pratique si on a beaucoup de projets qui tournent sur notre serveur !

Pour arriver à cela, il faut éditer 2 fichiers
1- Le fichier "hosts"
- Sous Windows: C:\Windows\System32\drivers\etc\hosts
- Sous Linux: /etc/host

A l'intérieur, vous trouverez normalement déjà quelques lignes.
````
127.0.0.1 localhost
````
Cela signifie que l'on créé un "alias".
127.0.0.1 est une IP "placeholder" qui pointe sur... votre propre machine.
On détermine ici que "localhost", c'est la même chose que 127.0.0.1.

Si notre projet s'appelle "exemple", nous rajouterons ces lignes:
````
127.0.0.1 exemple.local
````
A présent, l'adresse exemple.local pointera également sur notre propre machine.

2- httpd-vhosts.conf
- Avec Wamp:
>> C:\wamp64\bin\apache\apache<votre-version>\conf\extra\httpd-vhosts.conf
- Avec Xampp:
>> C:\xampp\apache\conf\extra\httpd-vhosts.conf

Vous devriez déjà avoir quelque chose qui ressemble à ça:
````
# Virtual Hosts
# Version WAMP
<VirtualHost *:80>
  ServerName localhost
  ServerAlias localhost
  DocumentRoot "${INSTALL_DIR}/www"
  <Directory "${INSTALL_DIR}/www/">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
  </Directory>
</VirtualHost>

# Version XAMPP
<VirtualHost *:80>
  ServerName localhost
  ServerAlias localhost
  DocumentRoot "${INSTALL_DIR}/htdocs"
  <Directory "${INSTALL_DIR}/htdocs/">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
  </Directory>
</VirtualHost>
````
Pour un projet qui s'appelle "exemple", ajoutez simplement ceci :
````
<VirtualHost *:80>
  ServerName exemple.local
  DocumentRoot "${INSTALL_DIR}/www/exemple" <-- pour WAMP
  DocumentRoot "${INSTALL_DIR}/htdocs/exemple" <-- pour XAMPP
</VirtualHost>
````

Traduction: si une requête est faites sur localhost sur le port 80 (HTTP) et que
cette requête contient "exemple.local", alors nous devons servir le contenu du dossier qui se trouve
à l'emplacement indiqué "/www/exemple" (ou /htdocs/exemple sous xampp).

Redémarrez votre WAMP/XAMPP et essayez d'aller sur "http://exemple.local" (précisez le http:// pour être sûr que votre navigateur ne vous redirige pas sur https).

## Création de Thème

Créer un nouveau dossier dans /wp-content/themes Puis rajouter:

- index.php
- style.css

style.css devra contenir des méta données sur le thème.

````css
/*
Theme Name: Le nom de mon thème
Version: 1.0
Requires PHP: 8.0
Description: Votre description de super thème.
Tags: grid, custom-color, custom-background
Author: Moi
Licence: (GNU GPLv2 ou supérieure)
 */
````

Seul le nom du thème est obligatoire mais le reste peut être très utile si votre but est de partager ou de
commercialiser votre thème.

Pour que votre thème apparaisse avec une image dans la liste des thèmes installés dans le back office, vous pouvez
inclure un fichier image qui devra s'appeler 'screenshot.png' à la racine de votre thème.

### The Loop (la Boucle WP)
[Documentation Officielle](https://developer.wordpress.org/themes/basics/the-loop/)

La boucle WP régie tout ou presque.
Elle s'exprime toujours de la manière suivante:

````php
<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        // Display post content
    endwhile;
endif;
?>

<!-- Version courte (à éviter si vous n'êtes pas à l'aise avec ce format) -->
<?php if (have_posts(): while(have_posts()): the_post(); ?>
    <?-- Mon code -->
<?php endwhile; endif; ?>
````

On voit que l'on vérifie si nous avons un ou plusieurs Posts (articles) et pour chacun
d'entres eux, nous déclarons "the_post()".

A partir de là, cela nous donne accès à une variable $post globale qui contient
tout notre post ainsi que plusieurs fonctions qui servent à récupérer plus facilement un ou
 plusieurs informations contenu dans le Post.

````php
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post() ?>
        <h1><?php the_title() ?></h1>
        <small>écrit par <?php the_author() ?> le <?php the_time() ?>
        <div><?php the_content() ?></div>
        <?php the_post_thumbnail('post-thumbnail', ['class' => 'apercu', 'alt' => 'Aperçu de mon article']); ?>
        <a href="<?php the_permalink() ?>"></a>
    <?php endwhile ?>
<?php endif ?>;
````
Remarquez que nous n'avons que la structure HTML à définir, sutructure dans laquelle 
nous injectons les différentes parties de notre Post (titre, auteur, contenu...).

Voici la liste des choses auquelles nous avons accès:

>> next_post_link() – Lien vers le post suivant (chronologiquement)
>> previous_post_link() – Lien vers le post précédent
>> the_category() – La ou les catégories du post
>> the_author() – L'auteur du post
>> the_content() – Le contenu du post
>> the_excerpt() – Un extrait du contenu du post
>> the_ID() – L'ID du post
>> the_meta() – Les métadonnées spécifiques à ce post
>> the_permalink() - Retourne l'URL pour accéder au post
>> the_shortlink() – Génère une balise a pointant sur le post, on peut passer en param le texte du lien
>> the_tags() – Le ou les tags (étiquettes)
>> the_title() – Titre du post
>> the_time() – Date de publication du post
>> the_post_thumbnail() - Image de mise en avant du post sous forme de balise <img/>
>> the_post_thumbnail_url() - Url de l'image de mise en avant

### Template Hierarchy
[Schéma de la hiérarchie des pages](https://developer.wordpress.org/files/2014/10/Screenshot-2019-01-23-00.20.04.png)

Vous remarquerez que même si l'on peut se déplacer sur le site (page home avec tous les posts, page de détail d'un post etc...) c'est toujours 
index.php qui est appellé. Et pour cause, c'est notre seul fichier php !

En réalité, WP appelle automatiquement certains fichiers PHP et exécutent des requêtes SQL selon la route sur laquelle on se trouve.
Par exemple:
- route "/": 
    PHP: on appelle le fichier "home.php" si il existe ou "index.php"
    SQL: on va chercher les X derniers posts
- route "/mon-article"
    PHP: on appelle le fichier "single-post.php", sinon "single.php", sinon "index.php"
    SQL: on va chercher uniquement le post qui a le même nom que notre route (ici, "mon-article")

Je vous invite à consulter le schéma de la hiérarchie des pages pour plus de détails.

>> index.php - Sera toujours le fallback

>> front-page.php
>> home.php
Page d'accueil

>> single.php
Sera appellé quand on veut consulter un post particulier
 
>> single-{post-type}.php
Plus précis. Ne s'applique que si nos "posts" sont des "posts" (et non pas des custom post type)
Exemple : single-post.php

On peut être TRES (trop ?) précis :
>> single-{post-type}-{slug}.php
Exemple : single-product-chaussette.php
Ne s'affichera que pour afficher le produit "chaussette".

archive.php - Sera appellé quand on veut afficher la liste de tous nos posts
>> archive-{post-type}.php
Plus précis. Ne s'applique que si nos "posts" sont des "posts" (et non pas des custom post type) 
Exemple: archive-product.php
Page qui affiche la liste des posts de type "products"

404.php - Page qui s'affichera quand on tombe sur une erreur 404 (pas inexistante)

Vous avez aussi les partials templates qui servent à être insérés dans d'autres pages:
header.php - Sera appelé par la fonction "get_header()"
footer.php - Sera appelé par la fonction "get_footer()"

### Header et Footer

Pour automatiquement inclure le header et le footer de notre site, nous devons procéder comme ceci.

index.php

````php
<?php get_header() ?>
    Mon contenu
<?php get_footer() ?>
````

Si je veux personaliser mon header et mon footer je dois créer un fichier header.php et footer.php à la racine de mon
thème.

header.php

````php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head() ?>
</head>
<body>
<!-- On ne referme pas le body ! -->
````

footer.php

````php
    <?php wp_footer() ?>
</body>
</html>
````

Remarquez que l'on a inclus dans notre header "wp_head()" et dans notre footer "wp_footer()".

wp_head permet de récupérérer automatiquement les métadonnées des pages WP (titre de la page, meta tags etc).
wp_footer permet de faire apparaître le menu admin en haut de la page quand on est connecté.

### La logique
Toute la logique de notre thème se trouvera dans un fichiers functions.php.
Ce fichiers sera chargé en amont du reste et nous permet d'injecter notre logique dans les rouages de Wordpress.


Actuellement, notre thème n'est pas très puissant et il lui manque des fonctionnalités basiques telles que les images de mises en avant (thumbnail) ou encore les titres de page en onglet.

Pour remédier à cela, nous pouvons passer des options.
````php
add_theme_support('title-tag'); // Le titre de la page sera injecté grace à wp_head()
add_theme_support('post-thumbnails'); // Nous pouvons maintenant mettre des images thumbnails aux posts
````
[Liste des features activables](https://developer.wordpress.org/reference/functions/add_theme_support/)

### Hooks : Actions et Filtres

[Tuto sur l'utilisation des actions WP](https://www.youtube.com/watch?v=wiQMfaKcA9k&list=PLjwdMgw5TTLWF1VV9TFWrsUTvWjtGS7Qt&index=5&ab_channel=Grafikart.fr)
[Tuto sur l'utilisation des filtres WP](https://www.youtube.com/watch?v=oLP2T9DfnEk&list=PLjwdMgw5TTLWF1VV9TFWrsUTvWjtGS7Qt&index=7&ab_channel=Grafikart.fr)

Si ce n'est pas déjà fait, créez un ficher function.php qui regroupera l'ensemble des fonctions de notre thème. Avec les hooks, le
but est de se greffer à un évènement existant et de venir rajouter notre code.

#### Actions
Une action est un code que l'on exécute à un "moment précis" dans le cycle de vie de WP.
Une action de retourne rien: elle se content de "faire quelque chose" (votre fonction) à "un moment donné" (défini par le hook indiqué).

>> add_action('le-hook-wp', 'mafonction', priorité)

````php
<?php

function montheme_supports() {
    add_theme_support('title-tag'); // On indique que notre thème supporte les title tag (nom de page dans l'onglet)
}

function montheme_register_assets() {
    // Importation des assets CSS et JS
    
    // CSS
    wp_register_style(
        'bootstrap', // key
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' // src
    ) // Permet d'enregister une feuille CSS (pas de l'utiliser)
    
    // JS
    wp_register_script(
        'bootstrap', // key 
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js', // src
        ['popper'] // Dépendences 
    ) 
    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js') 
    
    // wp_deregister('jquery') // Si l'on veut supprimer un script particulier
    
    // On ajoute les assets dans notre header
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap');
}

// On lance ensuite nos actions qui vont se greffer sur des évents wp
add_action('after_setup_theme', 'montheme_supports');
add_action('wp_enqueue_scripts', 'montheme_register_assets');
````

#### Filtres
Les filtres fonctionnent presque de la même façon.
La différence venat du fait qu'un filtre récupère une donnée (qui nous est envoyée par WP) et
que notre fonction doit retourner quelque chose.

Voyez ça comme un "tuyau" que l'on vient rajouter dans la machine WP: on veut qu'une donnée rentre dans
notre tuyau, et qu'une nouvelle donnée en ressorte.

>> add_filter('le-hook-wp', 'mafonction', priorité)

```php

add_filter('the_content', 'transform_the_content');

// Quand on appelle la fonction" "the_content", au lieu de retourner directement le contenu
// le contenu passera d'abord dans cette fonction "filtre".
// A la sortie, on voit que le contenu sera maintenant entouré de guillemets.
function transform_the_content($content)
{
    // Mon code, ici j'ai accès au "content" des posts dans la variable $content
    return '"' . $content . '"';
}

```

### Menus
Il faudra dire à notre thème de supporter les menus.
````php
add_theme_support('menus');
register_nav_menu("header", "Menu de l'en-tête")
````
A partir de là, on peut se rendre dans Apparence/menus dans la partie admin pour créer des menus.
Une fois notre menu créé (on choisit bien l'emplacement "header" qui est le nom de notre menu) nous pouvons nous rendre dans header.php.

header.php
```php
<?php wp_nav_menu([
    'theme_location' => "header", // ID du menu
    'container' => false, // Enlève la div autour du menu
    'menu_class' => "la-classe-du-menu",
])?>
```

On remarque que l'on a pu modifier la classe du menu, mais pas de ses éléments.
En grattant un peu dans WP, on découvre qu'il y existe un filtre pour cela !
Dans mon fonctions.php je peux donc venir modifier ce comportement.

```php
add_filter("nav_menu_css_class", "change_nav_classes");
add_filter("nav_menu_link_attributes", "change_nav_links");

function change_nav_classes($classes) {
    // On récupère les classes de WP mais on injecte la notre !
    $classes[] = "ma-classe-pour-les-navitems";
    return $classes;
}

function change_nav_links($attr) {
    // On récupère les classes de WP mais on injecte la notre !
    $attr['class'] = "ma-classe-pour-les-navlinks";
    return $attr;
}

```

### Création d'un CustomPostType

Sous wordpress, presque tout est un "Post" (ou "publication"). Cependant, il arrive souvent que le post de base ne
réponde pas à tous nos besoins. Il est donc possible de créer des CustomPostType qui sont un peu comme des Entities à la
différence notable que, du point de vue de la base de données, tous nos types personalisés, en fin de compte, reste
des "Post".

_Après avoir défini un CustomPostType ou une CustomTaxonomy il est IMPORTANT de se rendre dans le menu des Rêglages ->
Permaliens -> Enregistrer les modifications afin de rafraîchir les liens de notre site et qu'ils prennents bien en
compte nos nouveaux éléments !_

```php
// Ici, on ajoute un nouveau type : le Héros

// On se branche sur le hook "init" et on lance notre fonction
add_action('init', 'add_hero_post_type');

function add_hero_post_type() {
    // Nous demandons à créer un nouveau type: le "Héros"
    // On commence par lui donner une clé unique (TRES IMPORTANT): "hero"
    register_post_type('hero', [
        'label' => 'Héros', // Le nom qui apparait un peu partout sur notre site
        // On peut aussi fournir tout un tableau contenant les différentes appellation de notre PostType
        // selon le contexte mais cela demande plus de travail
        // 'labels' => [],
        'description' => 'Un héros de RPG', // Description du post type
        'public' => true, // Est-ce que les visiteurs ont le droit d'accéder aux pages relatives aux "heros"
        'hierarchical' => false, // Est-ce que des héros peuvent être des "enfants" (des variations) de héros existants ?
        'exclude_from_searrch' =
        'show_in_admin_bar' => true,
        'menu_icon' => 'dashicons-chart-pie', // L'icone qui apparait dans le menu du backoffice 
        'has_archive' => true, // Peut-on accéder à une page "archive" de ce type de post ?
        'menu_position' => 4, // Permet de choisir l'emplacement de notre sous-menu dans le menu principale
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

```

Une fois ce travail de définition effectué, notre nouveau PostType devient disponible depuis le menu principale.

On peut à présent créer et modifier nos "Héros" de la même façon que des Articles classiques.

### Création de Taxonomie

Les Taxonomies sont des "catégories d'articles" qui nous permettent de classer nos Post.

De base, on possède déjà les taxonomies "catégorie" et "étiquette". On note au passage que "catégorie" est hiérarchique:
on peut donc avoir des catégories et des sous catégories.

```php

add_action('init', 'register_class_taxonomy');

function register_class_taxonomy() {
    register_taxonomy('class', 'hero', [
        // Ici on passe nos options
        'labels' => [
            'name' => 'Classe',
            'singular_name' => 'Classe',
            'plural_name' => 'Classes',
            'search_items' => 'Rechercher des classes',
            'all_items' => 'Toutes les classes',
            'edit_item' => 'Modifier la classe',
            'update_item' => 'Mettre à jour la classe',
            'add_new_item' => 'Ajouter une classe',
            'new_item_name' => 'Nouvelle classe',
            'menu_name' => 'Classes',
        ],
        'show_in_rest' => true, // Pour avoir accès à cette taxonomy depuis l'éditeur de Bloc
        'hierarchical' => true, // Notre Classe peut avoir des "sous-classe" (sous-catégorie)
        'public' => true, // Notre catégorie est-elle accéssible depuis le front ?
        'show_admin_column' => true, // Est-ce que la taxonomy apparait dans les tableaux côté admin ?
        'capabilities' => [ // Définir les permissions d'usage
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'manage_categories',
        ],
        'rewrite' => 'slug', // Réécriture d'url via le slug de la taxonomy
    ]);
}
```

Mais comment récupérer/afficher la liste des taxonomies de nos posts ?
Quand vous êtes dans "the_loop", vous pouvez consulter la liste des "terms" avec la fonction "get_terms" et
en lui passant un tableau de la liste des taxonomies que vous voulez voir ("catégories", "étiquette" etc...).


```php
<ul>
    <?php foreach(get_terms(['gamme']) as $term): ?> // On récupère uniquement les "gammes" (notre taxonomy custom)
        <li>
            <a href="<?= get_term_link($term) ?>">
                <?= $term->name?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
```


Quelques liens utiles:
[Documentation officielle pour l'ajout d'un post type](https://developer.wordpress.org/reference/functions/register_post_type/)
[Documentation officielle pour l'ajout d'une taxonomie](https://developer.wordpress.org/reference/functions/register_taxonomy/)
[Liste des icones WP](https://developer.wordpress.org/resource/dashicons/#buddicons-forums)

### Extension ACF (Advanced Custom Fields)
Cette extension extrêment utile et populaire vous permet d'ajouter des champs à vos taxonomies et posts.

Voyez un peu cela comme une façon de rajouter des propriétés à des Entities Symfony (en quelque sorte...).

Par exemple, après avoir créé notre Custom Post Type "Product", on se rend compte que, contrairement à un Post
classique, un produit devrait avoir un prix. Il lui manque donc cette information.

On peut donc dire à ACF d'ajouter un nouveau champs "prix" qui s'appliquera quand:
>> "type de publication" -- "est égale à" -- "Produit"

A présent lors de la création/modification d'un produit, un champs supplémentaire apparaîtera en bas de page.

Problème: comment récupérer cette information depuis un fichier php ?
Avec la fonction "get_field" ! (ou "the_field()")

```php
<?php if (have_posts): while (have_posts): the_post() ?>
    <?php the_title() ?>
    <?= get_field('price') ?> // On récupère (et affiche) la valeur du champs "price" de notre post "product"
<?php endwhile; endif; ?>
```

### Création d'Options
Les options sont des données variables et manipulables depuis le backoffice et que l'on met à disposition dans l'intégralité
de l'application.

En base de données, vous trouverez toutes vos options dans la tables wp-options.

On note que toutes les options ont une clé et une valeur:
clé => valeur
'siteurl' => monsite.fr

Pour créer des options, il nous faut tout d'abord créer le menu qui permettra de gérer ces options.

Pour ce faire, nous devons utiliser le hook "admin_menu".
````php
// Je me branche sur le hook "admin_menu" pour le modifier
add_action('admin_menu', 'ajout_menu_combat');

// Je définis comment on accède à ma page d'options de puis le menu
function ajout_menu_combat() {
    add_options_page(
        "Titre de la page",
        "Titre du menu",
        "manage_options", // Capabilities (les permissions)
        "slug_du_menu",
        'render_menu_combat' // Function d'affichage de la page
    );
}

// Je définis le contenu de ma page d'options
function render_menu_combat() {
    echo "Le contenu de ma page d'options !!"
}


````

On va commencer par créer un formulaire sur notre page
```php
    function render_menu_combat()
    {
    // On peut fermer PHP ici pour écrire du HTML plus librement
        ?>
        <h1>Gestion de l'agence</h1>

        <form action="options.php" method="post">
            <?php
            // On prépare le formulaire et on le sécurise
            settings_fields('combat_option');
            
            // On remplis notre formulaire avec les champs que l'on a défini
            // pour nos options
            do_settings_sections('combat_option');
            
            // On laisse WP générer le bouton de soumission
            submit_button(); 
            ?>
        </form>
        <?php
    }
```

Le problème étant que les champs de formulaires que l'on injecte avec 'do_settings_sections()' n'existent pas !

Il va donc falloir les créer !

````php
// On se branche sur "admin_init"
add_action('admin_init', 'register_combat_settings']);

function register_combat_settings() 
{
        register_setting(
        'combat_options', // Nom de notre Groupe
        'combat_starting_hp', // Le nom de l'option que l'on veut enregistrer
        [
            'default' => 100, // On peut passer une valeur par défaut
        ]);
        
        
        // Création d'une section du formulaire
        add_settings_section(
            'combat_options_section1', // Nom de la section
            'Titre de la section', // Titre
            function () { // Callback qui doit afficher quelque chose
                echo 'Petit message de présentation de la section';
            },
            'combat_options' // nom du Group
        );
        
        // Création d'un champs du formulaire
        add_settings_field(
            'combat_options_initialhp',
            'Horaires d\'ouverture',
            function () {
                ?>
                <textarea name="combat_initialhp" cols="30" rows="10"><?= get_option('combat_initialhp') ?></textarea>
                <?php
            },
            'combat_options',
            'combat_options_section1',
        );
}


````

### Shortcodes

Quand on créé un thème ou un plugin, il peut être très pratique de se créer des shortcodes afin d'exposer certaines fonctions
de notre programme.

````php
// On commence par créer une fonction qui retourne une vue HTML, ou du texte
function dire_bonjour(): string {
    return 'Bonjour !!';
}

// Il faut ensuite enregistrer cette fonction en tant que "shortcode"
add_shortcode('bonjour', 'dire_bonjour');

// A présent, je peux l'invoquer depuis n'importe où dans mon code ou même depuis le contenu d'un Post
do_shortcode('[bonjour]');
// Attention à ne pas oublier les crochets !


// Si vous avez besoin de passer des paramètres c'est un peu plus délicat
add_shortcode('qqch', 'dire_quelquechose');

function dire_quelquechose($atts): string
{
        $atts = shortcode_atts(
        // On définie des valeurs par défault si besoin
            [
                'debut' => 'Coucou ',
                'fin' => 'les petits amis !!'
            ],
            $atts,
            'qqch' // nom du shortcode
        );
        return $debut . $fin;
}
// Usage
do_shortcode('[qqch debut="Hello " fin="world!!"]');
// Résultat: "Hello work!!"


````

### POO et Wordpress
Par propreté et afin de mieux organiser son code, je vous recommande chaudement d'installer composer et l'autoloader.

L'idée et d'utiliser un fichier de point d'entrée (functions.php dans votre thème, ou le fichier qui porte le nom de votre plugin le cas échéant) et 
de simplement y importer les classes dont vous avez besoin qui contiennent les différents actions à effectuer.

Par exemple :

````php
require 'vendor/autoload.php'; // On importe l'autoload 
use Sanitizer\Sanitizer; // On importe chaque classe dont on a besoin

Sanitizer::init(); // Nos classes ont chacune une méthode static qui permet d'initialiser leur logique interne

//Sanitizer.php
namespace Sanitizer;

class Sanitizer
{
      
    public static function init()
    {
        add_filter('sanitize_file_name', [self::class, 'sanitize_french_filename'], 10, 1);
    }

    public static function sanitize_french_filename(string $filename)
    {
         // Votre code
    }
}
````

Cela permet d'avoir toutes les fonctions liés à une fonctionnalité précise dans le même fichier et de mieux s'y retrouver.

Dans le cas d'un thème ou d'un plugin ambitieux, c'est inestimable et cela rendra le code beaucoup plus simple à maintenir !

## Création de plugin

### A quoi servent les plugins WP ?

Les plugins WordPress sont des extensions logicielles qui ajoutent des fonctionnalités supplémentaires à un site Web
créé avec WordPress. Ils permettent d'étendre les capacités de base de WordPress en ajoutant des fonctionnalités
spécifiques, sans avoir besoin de modifier le code source du noyau WordPress lui-même. Voici une explication détaillée
de l'utilité des plugins WordPress :

1. **Personnalisation et fonctionnalités spécifiques** : Les plugins permettent de personnaliser votre site Web selon
   vos besoins spécifiques. Par exemple, si vous souhaitez ajouter un formulaire de contact, un calendrier d'événements,
   un système de réservation, des galeries d'images avancées ou une boutique en ligne, vous pouvez simplement installer
   les plugins correspondants pour obtenir ces fonctionnalités sans écrire de code complexe.

2. **Facilité d'utilisation** : La plupart des plugins WordPress sont conçus pour être faciles à installer, configurer
   et utiliser. Vous n'avez pas besoin d'être un développeur expérimenté pour les utiliser. En quelques clics, vous
   pouvez ajouter de nouvelles fonctionnalités à votre site Web sans devoir vous plonger dans le code.

3. **Économie de temps et d'argent** : Les plugins sont souvent plus économiques que le développement personnalisé. Au
   lieu de devoir embaucher un développeur pour créer une fonctionnalité spécifique à partir de zéro, vous pouvez
   utiliser un plugin existant, qui est généralement moins cher et vous fait gagner du temps.

4. **Mises à jour et support** : Les développeurs de plugins mettent généralement à jour leurs produits pour s'assurer
   qu'ils restent compatibles avec les dernières versions de WordPress et qu'ils sont sécurisés. De plus, de nombreux
   plugins sont accompagnés d'un support technique, ce qui peut être très utile si vous rencontrez des problèmes ou si
   vous avez des questions.

5. **Extensions pour les thèmes** : Les plugins peuvent ajouter des fonctionnalités avancées aux thèmes WordPress. Par
   exemple, un plugin de mise en page vous permet de créer des mises en page complexes et personnalisées, ce qui est
   souvent difficile à réaliser avec le thème seul.

6. **SEO (Optimisation pour les moteurs de recherche)** : Certains plugins sont spécialement conçus pour améliorer le
   référencement de votre site Web. Ils peuvent vous aider à optimiser vos pages pour les moteurs de recherche, créer
   des sitemaps, gérer les balises méta, etc.

7. **Sécurité** : Les plugins peuvent également améliorer la sécurité de votre site Web en ajoutant des fonctions de
   protection contre les attaques potentielles, la détection des logiciels malveillants, le filtrage des spams et bien
   plus encore.

8. **Intégrations tierces** : Certains plugins permettent d'intégrer facilement des services tiers tels que les médias
   sociaux, les plateformes de marketing par email, les services d'analyse, les systèmes de paiement, etc.

9. **Communauté active** : La communauté WordPress est très active dans le développement de plugins. Vous pouvez trouver
   des milliers de plugins gratuits et payants pour répondre à presque tous les besoins.

Cependant, il est essentiel de garder à l'esprit que l'utilisation de trop de plugins peut ralentir votre site Web et
créer des conflits entre eux. Il est donc recommandé d'utiliser uniquement les plugins nécessaires et de s'assurer
qu'ils sont régulièrement mis à jour pour garantir la stabilité et la sécurité de votre site.

### Plugins les plus populaires

1. **Yoast SEO** : Ce plugin est l'un des plugins de référencement les plus utilisés. Il aide à optimiser le contenu de
   votre site pour les moteurs de recherche en vous donnant des suggestions pour améliorer votre référencement, des
   fonctionnalités de création de sitemaps XML, de gestion des balises méta, etc.

2. **Akismet** : Ce plugin est un outil anti-spam qui protège votre site WordPress des commentaires indésirables et du
   spam.

3. **WooCommerce** : Il s'agit d'un plugin e-commerce populaire qui transforme votre site WordPress en une boutique en
   ligne entièrement fonctionnelle. Il offre des fonctionnalités de gestion des produits, des paiements, des
   expéditions, etc.

4. **Contact Form 7** : Ce plugin permet de créer facilement des formulaires de contact personnalisables pour votre
   site, sans nécessiter de connaissances en programmation.

5. **Jetpack** : Jetpack est un plugin polyvalent qui offre des fonctionnalités de performance, de sécurité, de partage
   social, de statistiques, de sauvegarde, etc.

6. **Wordfence Security** : Il s'agit d'un plugin de sécurité complet qui protège votre site contre les attaques de
   pirates, les logiciels malveillants, les tentatives de connexion frauduleuses, etc.

7. **Elementor** : C'est un constructeur de pages glisser-déposer qui permet de créer des mises en page avancées et
   personnalisées pour vos pages et articles WordPress.

8. **UpdraftPlus** : Ce plugin de sauvegarde vous permet de sauvegarder facilement votre site WordPress et de restaurer
   des sauvegardes en cas de besoin.

9. **Smush** : Smush est un plugin d'optimisation d'images qui compresse automatiquement les images téléchargées pour
   améliorer les performances du site sans compromettre la qualité visuelle.

10. **MonsterInsights** : Ce plugin permet d'intégrer facilement Google Analytics sur votre site WordPress, vous offrant
    ainsi des informations détaillées sur les visiteurs et le trafic de votre site.

11. **Redirection** : Redirection est un gestionnaire de redirections qui vous permet de créer et de gérer facilement
    des redirections 301 pour des pages qui ont été déplacées ou supprimées.

12. **WP Super Cache** : Ce plugin améliore les performances de votre site en générant des fichiers HTML statiques à
    partir de vos pages dynamiques, ce qui réduit le temps de chargement.

13. **All in One SEO Pack** : Un autre plugin populaire pour l'optimisation des moteurs de recherche qui propose des
    fonctionnalités similaires à Yoast SEO.

Ces plugins sont parmi les plus populaires, mais il en existe des milliers d'autres pour répondre à des besoins
spécifiques. Lors du choix d'un plugin, assurez-vous de vérifier les avis, les évaluations et la compatibilité avec
votre version de WordPress pour vous assurer qu'ils répondent bien à vos besoins et qu'ils sont régulièrement mis à
jour.

### Mise en place

- Télécharger une base wordpress sur [le site officiel](https://wordpress.org/download/).
- Créer une base de données sous Wamp qui servira à ce projet
- Télécharger [le thème Understrap sur le github](https://github.com/understrap/understrap)
- Inclure le thème dans /mon-projet/wp-content/themes/ et le définir depuis la partie admin
- Créer un nouveau dossier dans /mon-projet/wp-content/plugins/
- Dans ce dossier, créer un fichier php portant le même nom que le dossier (IMPORTANT), il servira de point d'entrée à
  votre plugin.
- Ce fichier devra commencer ainsi:

```php
<?php
/*
Plugin Name: Nom du plugin
Plugin URI: Lien vers la page du plugin (facultatif)
Description: Description du plugin
Version: 1.0.0
Author: Votre nom
Author URI: Votre site web (facultatif)
License: (GNU GPLv2 ou supérieure)
*/
```

- Pour Installer un plugin, vous pouvez l'inclure directement dans le dossier "plugins" ou bien le compresser au format
  .zip et l'importer directement depuis la partie admin de votre WP.

- Mettre en place l'autoloader (conseillé !)
  -- faire un composer init dans le projet

```bash
composer init
```

-- modifier composer.json pour que le namespace de notre /src corresponde, de préférence, au nom de notre plugin (
exemple)

```json
// composer.json
{
  "name": "maxime/monsuperplugin",
  "autoload": {
    "psr-4": {
      "MonSuperPlugin\\": "src/"
    }
  },
  "authors": [
    {
      "name": "Maxime",
      "email": "maxime@gmail.com"
    }
  ],
  "require": {}
}
```

- Pour tester, vous pouvez créer une classe dans /src, par exemple la classe Test
- Indiquez que la classe Test se trouve dans le namespace "MonSuperPlugin"

```php
<?php
namespace MonSuperPlugin;

class Test
{
    // mon code
}
```

- N'oubliez pas de mettre l'autoloader à jour

```bash
composer dump-autoload
```

- Dans votre fichier principal (celui qui porte le nom de votre plugin), ajoutez ceci

```php
require 'vendor/autoload.php';
use MonSuperPlugin\Test;

$test = new Test();
```

### Debug

Plugin "queryMonitor" pour debbug
