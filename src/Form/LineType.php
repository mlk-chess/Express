<?php

namespace App\Form;

use App\Entity\Line;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineType extends AbstractType{



    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $file = '../public/stations.json';
        $data = file_get_contents($file);
        $obj = json_decode($data,true);

        foreach ($obj as $value){
           $stations[$value['Nom_Gare']] = $value['Nom_Gare'];
        }
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
