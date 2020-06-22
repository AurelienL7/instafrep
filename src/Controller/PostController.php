<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post-new", name="app_post_create")
     * @param Request $request
     * @return Response
     */
    public function createPost(Request $request)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        // Permet au formulaire de prendre en compte la requête HTTP
        $form->handleRequest($request);

        // On va envoyer ces données à notre BDD
        // Si on a reçu des données
        if($form->isSubmitted()){


            // Si les données sont valides
            if($form->isValid()){

                // On met à jour l'entité avant de l'enregistrer
                $post = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($post);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }
        }


        return $this->render('includes/post_form.html.twig', [
            'postForm' => $form->createView()
        ]);
    }
}
