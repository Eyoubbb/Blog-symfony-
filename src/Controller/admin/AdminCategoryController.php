<?php

namespace App\Controller\admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * Controlleur pour afficher la liste des catégories. 20 elements par page
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories', methods:['get'])]
    public function categories(): Response{
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour créer une catégorie.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories/create', methods:['get'])]
    public function categoriesCreate(): Response{
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour modifier une catégorie.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories/{id}/edit', methods:['get'])]
    public function categoriesEdit(): Response{
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour supprimer une catégorie.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories/{id}/delete', methods:['get'])]
    public function categoriesDelete(): Response{
        return $this->render('base.html.twig');
    }
}