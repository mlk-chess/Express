<?php

namespace App\Form;

use App\Entity\LineTrain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Line;
use Symfony\Component\Form\ChoiceList\ChoiceList;

class LineTrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('train')
            ->add('line', EntityType::class, [
                'class' => Line::class,
                'choice_label' => function ($line) {
                    return $line->getNameStationDeparture() . " - " .  $line->getNameStationArrival();
                },
                'label' => 'Ligne',
            ])
            ->add('date_departure')
            ->add('time_departure')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LineTrain::class,
        ]);
    }
}
