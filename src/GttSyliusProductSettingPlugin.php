<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin;

use Gtt\SyliusProductSettingPlugin\DependencyInjection\GttSyliusProductSettingExtension;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @see SyliusPluginTrait
 */
class GttSyliusProductSettingPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function getContainerExtension(): ExtensionInterface
    {
        $this->extension = new GttSyliusProductSettingExtension();

        return $this->extension;
    }
}
