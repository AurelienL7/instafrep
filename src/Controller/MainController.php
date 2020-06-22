<?php

namespace App\Controller;

use App\Entity\Post;
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

        // On obtient une isntance du repository qui gère les Posts
        $postsRepo = $this->getDoctrine()->getRepository(Post::class);

        // On va chercher tous les Posts de la BDD ...
        $posts = $postsRepo->findAll();

        $form = $this->createForm(PostType::class);

        // ... On les injecte dans la vue pour les afficher
        return $this->render('index.html.twig', [
            'controller_name' => 'home',
            'nb_category' => 4,
            'posts' => $posts,
            'postForm' => $form->createView()
        ]);
    }


}
