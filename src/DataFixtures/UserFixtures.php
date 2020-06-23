<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $hash = $this->encoder->encodePassword($user, "azerty");

        $user->setUsername('Aurélien');
        $user->setCreatedAt(new \DateTime());
        $user->setAnniversary(new \DateTime("1993-06-07"));
        $user->setPassword($hash);
        $user->setCity("Bordeaux");


        $manager->persist($user);

        $manager->flush();
    }
}
