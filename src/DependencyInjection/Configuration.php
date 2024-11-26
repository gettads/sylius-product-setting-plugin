<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public const NODE_ROOT = 'gtt_sylius_product_setting';
    public const CONFIG_DIR = __DIR__ . '/../Resources/config';
    public const TEMPLATES_DIR = __DIR__ . '/../Resources/templates';
    public const TRANSLATIONS_DIR = __DIR__ . '/../Resources/translations';
    public const API_RESOURCES_DIR = __DIR__ . '/../Resources/api_resources';
    public const API_SERIALIZATION_DIR = __DIR__ . '/../Resources/serialization';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::NODE_ROOT);
    }
}
