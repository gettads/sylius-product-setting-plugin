<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Service\OrderProcessing;

use Gtt\SyliusProductSettingPlugin\Contract\ProductVariant\ProductVariantQuantityMultiplierAwareInterface;
use Sylius\Component\Core\Calculator\ProductVariantPricesCalculatorInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Webmozart\Assert\Assert;

final class OrderItemsQuantityMultiplierRecalculator implements OrderProcessorInterface
{
    public function __construct(private readonly OrderItemQuantityModifierInterface $orderItemQuantityModifier)
    {
    }

    public function process(BaseOrderInterface $order): void
    {
        if (!$order->canBeProcessed()) {
            return;
        }

        foreach ($order->getItems() as $orderItem) {
            assert($orderItem instanceof OrderItemInterface);
            
            if (!$this->canOrderItemBeProcessed($orderItem) || $this->isValidQuantityByMultiplier($orderItem)) {
                continue;
            }

            assert($orderItem->getVariant() instanceof ProductVariantQuantityMultiplierAwareInterface);

            $this->orderItemQuantityModifier->modify(
                $orderItem,
                $orderItem->getVariant()->getQuantityMultiplier(),
            );
        }
    }

    private function canOrderItemBeProcessed(OrderItemInterface $orderItem): bool
    {
        $productVariant = $orderItem->getVariant();

        if (
            !$productVariant instanceof ProductVariantQuantityMultiplierAwareInterface
            || !$productVariant->hasQuantityMultiplier()
        ) {
            return false;
        }

        return true;
    }

    private function isValidQuantityByMultiplier(OrderItemInterface $orderItem): bool
    {
        if (!$this->canOrderItemBeProcessed($orderItem)) {
            return true;
        }

        assert($orderItem->getVariant() instanceof ProductVariantQuantityMultiplierAwareInterface);

        return $orderItem->getQuantity() % $orderItem->getVariant()->getQuantityMultiplier() === 0;
    }
}
