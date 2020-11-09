# Sulu Megamenu Bundle

----

Create complex tree menus in Sulu with sections, image items, external url, custom url, etc..
 
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
            title: 'Footer Bottom'
```
### Permissions
Make sure you've set the correct permissions in the Sulu backend for this bundle!

`Settings > User Roles`


## Twig Functions

#### sulu_megamenu_render

```twig
   {{ sulu_megamenu_render('header', request.webspaceKey, app.request.locale)  }}
```

Or specify template

```twig
   {{ sulu_megamenu_render('header', request.webspaceKey, app.request.locale, 'menu/header.html.twig')  }}
```

#### sulu_megamenu_get

```twig
{% for item in sulu_megamenu_get('header', request.webspaceKey, app.request.locale) %}
    <ul>
      {% for item in items %}
        <li>
          {% if item.url %}
            <a href="{{ item.url }}" title="{{ item.title }}">{{ item.title }}</a>
          {% else %}
            {{ item.title }}
          {% endif %}
          {% if item.hasChildren %}
            {% include '@SuluMegamenu/section.html.twig' with {'items': item.children } %}
          {% endif %}
        </li>
      {% endfor %}
    </ul>
{% endfor %}
```
Enjoy it!
