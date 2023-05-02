<?php

namespace App\Controller\user;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\AddCommentFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /**
     * Controlleur pour la page des posts en mode utilisateur: les posts sont triés par date de publication et on voit 20 posts par page
     * @return Response
     * @author Jérémy
     */
    #[Route('/posts', methods: ['get'])]
    public function posts(): Response
    {
        return $this->render('base.html.twig');
    }

    /**
     * Controlleur afficher un post: on peut voir sur la première page le post originel ainsi que 9 commentaires puis après 10 commentaires par page
     * @return Response
     * @author Jérémy
     */
    #[Route('/posts/{slug}', methods: ['get', 'post'])]
    public function postsId(Request $request, ManagerRegistry $doctrine, $slug): Response
    {
        //récupération des posts
        $postRepository = $doctrine->getRepository(Post::class);

        //récupération du post
        $post = $postRepository->findBy(['slug' => $slug]);
        if($post == null){
            throw $this->createNotFoundException('Post not found');
        }

        $comment = new Comment();
        $form = $this->createForm(AddCommentFormType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setPost($post[0]);
            $comment->setUsername("test");
            $comment->setValid(false);
            $doctrine->getManager()->persist($comment);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_user_posts_postsid', ['slug' => $slug]);
        }

        return $this->render('user/post.html.twig', [
            'post' => $post[0],
            'form' => $form->createView()
        ]);
    }
}