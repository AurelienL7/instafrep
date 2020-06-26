<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // Si l'utilisateur n'est pas connecté, redirection sur la home
        $user = $this->getUser();
        if(empty($user)){
            return $this->redirectToRoute('app_login');
        };

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
            'nb_category' => 4,
            'posts' => $posts,
            'mostUpvotedPosts' => $mostUpvotedPosts,
            'postForm' => $form->createView(),
            'route_name' => 'Main Stream'
        ]);
    }

    /**
     * @Route("/profile/{id<^[0-9]+$>}", name="user_profile")
     * @param int $id
     * @return Response
     */
    public function profile(int $id){


        // On va chercher l'utilisateur correspondant en BDD
        /** @var User $user */
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if(empty($user)){
            throw $this->createNotFoundException("L'utilisateur n'existe pas.");
        }

        // On obtient une instance du repository qui gère les Posts
        $postsRepo = $this->getDoctrine()->getRepository(Post::class);

        // On va chercher tous les Posts de la BDD ...
        $posts = $postsRepo->findBy(
            ['author' => $user->getUsername()],
            ['created_at' => 'DESC']
        );

        return $this->render('layouts/user_profile.html.twig', [
            'posts' => $posts,
            'user' => $user,
            'route_name' => 'Profile'
        ]);
    }

    /**
     * @Route("/profile/{slug}", name="user_profile_by_slug")
     */
    public function profileBySlug($slug){


        // On va chercher l'utilisateur correspondant en BDD
        /** @var User $user */
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy([
                'slug' => $slug
            ]);

        if(empty($user)){
            throw $this->createNotFoundException("L'utilisateur n'existe pas.");
        }

        // On obtient une instance du repository qui gère les Posts
        $postsRepo = $this->getDoctrine()->getRepository(Post::class);

        // On va chercher tous les Posts de la BDD ...
        $posts = $postsRepo->findBy(
            ['author' => $user->getId()],
            ['created_at' => 'DESC']
        );

        return $this->render('layouts/user_profile.html.twig', [
            'posts' => $posts,
            'user' => $user,
            'route_name' => 'Profile'
        ]);
    }


}
