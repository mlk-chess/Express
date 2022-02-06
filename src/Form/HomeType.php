<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureStationInput', TextType::class, [
                'attr' => ['id' => 'departureStationInput',
                    'placeholder' => 'Gare de départ'
                ],
                'label' => false
            ])
            ->add('arrivalStationInput', TextType::class, [
                'attr' => ['id' => 'arrivalStationInput',
                    'placeholder' => 'Gare d\'arrivée'
                ],
                'label' => false
            ])
            ->add('firstTime', TimeType::class, [
                'label' => 'A partir de : '
            ])
        ;
    }
}
