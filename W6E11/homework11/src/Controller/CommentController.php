<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    private $em;
    private $commentRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->commentRepository = $em->getRepository(Comment::class);
    }

    #[Route('/comment', name: 'app_comment')]
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    #[Route('/delete_comment/{id}', name: 'app_comment_delete')]
    public function delete_comment(int $id): Response
    {
        $user = $this->getUser();
        $comment = $this->commentRepository->find($id);

        if (!$comment) {
            throw $this->createNotFoundException('Comment not found.');
        }
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $postId = $comment->getPost()->getId();
        $post = $this->em->getRepository(Post::class)->find($postId);

        if ($user->getId() !== $post->getAuthor()->getid()) {
            if ($user->getId() !== $comment->getAuthor()->getId()) {
                throw $this->createAccessDeniedException('You can do not have permission to delete this comment.');
            }
        }

        $this->em->remove($comment);
        $this->em->flush();

        return $this->redirectToRoute('post_show', ['id' => $postId]);
    }
}
