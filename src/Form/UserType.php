<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                    'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'attr' => ['class' => 'd-flex mb-3'],
                'first_options' => [
                    'label' => 'Mot de passe',
                    'row_attr' => ['class' => 'ma-4']
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'row_attr' => ['class' => 'ms-4']
                ],
                'invalid_message' => 'Le mot de passe de confirmation ne correspond pas',
                'options' => [
                    'attr' => ['class' => 'form-control']
                ]
            ])
            ->add('address',TextType::class,  [
                'label' => 'Adresse',
                'attr' => ['class' => 'form-control mb-3']
            ])
            ->add('city',TextType::class,  [
                'label' => 'Ville',
                'attr' => ['class' => 'form-control']
            ])
            ->add('zipCode',NumberType::class,  [
                'label' => 'Code postal',
                'attr' => ['class' => 'form-control'],
                'invalid_message' => 'Le mot de passe de confirmation ne correspond pas',
            ])
            ->add('phoneNumber',TelType::class,  [
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
