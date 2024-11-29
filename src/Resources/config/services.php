<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Gtt\SyliusProductSettingPlugin\Form\Extension\CartItemTypeExtension;
use Gtt\SyliusProductSettingPlugin\Form\Extension\ProductVariantTypeExtension;
use Gtt\SyliusProductSettingPlugin\Service\OrderProcessing\OrderItemsQuantityMultiplierRecalculator;

return function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();
    $services->defaults()->autowire(true);

    $services
        ->set(ProductVariantTypeExtension::class)
        ->tag('form.type_extension')
    ;
    
    $services
        ->set(CartItemTypeExtension::class)
        ->tag('form.type_extension')
    ;

    $services
        ->set(OrderItemsQuantityMultiplierRecalculator::class)
        ->tag('sylius.order_processor')
    ;
};
