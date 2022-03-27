<?php

namespace App\DataFixtures;

use App\Entity\Wagon;
use App\Entity\Train;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WagonFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {

        $this->faker = \Faker\Factory::create();

        $train = $manager->getRepository(Train::class)->findAll();

        for ($i = 0; $i < 10; $i++){
            $wagon = new Wagon();
            $wagon->setPlaceNb($this->faker->randomNumber($nbDigits = 2, $strict = false));
            $wagon->setClass($this->faker->realText($maxNbChars = 20, $indexSize = 2));
            $wagon->setType($this->faker->realText($maxNbChars = 10, $indexSize = 2));
            $wagon->setTrain($this->faker->randomElement($train));

            $manager->persist($wagon);

            $manager->flush();
        }


    }

    public function getDependencies()
    {
        return [
            TrainFixtures::class,
        ];
    }
}
