<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

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
        $faker = Factory::create('fr_FR');

        for($i=0; $i <= 10; $i++){

            $user = new User();

            $hash = $this->encoder->encodePassword($user, "azerty");

            $user->setUsername($faker->unique()->firstName);
            $user->setCreatedAt(new \DateTime());
            $user->setAnniversary(new \DateTime("1993-06-07"));
            $user->setPassword($hash);
            $user->setCity($faker->city);
            $user->setBio($faker->text);
            $user->setAvatar($faker->imageUrl($width = 640, $height = 480));
            $user->setProfileCover($faker->imageUrl($width = 640, $height = 480));


            $manager->persist($user);

        }

        $manager->flush();
    }
}
