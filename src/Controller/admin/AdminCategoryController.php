<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Form\CreateCategoryType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * Controlleur pour afficher la liste des catégories. 20 elements par page
     * @param ManagerRegistry $doctrine
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories/{page}', defaults: ['page' => 1], methods: ['get'])]
    public function categories(ManagerRegistry $doctrine, PaginatorInterface $paginator, $page): Response
    {
        //récupération des catégories
        $categoriesRepository = $doctrine->getRepository(Category::class);
        $data = $categoriesRepository->findBy([], ['id' => 'DESC']);

        //pagination
        $categories = $paginator->paginate(
            $data,
            $page,
            20
        );

        //affichage de la page
        return $this->render('admin/categories/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * Controlleur pour créer une catégorie.
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories/create', methods: ['get', 'post'])]
    public function categoriesCreate(Request $request, ManagerRegistry $doctrine): Response
    {
        //création de la catégorie
        $category = new Category();

        //Initialisation du formulaire
        $form = $this->createForm(CreateCategoryType::class, $category);

        //Traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //récupération des données du formulaire
            $category = $form->getData();

            //enregistrement de la catégorie
            $doctrine->getManager()->persist($category);
            $doctrine->getManager()->flush();

            //redirection vers la liste des catégories
            return $this->redirectToRoute('app_admin_admincategory_categories');
        }

        //affichage de la page
        return $this->render('admin/categories/createcategory.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Controlleur pour modifier une catégorie.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories/{id}/edit', methods: ['get'])]
    public function categoriesEdit(): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour supprimer une catégorie.
     * @param ManagerRegistry $doctrine
     * @param $id
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/categories/{id}/delete', methods: ['get'])]
    public function categoriesDelete(ManagerRegistry $doctrine, $id): Response
    {
        //récupération de la catégorie à supprimer
        $categoriesRepository = $doctrine->getRepository(Category::class);
        $category = $categoriesRepository->find($id);

        //suppression de la catégorie
        $doctrine->getManager()->remove($category);
        $doctrine->getManager()->flush();

        //redirection vers la liste des catégories
        return $this->redirectToRoute('app_admin_admincategory_categories');
    }
}