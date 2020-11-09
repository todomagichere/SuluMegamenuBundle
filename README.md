# Sulu Megamenu Bundle

----

Create complex menus in Sulu 
 
## Installation

Add SuluMegamenuBundle in your composer.json:

```shell script
  composer requiere the-cocktail/sulu-megamenu-bundle
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
            twig_global: false # Opcional, este menu no estará disponible en la variable global sulu_megamenu
            title: 'Footer Bottom'
```
### Permissions
Make sure you've set the correct permissions in the Sulu backend for this bundle!

`Settings > User Roles`


Para acceder a los menús explora la variable global de Twig `sulu_megamenu` para acceder a los menus:

Ejemplo:

```twig
{% for menu in sulu_megamenu.header_top %}
    <a href="{{ menu.title }}" url="{{ menu.url }}>{{ menu.title }}</a>
{% endfor %}
```

Enjoy it!
