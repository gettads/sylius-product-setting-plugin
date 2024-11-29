<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Contract\Product;

interface ProductQuantityMultiplierPromoAwareInterface
{
    /**
     * Test implementation for test goals.
     */
    public const DEFAULT_VALUE = 7;
    
    public function getPromoQuantityMultiplier(): int;
    
    public function setPromoQuantityMultiplier(int $quantityMultiplier): void;
    
    public function hasPromoQuantityMultiplier(): bool;
}