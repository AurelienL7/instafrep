<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for ($i=0; $i <= 50; $i++){

            $post = new Post();

            $post->setCategory('Uncategorized')
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


        $manager->flush();
    }
}
