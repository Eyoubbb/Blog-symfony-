<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * Controlleur pour la page d'accueil qui affiche les 5 derniers posts en fonction de la date de publication (si cette dernière est valide)
     * @param ManagerRegistry $doctrine
     * @return Response
     * @author Jérémy
     */
    #[Route('/', methods: ['get'])]
    public function home(ManagerRegistry $doctrine): Response
    {
        //récupération des posts
        $postRepository = $doctrine->getRepository(Post::class);

        //récupération des 5 derniers posts publiés
        $posts = $postRepository->findPublished(5);

        //affichage de la page
        return $this->render('home.html.twig', [
            'posts' => $posts
        ]);
    }
}