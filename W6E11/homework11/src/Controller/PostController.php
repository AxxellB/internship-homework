<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentFormType;
use App\Form\PostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PostController extends AbstractController
{

    private $em;
    private $postRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->postRepository = $em->getRepository(Post::class);
    }

    #[Route('/posts', name: 'app_posts')]
    public function index(): Response
    {
        $posts = $this->postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/create_post', name: 'app_post_create')]
    #[isGranted('ROLE_AUTHOR')]
    public function create_post(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();

            return $this->redirectToRoute('app_posts');
        }
        return $this->render('post/create_post.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit_post/{id}', name: 'app_post_edit')]
    #[isGranted('ROLE_AUTHOR')]
    public function edit_post(Request $request, int $id): Response
    {
        $post = $this->postRepository->find($id);

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();

            return $this->redirectToRoute('app_posts');
        }
        return $this->render('post/create_post.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/post_details/{id}', name: 'post_show')]
    public function post_details(Request $request, int $id): Response
    {
        $post = $this->postRepository->find($id);
        $user = $this->getUser();
        if (!$post) {
            return $this->redirectToRoute('app_posts');
        }

        $comment = new Comment();
        $commentForm = $this->createForm(CommentFormType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid() && $user) {
            $comment->setDate_Added(new \DateTime());
            $comment->setPost($post);
            $comment->setAuthor($this->getUser());

            $this->em->persist($comment);
            $this->em->flush();

            return $this->redirectToRoute('post_show', ['id' => $id]);
        }

        return $this->render('post/post_details.html.twig', [
            'user' => $user,
            'post' => $post,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
