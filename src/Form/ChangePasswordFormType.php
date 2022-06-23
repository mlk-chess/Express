<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'Nouveau mot de passe',
                        'class' => 'form-control mb-3'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit comporter au moins 6 caractères.',
                            'maxMessage' => 'Votre mot de passe doit comporter au maximum 49 caractères.',
                            'max' => 49,
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe',
                    'help' => 'Le mot de passe doit être compris entre 6 et 49 caractères'
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'Nouveau mot de passe',
                        'class' => 'form-control mb-3'
                    ],
                    'label' => 'Confirmation du mot de passe',
                ],
                'invalid_message' => 'Le mot de passe de confirmation ne correspond pas',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
