<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['id' => 'customer_create_form_name']
            ])
            ->add('email', null, [
                'attr' => ['id' => 'customer_create_form_email']
            ])
            ->add('address', null, [
                'attr' => ['id' => 'customer_create_form_address']
            ])
            ->add('phone', null, [
                'attr' => ['id' => 'customer_create_form_phone']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
