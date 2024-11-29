<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Form\Extension;

use Gtt\SyliusProductSettingPlugin\Contract\ProductVariant\ProductVariantQuantityMultiplierAwareInterface;
use Sylius\Bundle\ShopBundle\Form\Type\CartItemType;
use Sylius\Component\Core\Model\OrderItem;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Range;

class CartItemTypeExtension extends AbstractTypeExtension
{
    /**
     * @inheritDoc
     */
    // phpcs:ignore
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $orderItem = $event->getData();
            assert($orderItem instanceof OrderItem);

            $productVariant = $orderItem->getVariant();
            assert($productVariant instanceof ProductVariantQuantityMultiplierAwareInterface);

            $quantity = $orderItem->getQuantity();
            $quantityMultiplier = $productVariant->hasQuantityMultiplier()
                ? $productVariant->getQuantityMultiplier()
                : 1;

            $form->remove('quantity');
            $form->add('quantity', IntegerType::class, [
                'label' => 'sylius.ui.quantity',
                'attr' => [
                    'onkeydown' => 'return false;',
                    'step' => $quantityMultiplier,
                    'min' => $quantityMultiplier,
                    'value' => $quantity < $quantityMultiplier || $quantity % $quantityMultiplier !== 0
                        ? $quantityMultiplier
                        : $quantity,
                ],
            ]);
        });
    }

    /**
     * @return iterable<string>
     */
    public static function getExtendedTypes(): iterable
    {
        return [CartItemType::class];
    }
}
