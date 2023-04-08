<?php

namespace App\Controller\admin;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/admin/comments/{page}', defaults: ['page' => 1], methods: ['get'])]
    public function comments(PaginatorInterface $paginator, ManagerRegistry $doctrine, $page): Response
    {
        $commentRepository = $doctrine->getRepository(Comment::class);
        $data = $commentRepository->createQueryBuilder('c')
            ->where('c.valid = false')
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery();

        $comments = $paginator->paginate(
            $data,
            $page,
            20
        );
        //affichage de la page
        return $this->render('admin/comments/comments.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     * Controlleur pour supprimer un commentaire
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/comments/delete/{id}', methods: ['get'])]
    public function commentsDelete(LoggerInterface $logger, ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $post = $request->query->get('post');
        $page = $request->query->get('page');
        $admin = $request->query->get('admin');
        $logger->info('post: ' . $post . ' page: ' . $page);

        $commentsRepository = $doctrine->getRepository(Comment::class);
        $comment = $commentsRepository->find($id);
        if($comment == null)
            return new RedirectResponse(($admin == 'true' ? '/admin/comments' : '/post/' . ($post)) . '/' . $page);

        $doctrine->getManager()->remove($comment);
        //suppression du post
        $doctrine->getManager()->flush();

        //redirection vers la page des posts
        return new RedirectResponse(($admin == 'true' ? '/admin/comments' : '/post/' . ($post)) . '/' . $page);
    }

    /**
     * Controlleur pour valider un commentaire
     * @return Response
     * @author Jérémy
     */
    #[Route('/admin/comments/validate/{id}', methods: ['get'])]
    public function commentsValidate(LoggerInterface $logger, ManagerRegistry $doctrine, Request $request, $id): Response
    {
        $post = $request->query->get('post');
        $page = $request->query->get('page');
        $admin = $request->query->get('admin');
        $logger->info('post: ' . $post . ' page: ' . $page);

        $commentsRepository = $doctrine->getRepository(Comment::class);
        $comment = $commentsRepository->find($id);
        if($comment == null)
            return new RedirectResponse(($admin == 'true' ? '/admin/comments' : '/post/' . ($post)) . '/' . $page);

        $comment->setValid(true);

        $doctrine->getManager()->persist($comment);
        //suppression du post
        $doctrine->getManager()->flush();

        //redirection vers la page des posts
        return new RedirectResponse(($admin == 'true' ? '/admin/comments' : '/post/' . ($post)) . '/' . $page);
    }
}