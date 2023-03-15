<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Form\CreateCategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
    public function categories(ManagerRegistry $doctrine): Response{
        $categoriesRepository = $doctrine->getRepository(Category::class);
        $categories = $categoriesRepository->findBy([], ['id' => 'DESC'], 20, 0);
        return $this->render('admin/categories/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * Controlleur pour créer une catégorie.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories/create', methods:['get', 'post'])]
    public function categoriesCreate(Request $request, ManagerRegistry $doctrine): Response{
        $category = new Category();

        $form = $this->createForm(CreateCategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $doctrine->getManager()->persist($category);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_admin_admincategory_categories');
        }

        return $this->render('admin/categories/createcategory.html.twig', [
            'form' => $form->createView()
        ]);
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
    public function categoriesDelete(ManagerRegistry $doctrine, $id): Response{
        $categoriesRepository = $doctrine->getRepository(Category::class);
        $category = $categoriesRepository->find($id);
        $doctrine->getManager()->remove($category);
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('app_admin_admincategory_categories');
    }
}