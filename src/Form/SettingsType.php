<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'label' => false,
                'required' => true,
                'attr' => ['accept' => '.jpg, .png', 'class' => 'form-control'],
            ])
        ;
    }
}