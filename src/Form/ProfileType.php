<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('address',TextType::class,  [
                'label' => 'Adresse',
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('city',TextType::class,  [
                'label' => 'Ville',
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('zipCode',TextType::class,  [
                'label' => 'Code postal',
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('phoneNumber',TextType::class,  [
                'label' => 'Numéro de téléphone',
                'attr' => ['class' => 'form-control mb-3']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
