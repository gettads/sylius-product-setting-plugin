<?php

declare(strict_types=1);

namespace Gtt\SyliusProductSettingPlugin\Form\Extension;

use Sylius\Bundle\AdminBundle\Form\Type\ProductVariantType as AdminProductVariantType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

class ProductVariantTypeExtension extends AbstractTypeExtension
{
    public const QUANTITY_MULTIPLIER_MIN = 0;
    public const QUANTITY_MULTIPLIER_MAX = 1000_000;

    /**
     * @inheritDoc
     */
    // phpcs:ignore
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('quantityMultiplier', IntegerType::class, [
            'attr' => ['min' => self::QUANTITY_MULTIPLIER_MIN],
            'label' => 'sylius.ui.quantity_miltiplier',
            'constraints' => [
                new Range([
                    'min' => self::QUANTITY_MULTIPLIER_MIN,
                    'max' => self::QUANTITY_MULTIPLIER_MAX,
                    'groups' => 'sylius',
                ]),
            ],
        ]);
    }

    /**
     * @return iterable<string>
     */
    public static function getExtendedTypes(): iterable
    {
        return [
            ProductVariantType::class,
            AdminProductVariantType::class,
        ];
    }
}
