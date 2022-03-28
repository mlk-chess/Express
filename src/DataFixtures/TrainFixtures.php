<?php

namespace App\DataFixtures;

use App\Entity\Train;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrainFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {

        $this->faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++){
            $train = new Train();
            $train->setDescription($this->faker->realText($maxNbChars = 20, $indexSize = 2));
            $train->setName($this->faker->name);

            $manager->persist($train);

            $manager->flush();
        }
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
