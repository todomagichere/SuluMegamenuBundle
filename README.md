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
Update your data with: 

```shell script
bin/console doctrine:schema:update --force
```

Or execute the following SQL: (recomended: use doctrine migrations to generate diff migration)
```sql
CREATE TABLE mm_menuitem (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, resource_key VARCHAR(255) NOT NULL, webspace VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, uuid VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_D6C6460BEA9FDD75 (media_id), INDEX IDX_D6C6460B727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
ALTER TABLE mm_menuitem ADD CONSTRAINT FK_D6C6460BEA9FDD75 FOREIGN KEY (media_id) REFERENCES me_media (id);
ALTER TABLE mm_menuitem ADD CONSTRAINT FK_D6C6460B727ACA70 FOREIGN KEY (parent_id) REFERENCES mm_menuitem (id)
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
   {{ sulu_megamenu_render('header')  }}
```

Custom template as argument 

```twig
   {{ sulu_megamenu_render('header', 'menu/header.html.twig')  }}
```

Additional parameters 

```twig
   {{ sulu_megamenu_render('header', 'menu/header.html.twig', request.webspaceKey, app.request.locale)  }}
```

#### sulu_megamenu_get

Get items to reuse in diferent context
```twig
{% set items = sulu_megamenu_get('header') %}

{% include 'menu/desktop.html.twig' %}
{% include 'menu/mobile.html.twig' %}
```

Additional parameters:
```twig
   {{ sulu_megamenu_get('header', request.webspaceKey, app.request.locale)  }}
```

### Enjoy it!
