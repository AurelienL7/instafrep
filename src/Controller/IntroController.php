<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IntroController extends AbstractController
{
    /**
     * @Route("/intro", name="intro")
     */
    public function index()
    {

        $random = rand(0, 10);

        return $this->render('intro/index.html.twig', [
            'controller_name' => 'IntroController',
            'random_number' => $random
        ]);
    }

    /**
     * @Route("/lucky", name="app_lucky")
     */
    public function lucky()
    {
        $random = rand(0, 10);

        return new Response($random);
    }

    /**
     * @Route("/gitlab", name="app_gitlab")
     */
    public function goToGitLab()
    {
        $random = rand(0, 10);

        return new RedirectResponse('https://gitlab.com');
    }

    /**
     * @Route("/miracle", name="app_miracle")
     */
    public function solutionMiracle(){
        throw $this->createNotFoundException("Désolé mais ça n'existe pas");
    }
}
