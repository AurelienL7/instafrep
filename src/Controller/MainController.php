<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // On obtient une isntance du repository qui gère les Posts
        $postsRepo = $this->getDoctrine()->getRepository(Post::class);

        // On va chercher tous les Posts de la BDD ...
        $posts = $postsRepo->findAll();

        // ... On les injecte dans la vue pour les afficher
        return $this->render('index.html.twig', [
            'controller_name' => 'home',
            'nb_category' => 4,
            'posts' => $posts
        ]);
    }


    /**
     * @Route("/login", name="login_page")
     */
    public function login()
    {
        return $this->render('login_page.html.twig', [
            'controller_name' => 'login',
        ]);
    }

}
