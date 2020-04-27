Instalación
============

Paso 1: Descarga el Bundle
---------------------------

Añade al composer.json el repositorio de git
```
    "repositories": [
        {
            "type" : "git",
            "url" : "git@bitbucket.org:the-cocktail/sulumegamenubundle.git"
        }
    ],
```

Y añadelo como dependencia a tu proyecto

```console
$ composer require the-cocktail/megamenu-bundle
```

Paso 2: Activar el Bundle
-------------------------

Debes registrar el bundle en el archivo `config/bundles.php` de tu proyecto:

```php
<?php
// config/bundles.php
return [
    // ...
    TheCocktail\Bundle\MegaMenuBundle\SuluMegamenuBundle::class => ['all' => true],       
    // ...
];
```

Paso 2: Cofigurar el Bundle
-------------------------

Importa las rutas del admin en `config/routes/sulu_admin.yaml` :

```yaml
sulu_megamenu_api:
    resource: "@SuluMegamenuBundle/Resources/config/routing_api.yaml"
    type: rest
    prefix: /admin/api
```

Añade el archivo `config/packages/sulu_megamenu.yaml` con la configuración de los distintos menus:

```yaml
sulu_megamenu:
    menus:
        header_top:
            title: 'Header Top'
        header:
            title: 'Header'
        footer:
            title: 'Footer'
        footer_bottom:
            twig_global: false # Opcional, este menu no estará disponible en la variable global sulu_megamenu
            title: 'Footer Bottom'
```

Ahora podrás entrar en el backend de Sulu y configurar los menús. 

Para acceder a los menús explora la variable global de Twig `sulu_megamenu` para acceder a los menus:

Ejemplo:

```twig
{% for menu in sulu_megamenu.header_top %}
    <a href="{{ menu.title }}" url="{{ menu.url }}>{{ menu.title }}</a>
{% endfor %}
```

Enjoy it!
