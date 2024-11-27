<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Gtt\SyliusProductSettingPlugin\Form\Extension\ProductVariantTypeExtension;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();
    $services->defaults()->autowire(true);

    $services->set(ProductVariantTypeExtension::class)->tag('form.type_extension');
};
