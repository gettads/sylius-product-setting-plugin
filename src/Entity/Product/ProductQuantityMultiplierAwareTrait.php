<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Contract\Product;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ProductQuantityMultiplierAwareTrait
{
    #[ORM\Column(name: 'quantity_multiplier', type: Types::INTEGER, nullable: false, options: ['default' => 0])]
    private int $quantityMultiplier = 0;

    public function getQuantityMultiplier(): int
    {
        return $this->quantityMultiplier;
    }

    public function setQuantityMultiplier(int $quantityMultiplier): void
    {
        $this->quantityMultiplier = $quantityMultiplier;
    }
}
