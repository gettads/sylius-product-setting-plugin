<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Contract\Product;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ProductQuantityMultiplierPromoAwareTrait
{
    #[ORM\Column(
        name: 'promo_quantity_multiplier',
        type: Types::INTEGER,
        nullable: false,
        options: ['default' => ProductQuantityMultiplierPromoAwareInterface::DEFAULT_VALUE])
    ]
    private int $promoQuantityMultiplier = ProductQuantityMultiplierPromoAwareInterface::DEFAULT_VALUE;

    public function getPromoQuantityMultiplier(): int
    {
        return $this->promoQuantityMultiplier;
    }

    public function setPromoQuantityMultiplier(int $promoQuantityMultiplier): void
    {
        $this->promoQuantityMultiplier = $promoQuantityMultiplier;
    }

    public function hasPromoQuantityMultiplier(): bool
    {
        return ($this->promoQuantityMultiplier ?? 0) > 0;
    }
}
