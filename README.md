# BOLENGE-PHP Framework v0.0.1

`Bolenge-php` est un framework développé pour mettre à l'aise les développeurs `JS` voulant faire du `PHP` ou encore de développeurs `PHP` séduit par le fameux langage `Javascript` mais tout étant amoureux du `PHP` aussi. Pour leur permettre d'avoir les même concepts, c'est-à-dire développant en `PHP` mais ayant tandance d'être dans le monde du `JS`, avec ses `callback` et l'utilisation des `request` et `response` en `NodeJS`. Vu que moi même aussi je ne voulais trop m'embrouiller à maitriser plusieurs concepts vis à vis de chaque langage, je me suis dit mais pourquoi ne pas développer une technologie ou la logique, ou la squellete de l'application est toujours la même tant en `Javascript` qu'en `PHP`.

## Installation

Ceci est une application basée sur [Composer](https://composer.org/)

```bash
$ composer require bolenge/bolenge-php
```

## API

L'utilisation de ce framework est basée sur [ExpressJS](https://expressjs.com/) et de [Laravel](https://laravel.org/).
Il est composé de plusieurs dossiers chacun jouant un role important.

`app` est le dossier où on développe son application, il contient quatres sous dossiers dont

1. `config` qui contient les différents fichier de configuration de l'application.

> `config > app.php` Fichier de la configuration de l'application
> `config > database.php` Contient la configuration de la base de données
> `config > DB.php` Objet faisant la même chose que `database.php` 
> `config > namespace.php` Tableau contenant les namespace des objets
> `config > path.php` Il gère les paths de dossiers

*Note* Au cas où vous aurrez besoin d'ajouter aussi vos configurations à vous vous pouvez les placer dans ce même dossier. Pour récurer les valeurs de ces configurations on utilise un `helper` (une fonction) appelé `config($conf = 'fileconfig.keyelementconfig')` se trouvant dans le dossier `bootstrap/helper.php` cet helper recoit un paramètre string, écrit sous cette forme là `fileconfig` c'est le nom du fichier contenant la configuration, et `keyelementconfig` c'est la clé dans le tableau de la configuration.