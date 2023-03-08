<?php

namespace App\Controller\admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostsController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * Controlleur pour la page des posts en mode admin: les posts sont triés par date de publication et on voit 20 posts par page.
     * Il est possible de modifier ou supprimer un post en cliquant sur un bouton à cet effet.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts', methods:['get'])]
    public function posts(): Response{
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour modifier un post en mode admin.
     * permet de modifier le contenu d'un post
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts/{id}/edit', methods:['get'])]
    public function postsEdit(): Response{
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour modifier un post en mode admin.
     * permet de supprimer un post
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts/{id}/delete', methods:['get'])]
    public function postsDelete(): Response{
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour modifier un post en mode admin.
     * permet de modifier le contenu d'un post
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts/create', methods:['get'])]
    public function postsCreate(): Response{
        return $this->render('base.html.twig');
    }
}