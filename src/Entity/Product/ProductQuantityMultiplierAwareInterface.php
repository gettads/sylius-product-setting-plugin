<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Contract\Product;

interface ProductQuantityMultiplierAwareInterface
{
    public function getQuantityMultiplier(): int;
    
    public function setQuantityMultiplier(int $quantityMultiplier): void;
}