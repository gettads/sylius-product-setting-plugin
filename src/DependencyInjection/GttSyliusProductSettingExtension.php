<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

class GttSyliusProductSettingExtension extends Extension implements PrependExtensionInterface
{
    public const RESOURCE_ALIAS = 'gtt_sylius_product_setting.resource';

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(Configuration::CONFIG_DIR));
        $loader->load('services.php');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->processConfiguration(new Configuration(), $container->getExtensionConfig($this->getAlias()));

        if ($container->hasExtension('twig')) {
            $twigConfig = $container->getExtensionConfig('twig');
            $container->prependExtensionConfig('twig', [
                'paths' => array_merge(array_pop($twigConfig)['paths'] ?? [], [
                    Configuration::TEMPLATES_DIR => 'GttSyliusProductSettingPlugin',
                ]),
            ]);
        }

        if ($container->hasExtension('framework')) {
            $container->prependExtensionConfig('framework', [
                'translator' => [
                    'default_path' => Configuration::TRANSLATIONS_DIR,
                ],
                'serializer' => [
                    'mapping' => [
                        'paths' => [Configuration::API_SERIALIZATION_DIR],
                    ],
                ],
            ]);
        }

        if ($container->hasExtension('sylius_twig_hooks')) {
            $container->prependExtensionConfig('sylius_twig_hooks', [
                'hooks' => [
                    'sylius_admin.product.create.content.form.sections.inventory' => [
                        'quantity_multiplier' => [
                            'template' => '@GttSyliusProductSettingPlugin/EventBlock/Admin/quantity_multiplier.html.twig',
                        ],
                    ],
                    'sylius_admin.product.update.content.form.sections.inventory' => [
                        'quantity_multiplier' => [
                            'template' => '@GttSyliusProductSettingPlugin/EventBlock/Admin/quantity_multiplier.html.twig',
                        ],
                    ],
                    'sylius_shop.product.show.content.info.summary.add_to_cart' => [
                        'quantity_multiplier' => [
                            'template' => '@GttSyliusProductSettingPlugin/EventBlock/Shop/promo_notifier.html.twig',
                        ],
                    ],
                ],
            ]);
        }

        if ($container->hasExtension('api_platform')) {
            $container->prependExtensionConfig(
                'api_platform',
                [
                    'mapping' => [
                        'paths' => [Configuration::API_RESOURCES_DIR],
                    ],
                ],
            );
        }
    }

    /**
     * @inheritDoc
     * 
     * @phpstan-ignore-next-line
     */
    public function getConfiguration(array $config, ContainerBuilder $container): ConfigurationInterface
    {
        return new Configuration();
    }
}
