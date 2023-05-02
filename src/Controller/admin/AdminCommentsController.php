<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentsController extends AbstractController
{
    /**
     * Controlleur pour afficher la liste des commentaires. 20 elements par page
     * possibilité de valider ou supprimer un commentaire depuis la liste
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/comments', methods: ['get'])]
    public function comments(): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour supprimer un commentaire
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/comments/{id}/delete', methods: ['get'])]
    public function commentsDelete($id): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour valider un commentaire
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/comments/{id}/validate', methods: ['get'])]
    public function commentsValidate($id): Response
    {
        return $this->render('base.html.twig');
    }
}