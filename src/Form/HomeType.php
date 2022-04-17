<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

class HomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departureStationInput', HiddenType::class, [
                'attr' => ['id' => 'departureStationInput'],
                'required' => true
            ])
            ->add('arrivalStationInput', HiddenType::class, [
                'attr' => ['id' => 'arrivalStationInput'],
                'required' => true
            ])
            ->add('date', DateType::class, [
                'label' => 'Le : ',
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control my-3']
            ])
            ->add('time', TimeType::class, [
                'label' => 'A partir de : ',
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control my-3']
            ])
        ;
    }
}