<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Contract\ProductVariant;

interface ProductVariantQuantityMultiplierAwareInterface
{
    /**
     * Test implementation for test goals: all product variants will have multiplier = 10.
     */
    public const DEFAULT_VALUE = 10;
    
    public function getQuantityMultiplier(): int;
    
    public function setQuantityMultiplier(int $quantityMultiplier): void;
    
    public function hasQuantityMultiplier(): bool;
}