<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['id' => 'edit_product_name'],
            ])
            ->add('price', null, [
                'attr' => ['id' => 'edit_product_price'],
            ])
            ->add('quantity', null, [
                'attr' => ['id' => 'edit_product_quantity'],
            ])
            ->add('description', null, [
                'attr' => ['id' => 'edit_product_description'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => ['id' => 'edit_product_category'],
                'choice_value' => 'name',
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
