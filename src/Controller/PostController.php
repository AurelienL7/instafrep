<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/posts/create", name="app_post_create")
     * @param Request $request
     * @return Response
     */
    public function createPost(Request $request)
    {
        $post = new Post();

        $currentUser = $this->getUser();

        $post->setAuthor($currentUser);

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

    /**
     * @Route("post/{id<^[0-9]+$>}/like{", name="app_like_post")
     * @param int $id
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function likePost(int $id){

        // Récupérer le post demandé
        $post = $this
            ->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);


        // Récupérer le User qui like
        /** @var User $user */
        $user = $this->getUser();


        // Validation (déjà liké ?)

        // Si le post n'existe pas...
        if(empty($post)){
            throw $this->createNotFoundException("Le poste demandé n'existe pas.");
        }

        // Si le poste est déjà liké...
        $likers = $post->getLikers();
        if ($likers->contains($user)) {
            $post->removeLiker($user);
        }else{
            // Créer la relation entre les deux (le like)
            $post->addLiker($user);
        }


        // Enregistrer en base de données
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();

        // Retourner une réponse
        return $this->redirectToRoute('home');
    }
}
