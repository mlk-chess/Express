<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('address',TextType::class,  ['label' => 'Adresse'])
            ->add('city',TextType::class,  ['label' => 'Ville'])
            ->add('zipCode',TextType::class,  ['label' => 'Code postal'])
            ->add('phoneNumber',TextType::class,  ['label' => 'Numéro de téléphone'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
