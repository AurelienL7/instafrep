<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('Aurélien');
        $user->setCreatedAt(new \DateTime());
        $user->setAnniversary(new \DateTime("1993-06-07"));
        $user->setPassword("azerty");
        $user->setCity("Bordeaux");


        $manager->persist($user);

        $manager->flush();
    }
}
