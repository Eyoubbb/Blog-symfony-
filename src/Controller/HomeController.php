<?php

namespace App\Controller;

use App\Entity\Post;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
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
    public function home(ManagerRegistry $doctrine): Response{
            $postRepository = $doctrine->getRepository(Post::class);

            $posts = $postRepository->findNotPublished(5);

            return $this->render('home.html.twig', [
                'posts' => $posts
            ]);
    }
}