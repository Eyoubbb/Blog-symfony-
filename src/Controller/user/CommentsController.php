<?php

namespace App\Controller\user;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{
    /**
     * Controlleur pour modifier une catégorie.
     * @return Response
     * @author Jérémy
     */
    #[Route('/posts/{id}/comment', methods: ['get'])]
    public function comment(): Response
    {
        return $this->render('base.html.twig');
    }
}