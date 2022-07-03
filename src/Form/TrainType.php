<?php

namespace App\Form;

use App\Entity\Train;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('name',TextType::class, [
                'label' => "Nom du train",
                "attr" => ["class" => "form-control"]
            ])
            ->add('description',TextType::class, [
                'label' => "Description",
                "attr" => ["class" => "form-control"]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Train::class,
        ]);
    }
}
