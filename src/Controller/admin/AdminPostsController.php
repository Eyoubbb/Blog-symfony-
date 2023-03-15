<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\CreatePostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AdminPostsController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * Controlleur pour la page des posts en mode admin: les posts sont triés par date de publication et on voit 20 posts par page.
     * Il est possible de modifier ou supprimer un post en cliquant sur un bouton à cet effet.
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts', methods:['get'])]
    public function posts(ManagerRegistry $doctrine): Response{
        $postRepository = $doctrine->getRepository(Post::class);
        $posts = $postRepository->findBy([], ['createdAt' => 'DESC'], 20, 0);

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
    public function postsDelete(ManagerRegistry $doctrine, $id): Response{
        $postRepository = $doctrine->getRepository(Post::class);;
        $post = $postRepository->find($id);
        $doctrine->getManager()->remove($post);
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('app_admin_adminposts_posts');
    }

    /**
     * Controlleur pour modifier un post en mode admin.
     * permet de modifier le contenu d'un post
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/posts/create', methods:['get', 'post'])]
    public function postsCreate(Request $request, ManagerRegistry $doctrine): Response{
        $post = new Post();

        $form = $this->createForm(CreatePostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slugger = new AsciiSlugger();

            $post = $form->getData();

            $post->setSlug($slugger->slug($post->getTitle()));
            $post->setCreatedAt(new \DateTimeImmutable());
            $post->setUpdatedAt(new \DateTimeImmutable());
            $post->setPublishedAt(null);

            $doctrine->getManager()->persist($post);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_admin_adminposts_posts');
        }

        return $this->render('admin/createpost.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/posts/{id}/publish', methods:['get'])]
    public function postsPublish(ManagerRegistry $doctrine, $id): Response{
        $postRepository = $doctrine->getRepository(Post::class);;
        $post = $postRepository->find($id);
        $post->setPublishedAt(new \DateTimeImmutable());
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('app_admin_adminposts_posts');
    }
}