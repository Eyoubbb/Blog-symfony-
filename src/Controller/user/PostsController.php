<?php

namespace App\Controller\user;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * Controlleur pour la page des posts en mode utilisateur: les posts sont triés par date de publication et on voit 20 posts par page
     * @return Response
     * @author Jérémy
     */
    #[Route('/posts', methods:['get'])]
    public function posts(): Response{
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur afficher un post: on peut voir sur la première page le post originel ainsi que 9 commentaires puis après 10 commentaires par page
     * @return Response
     * @author Jérémy
     */
    #[Route('/posts/{id}', methods:['get'])]
    public function postsId($id): Response{
        return $this->render('base.html.twig');
    }
}