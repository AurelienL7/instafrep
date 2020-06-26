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
        foreach ($users as $author){

            $nbPosts = mt_rand(0, 10);

            for($i=0; $i < $nbPosts; $i++){
                $post = new Post();
                

                $post->setAuthor($author)
                    ->setCategory('Uncategorized')
                    ->setCreatedAt($faker->dateTimeThisYear)
                    ->setDislikes($faker->numberBetween(0, 1000))
                    ->setVote($faker->numberBetween(0, 1000))
                    ->setContent($faker->realText())
                    ->setShareLink('url')
                    ->setShares($faker->numberBetween(0, 1000))
                    ->setReplies($faker->numberBetween(0, 1000));

                // Faire liker ce post par des utilisateurs aléatoires
                $nbLikers = mt_rand(1, count($users) - 1);

                for($i=0; $i < $nbLikers; $i++){
                    $randomIndex = mt_rand(0, count($users) - 1);
                    $user = $users[$randomIndex];
                    $user->likePost($post);
                }

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
