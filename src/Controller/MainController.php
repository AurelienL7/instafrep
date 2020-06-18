<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'home',
            'nb_category' => 8
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
