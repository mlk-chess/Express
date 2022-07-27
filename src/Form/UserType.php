<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                    'attr' => ['class' => 'form-control mb-3'],
                    'invalid_message' => 'L\'email n\'est pas valide'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'row_attr' => ['class' => 'ma-4'],
                    'help' => 'Le mot de passe doit être compris entre 6 et 49 caractères'
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
                'attr' => ['class' => 'form-control mb-3'],
                'invalid_message' => 'L\'adresse n\'est pas valide'
            ])
            ->add('city',TextType::class,  [
                'label' => 'Ville',
                'attr' => ['class' => 'form-control'],
                'invalid_message' => 'La ville n\'est pas valide'
            ])
            ->add('zipCode',NumberType::class,  [
                'label' => 'Code postal',
                'attr' => ['class' => 'form-control'],
                'invalid_message' => 'Le code postal n\'est pas valide'
            ])
            ->add('phoneNumber',TelType::class,  [
                'label' => 'Numéro de téléphone',
                'invalid_message' => 'Le numéro n\'est pas valide',
                'attr' => ['class' => 'form-control mb-3'],
                'help' => 'Le numéro doit être égal à 10 caractères'
            ])
            ->add('newsletter', CheckboxType::class, [
                'label'    => "S'abonner à la Newsletter",
                'required' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
