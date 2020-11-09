# Sulu Megamenu Bundle

----

Create complex tree menus in Sulu with sections, image items, external url, custom url, etc..
 
## Installation

Add SuluMegamenuBundle in your composer.json:

```shell script
  composer require the-cocktail/sulu-megamenu-bundle
```
### Register the bundle

Register the bundle in your `config/bundles.php`:

```php
<?php
// config/bundles.php
return [
    // ...
    TheCocktail\Bundle\MegaMenuBundle\SuluMegamenuBundle::class => ['all' => true],       
    // ...
];
```

### Configure the routing

```yaml
# config/routes/sulu_admin.yaml

sulu_megamenu_api:
    resource: "@SuluMegamenuBundle/Resources/config/routing_api.yaml"
    type: rest
    prefix: /admin/api
```

### Configure SuluMegamenu

Add `config/packages/sulu_megamenu.yaml` with your desired menus:

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
            title: 'Footer Bottom'
```
### Permissions
Make sure you've set the correct permissions in the Sulu backend for this bundle!

`Settings > User Roles`


## Twig Functions

#### sulu_megamenu_render

This function will render the [default template](./Resources/views/menu.html.twig)
```twig
   {{ sulu_megamenu_render('header', request.webspaceKey, app.request.locale)  }}
```

Custom template as argument 

```twig
   {{ sulu_megamenu_render('header', request.webspaceKey, app.request.locale, 'menu/header.html.twig')  }}
```

#### sulu_megamenu_get

Get items to reuse in diferent context
```twig
{% set items = sulu_megamenu_get('header', request.webspaceKey, app.request.locale) %}

{% include 'menu/desktop.html.twig' %}
{% include 'menu/mobile.html.twig' %}
```


### Enjoy it!
