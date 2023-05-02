<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CreatePostType;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AdminPostsController extends AbstractController
{
    /**
     * Controlleur pour la page des posts en mode admin: les posts sont triés par date de publication et on voit 20 posts par page.
     * Il est possible de modifier ou supprimer un post en cliquant sur un bouton à cet effet.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts', methods: ['get'])]
    public function posts(ManagerRegistry $doctrine): Response
    {
        //récupération des posts
        $postRepository = $doctrine->getRepository(Post::class);
        $posts = $postRepository->findBy([], ['createdAt' => 'DESC'], 20, 0);

        //affichage de la page
        return $this->render('admin/posts.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * Controlleur pour modifier un post en mode admin.
     * permet de modifier le contenu d'un post
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts/{slug}/edit', methods: ['get'])]
    public function postsEdit(): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur pour supprimer un post en mode admin.
     * @param ManagerRegistry $doctrine
     * @param $slug
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts/{slug}/delete', methods: ['get'])]
    public function postsDelete(ManagerRegistry $doctrine, $slug): Response
    {
        //récupération du post à supprimer
        $postRepository = $doctrine->getRepository(Post::class);
        $post = $postRepository->find($slug);

        //suppression de tous les commentaires
        $commentRepository = $doctrine->getRepository(Comment::class);
        $comments = $commentRepository->findBy(['post' => $post]);
        foreach($comments as $comment){
            $doctrine->getManager()->remove($comment);
        }

        //suppression du post
        $doctrine->getManager()->remove($post);
        $doctrine->getManager()->flush();

        //redirection vers la page des posts
        return $this->redirectToRoute('app_admin_adminposts_posts');
    }

    /**
     * Controlleur pour créer un post en mode admin.
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts/create', methods: ['get', 'post'])]
    public function postsCreate(Request $request, ManagerRegistry $doctrine): Response
    {
        //création du nouveau post
        $post = new Post();

        //initialisation du formulaire
        $form = $this->createForm(CreatePostType::class, $post);

        //traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Initialisation du slugger
            $slugger = new AsciiSlugger();

            //Récupération des données du formulaire
            $post = $form->getData();

            //Création du slug
            $post->setSlug($slugger->slug($post->getTitle()));

            //Vérification de l'unicité du slug
            $postRepository = $doctrine->getRepository(Post::class);
            $postsearch = $postRepository->findBy(['title' => $post->getTitle()]);

            if ($postsearch != null) {
                $post->setSlug($post->getSlug() . '-' . count($postsearch));
            }

            //Initialisation des dates
            $post->setCreatedAt(new DateTimeImmutable());
            $post->setUpdatedAt(new DateTimeImmutable());
            $post->setPublishedAt(null);

            //Sauvagarde du post
            $doctrine->getManager()->persist($post);
            $doctrine->getManager()->flush();

            //redirection vers la page des posts
            return $this->redirectToRoute('app_admin_adminposts_posts');
        }

        //affichage du formulaire
        return $this->render('admin/createpost.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Controlleur pour publier un post en mode admin.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts/{slug}/publish', methods: ['get'])]
    public function postsPublish(ManagerRegistry $doctrine, $slug): Response
    {
        //récupération du post
        $postRepository = $doctrine->getRepository(Post::class);
        $post = $postRepository->find($slug);

        //ajout de la date de publication
        $post->setPublishedAt(new DateTimeImmutable());

        //sauvegarde du post
        $doctrine->getManager()->flush();

        //redirection vers la page des posts
        return $this->redirectToRoute('app_admin_adminposts_posts');
    }
}