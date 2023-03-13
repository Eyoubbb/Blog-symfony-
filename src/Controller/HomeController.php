<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    /**
     * Controlleur pour la page d'accueil qui affiche les 5 derniers posts en fonction de la date de publication (si cette dernière est valide)
     * @return Response
     * @author Jérémy
     */
    #[Route('/', methods:['get'])]
    public function home(): Response{
        return $this->render('base.html.twig');
    }
}