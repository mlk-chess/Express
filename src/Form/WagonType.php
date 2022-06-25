<?php

namespace App\Form;

use App\Entity\Wagon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WagonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('class', ChoiceType::class, [
                'choices'  => [
                    ' ' => null,
                    '1' => '1',
                    '2' => '2',
                ]]
            )
            ->add('type',ChoiceType::class, [
                'choices'  => [
                    ' ' => null,
                    'Voyageur' => 'Voyageur',
                    'Bar' => 'Bar',
                ]]
            )
            ->add('placeNb')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wagon::class,
        ]);
    }
}
