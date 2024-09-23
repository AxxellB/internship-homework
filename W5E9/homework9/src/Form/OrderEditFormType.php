<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('order_date', null, [
                'widget' => 'single_text',
                'attr' => ['id' => 'order_edit_form_order_date']
            ])
            ->add('total', null, [
                'attr' => ['id' => 'order_edit_form_total']
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => OrderStatus::Pending,
                    'Completed' => OrderStatus::Completed,
                    'Cancelled' => OrderStatus::Cancelled,
                ],
                'choice_value' => function (?OrderStatus $orderStatus) {
                    return $orderStatus ? $orderStatus->value : '';
                },
                'attr' => ['id' => 'order_create_form_status'],
            ])
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'name',
                'attr' => ['id' => 'order_edit_form_customer']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
