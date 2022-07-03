<?php

namespace App\Form;

use App\Entity\LineTrain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Line;
use App\Entity\Train;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class LineTrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('train', EntityType::class,[
                    'class' => Train::class,
                    'choice_label' => function ($train) {
                        if ($train->getStatus() == 1) {
                            return $train->getName();
                        }
                    },
            ])
            ->add('line', EntityType::class, [
                'class' => Line::class,
                'choice_label' => function ($line) {
                    if ($line->getStatus() === 1) {
                        return $line->getNameStationDeparture() . " - " .  $line->getNameStationArrival();
                    }
                },
                'label' => 'Ligne',
            ])
            ->add('date_departure',DateType::class,[
                'label' => 'Date de départ',
                'widget' => 'single_text'
            ])
            ->add('time_departure',TimeType::class,[
                'label' => 'Horaire de départ',
                'widget' => 'single_text'
            ])

            ->add('price_class_1',MoneyType::class,[
                'label' => 'Prix classe 1',
                
            ])

            ->add('price_class_2',MoneyType::class,[
                'label' => 'Prix classe 2',
              
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LineTrain::class,
        ]);
    }
}
