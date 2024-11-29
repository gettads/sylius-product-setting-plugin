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
        assert($order instanceof OrderInterface);

        if (false === $order->canBeProcessed()) {
            return;
        }

        foreach ($order->getItems() as $orderItem) {
            assert($orderItem instanceof OrderItemInterface);

            if (true === $this->isValidQuantityByMultiplier($orderItem)) {
                continue;
            }

            $this->orderItemQuantityModifier->modify(
                $orderItem,
                $orderItem->getVariant()->getQuantityMultiplier(),
            );
        }
    }

    private function isValidQuantityByMultiplier(OrderItemInterface $orderItem): bool
    {
        $productVariant = $orderItem->getVariant();

        if (
            !$productVariant instanceof ProductVariantQuantityMultiplierAwareInterface
            || !$productVariant->hasQuantityMultiplier()
        ) {
            return true;
        }

        return $orderItem->getQuantity() % $productVariant->getQuantityMultiplier() === 0;
    }
}
