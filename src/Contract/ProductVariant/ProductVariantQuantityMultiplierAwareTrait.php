<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Contract\ProductVariant;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ProductVariantQuantityMultiplierAwareTrait
{
    #[ORM\Column(
        name: 'quantity_multiplier',
        type: Types::INTEGER,
        nullable: false,
        options: ['default' => ProductVariantQuantityMultiplierAwareInterface::DEFAULT_VALUE])
    ]
    private int $quantityMultiplier = ProductVariantQuantityMultiplierAwareInterface::DEFAULT_VALUE;

    public function getQuantityMultiplier(): int
    {
        return $this->quantityMultiplier;
    }

    public function setQuantityMultiplier(int $quantityMultiplier): void
    {
        $this->quantityMultiplier = $quantityMultiplier;
    }

    public function hasQuantityMultiplier(): bool
    {
        return ($this->quantityMultiplier ?? 0) > 0;
    }
}
