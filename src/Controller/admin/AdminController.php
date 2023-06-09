<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * Controlleur pour afficher la page d'accueil en mode admin
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin', methods: ['get'])]
    public function postsEdit(): Response
    {
        return $this->render('base.html.twig');
    }
}