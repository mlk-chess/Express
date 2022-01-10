<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setEmail("samy@samy.samy");
        $user->setPassword("$2y$13\$bgbUP.CqQremvnMIN1yu4e0viUcl/w4VlvVrGN8CfcoGElTQjzsWS");
        $user->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);

        $manager->flush();
    }
}
