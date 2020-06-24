<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        // Récupérer tous les users existants
        $users = $manager->getRepository(User::class)->findAll();

        // Pour chaque User
        foreach ($users as $user){

            $nbPosts = mt_rand(0, 15);

            for($i=0; $i < $nbPosts; $i++){
                $post = new Post();

                $post->setAuthor($user)
                    ->setCategory('Uncategorized')
                    ->setCreatedAt($faker->dateTimeThisYear)
                    ->setDislikes($faker->numberBetween(0, 1000))
                    ->setLikes($faker->numberBetween(0, 1000))
                    ->setVote($faker->numberBetween(0, 1000))
                    ->setContent($faker->realText())
                    ->setShareLink('url')
                    ->setShares($faker->numberBetween(0, 1000))
                    ->setReplies($faker->numberBetween(0, 1000));


                $manager->persist($post);
            }
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
