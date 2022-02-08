<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private $encodePassword;

    /**
     * UserFixtures constructor.
     * @param $encodePassword
     */
    public function __construct(UserPasswordHasherInterface $encodePassword)
    {
        $this->encodePassword = $encodePassword;
    }


    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setEmail("samy@samy.samy");
        $user->setPassword("$2y$13\$bgbUP.CqQremvnMIN1yu4e0viUcl/w4VlvVrGN8CfcoGElTQjzsWS");
        //$user->setPassword($this->encodePassword->hashPassword($user, 'samy'))
        $user->setRoles(["ROLE_ADMIN", "ROLE_SUPER_ADMIN"]);

        $manager->persist($user);

        $manager->flush();

        $user = new User();
        $user->setEmail("soc@soc.soc");
        $user->setPassword("$2y$13\$bgbUP.CqQremvnMIN1yu4e0viUcl/w4VlvVrGN8CfcoGElTQjzsWS");
        //$user->setPassword($this->encodePassword->hashPassword($user, 'samy'))
        $user->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);

        $manager->flush();

    }
}
