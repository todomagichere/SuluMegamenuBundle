<?php

namespace TheCocktail\Bundle\MegaMenuBundle\DependencyInjection;

use Sulu\Component\Content\Compat\Structure\SnippetBridge;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

class SuluMegamenuExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('sulu_admin')) {
            $container->prependExtensionConfig(
                'sulu_admin',
                [
                    'lists' => [
                        'directories' => [
                            __DIR__ . '/../Resources/config/lists',
                        ],
                    ],
                    'forms' => [
                        'directories' => [
                            __DIR__ . '/../Resources/config/forms',
                        ],
                    ],
                    'resources' => [
                        'megamenu' => [
                            'routes' => [
                                'list' => 'sulu_megamenu.get_megamenus',
                                'detail' => 'sulu_megamenu.get_megamenu',
                            ],
                        ],
                    ],
                ]
            );
        }

        if ($container->hasExtension('sulu_core')) {
            $container->prependExtensionConfig(
                'sulu_core',
                [
                    'content' => [
                        'structure' => [
                            'required_properties' => [
                                'megamenu' => ['title'],
                            ],
                            'paths' => [
                                'megamenu' => [
                                    'path' => '%kernel.project_dir%/config/templates/megamenus',
                                    'type' => 'megamenu',
                                ],
                            ],
                            'default_type' => [
                                'megamenu' => 'default',
                            ],
                        ],
                    ],
                ]
            );
        }
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('sulu_megamenu.menus', $config['menus']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
