<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Form\AuthorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/authors')]
class AuthorController extends AbstractController
{

    private $em;
    private $authorRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->authorRepository = $em->getRepository(Authors::class);
    }

    #[Route('/', name: 'authors')]
    public function index(): Response
    {
        $authors = $this->authorRepository->findAll();

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/create', name: 'author_create')]
    public function create(Request $request): Response
    {
        $author = new Authors();

        $form = $this->createForm(AuthorFormType::class, $author);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {

                $this->em->persist($author);
                $this->em->flush();

                return $this->redirectToRoute('authors');
            }
        }

        return $this->render('common/create_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Create Author',
        ]);
    }

    #[Route('/edit', name: 'author_edit')]
    public function edit(Request $request): Response
    {
        $id = $request->query->get('id');
        $author = $this->authorRepository->find($id);

        if (!$author) {
            throw $this->createNotFoundException('No author found for id ' . $id);
        }

        $form = $this->createForm(AuthorFormType::class, $author);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->flush();

                return $this->redirectToRoute('authors');
            }
        }

        return $this->render('common/create_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit author'
        ]);
    }
}
