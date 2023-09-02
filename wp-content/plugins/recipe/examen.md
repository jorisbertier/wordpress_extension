## Question 1
Les plugins sont des extensions qui ajoutent des fonctionnalités supplémentaire à un site web crée avec wordpress.
Son rôle est d'ajouter des fonctionnalités spécifiques(recette de cuisine, censure de mot, etc...)

## Question 2
Les étapes:

- Créer un nouveau dossier dans/wp-content/plugins/
- Dans ce dossier, créer un fichier .php ayant un nom identique à celui du dossier (IMPORTANT), il servira de point d'entrée à
  votre plugin

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

- Mettre en place l'autoloader (conseillé !)
  -- faire un composer init dans le projet
  -- modifier composer.json pour que le namespace de notre /src corresponde, de préférence, au nom de notre plugin 

## Question 3
Pour cela il faut:
- Allez dans l’onglet « Extensions » dans l'interface du menu de gauche de l’écran d’administration
- Cliquez sur 'Ajouter une nouvelle' 

## Question 4
Un thème wordpress est l'apparence du site tandis que un plugin contrôle le comportement du site

## Question 5
- Allez dans l’onglet « Extensions » dans l'interface du menu de gauche de l’écran d’administration
- Appuyer sur activer/descativer directement sur le plugin en question

## Question 6
- mise à jour régulierement du plugin
- 1 seule fonctionnalité par plugin
- faire des tests du plugin/ vérifier sa comptabilité avec les nouvelles versions de wordpress

## Question 7
-  Lors d'un conflit entre plugins il ous faudra gèrer le cas manuellement en cherchant nous même les plugins concernés, en activant et déscativant les plugins pour les isoler et les trouver.

## Question 8
Quelles sont les principales sections du fichier principal d'un plugin WordPress et quel est le rôle de chacune de ces sections

dans le fichier principal du plugin portant le même nom que le dossier
- section obligatoire qui contient les différentes informations concernant le plugin : nom, auteur, version etc....
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
- autoloader à inclure( pas nécessaire mais recommandé si autoloader utilisé)
require 'vendor/autoload.php';


## Question 9
Les actions est un code que l'on exécute de WordPress à un moment précis.
Les filtres permettent de modifier les données avant de les affichées et de la retourné.

## Question 10
 Quelles sont les options de distribution d'un plugin une fois qu'il a été développé, et comment les utilisateurs peuvent-ils installer un plugin sur leur site WordPress?
Options de distribution sont:

- dépôt en ligne sur wordpress pour un accès à tout les utilisateurs( peu également être déposé de manière gratuite ou partiellement gratuit)
- mise en ligne pour une vente du plugin
- mise en place place du plugin pour usage personnel ou en interne dans une société

Pour installer le plugin il y a 3 manières:
- en récupèrer un en ligne qui est déposé sur wordpress dans l'onglet extension du menu wordpress puis l'activer
- ajouter directement depuis l'interface wordpress, extensions/ ajouter/ téléverser une extension / et choisir le fichier contenant le plugin
- directement récupérer un dossier contenant le plugin, et le déposer dans /wp-content/plugins/, puis ensuite il est présent dans les extensions du menu wordpress


## filtre présent dans ACF

