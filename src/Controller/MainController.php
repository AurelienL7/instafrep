<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        // On obtient une instance du repository qui gère les Posts
        $postsRepo = $this->getDoctrine()->getRepository(Post::class);

        // On va chercher tous les Posts de la BDD ...
        $posts = $postsRepo->findBy(
                [],
                ['created_at' => 'DESC']
            );

        // Aller chercher le post le plus populaire
        $mostUpvotedPosts = $postsRepo->findMostUpvoted();


        $form = $this->createForm(PostType::class);

        // ... On les injecte dans la vue pour les afficher
        return $this->render('index.html.twig', [
            'controller_name' => 'home',
            'nb_category' => 4,
            'posts' => $posts,
            'mostUpvotedPosts' => $mostUpvotedPosts,
            'postForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/{slug}", name="user_profile")
     */
    public function profile(int $slug){

        $user = $this->getDoctrine()->getRepository(User::class)->find($slug);


        // On obtient une instance du repository qui gère les Posts
        $postsRepo = $this->getDoctrine()->getRepository(Post::class);

        // On va chercher tous les Posts de la BDD ...
        $posts = $postsRepo->findBy(
            ['author' => $user->getUsername()],
            ['created_at' => 'DESC']
        );


        if($user){

            return $this->render('layouts/user_profile.html.twig', [
                'posts' => $posts,
                'user' => $user
            ]);
        }

    }

}
