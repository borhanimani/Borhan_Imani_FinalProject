<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\SystemInformation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name')
            ->add('moredetails')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('systeminformation', EntityType::class, [
                'class' => SystemInformation::class,
                'choice_label' => function (SystemInformation $systemInformation) {
                    return $systemInformation->getInfo();
                },
                'multiple' => true,
            ])
            ->add('price');
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
