<?php

namespace App\Form;

use App\Form\Type\RowRepeaterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ShoppingListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add(
                'items',
                CollectionType::class,
                array(
                    'entry_type' => RowRepeaterType::class,
                    'entry_options' => [
                        'label' => false
                    ],
                    'allow_add' => true,
                    'prototype' => true,
                    'prototype_name' => 'items',
                    'label' => false,
                    'attr' => ['class' => 'row-repeater']
                )
            );
    }
}
