<?php

namespace App\Form;

use App\Entity\Line;
use App\Service\Helper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineType extends AbstractType{



    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $stations = Helper::readJsonFile('../public/stations.json');
        asort($stations);

        $builder
            ->add('name_station_departure',ChoiceType::class, [
                'choices' => $stations
            ])
            ->add('name_station_arrival',ChoiceType::class, [
                'choices' => $stations
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Line::class,
        ]);
    }
}
