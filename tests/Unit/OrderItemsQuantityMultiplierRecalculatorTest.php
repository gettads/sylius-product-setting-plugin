<?php

declare(strict_types=1);

namespace Tests\Gtt\SyliusProductSettingPlugin\Unit;

use Doctrine\Common\Collections\ArrayCollection;
use Gtt\SyliusProductSettingPlugin\Contract\ProductVariant\ProductVariantQuantityMultiplierAwareInterface;
use Gtt\SyliusProductSettingPlugin\Service\OrderProcessing\OrderItemsQuantityMultiplierRecalculator;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Order\Model\OrderItemInterface as BaseOrderItemInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;

class OrderItemsQuantityMultiplierRecalculatorTest extends TestCase
{
    private const DEFAULT_MULTIPLIER = 10;

    /**
     * @test
     */
    public function testProcessWithCorrectQuantity(): void
    {
        $orderProcessor = $this->createOrderProcessor();

        $order = $this->createConfiguredMock(
            OrderInterface::class,
            [
                'canBeProcessed' => true,
                'getItems' => new ArrayCollection([
                    $this->createConfiguredMock(OrderItemInterface::class, [
                        'getQuantity' => self::DEFAULT_MULTIPLIER,
                        'getVariant' => new class extends ProductVariant implements ProductVariantQuantityMultiplierAwareInterface {
                            public function getQuantityMultiplier(): int
                            {
                                return self::DEFAULT_VALUE;
                            }
                            public function setQuantityMultiplier(int $quantityMultiplier): void
                            {
                                return;
                            }
                            public function hasQuantityMultiplier(): bool
                            {
                                return true;
                            }
                        },
                    ]),
                ]),
            ],
        );

        $orderProcessor->process($order);

        $this->assertNotNull($order);
    }

    /**
     * @test
     */
    public function testProcessWithInvalidQuantity(): void
    {
        $orderProcessor = $this->createOrderProcessor();

        $order = $this->createConfiguredMock(
            OrderInterface::class,
            [
                'canBeProcessed' => true,
                'getItems' => new ArrayCollection([
                    $this->createConfiguredMock(OrderItemInterface::class, [
                        'getQuantity' => self::DEFAULT_MULTIPLIER / 2,
                        'getVariant' => new class extends ProductVariant implements ProductVariantQuantityMultiplierAwareInterface {
                            public function getQuantityMultiplier(): int
                            {
                                return self::DEFAULT_VALUE;
                            }
                            public function setQuantityMultiplier(int $quantityMultiplier): void
                            {
                                return;
                            }
                            public function hasQuantityMultiplier(): bool
                            {
                                return true;
                            }
                        },
                    ]),
                ]),
            ],
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('MODIFIED');
        
        $orderProcessor->process($order);
    }

    private function createOrderProcessor(): OrderItemsQuantityMultiplierRecalculator
    {
        $orderItemQuantityModifier = new class implements OrderItemQuantityModifierInterface {
            public function modify(BaseOrderItemInterface $orderItem, int $targetQuantity): void {
                throw new \RuntimeException('MODIFIED');
            }
        };

        return new OrderItemsQuantityMultiplierRecalculator($orderItemQuantityModifier);

        return $recalculator;
    }
}
