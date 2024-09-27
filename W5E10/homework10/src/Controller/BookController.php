<?php

namespace App\Controller;

use App\Entity\Books;
use App\Form\BookFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/books')]
class BookController extends AbstractController
{

    private $em;
    private $bookRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->bookRepository = $em->getRepository(Books::class);
    }

    #[Route('/', name: 'books')]
    public function index(): Response
    {
        $books = $this->bookRepository->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/create', name: 'book_create')]
    public function create(Request $request): Response
    {
        $book = new Books();

        $form = $this->createForm(BookFormType::class, $book);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {

                $this->em->persist($book);
                $this->em->flush();

                return $this->redirectToRoute('books');
            }
        }

        return $this->render('common/create_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add Book'
        ]);
    }

    #[Route('/edit', name: 'book_edit')]
    public function edit(Request $request): Response
    {
        $id = $request->query->get('id');
        $book = $this->bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('No book found for id ' . $id);
        }

        $form = $this->createForm(BookFormType::class, $book);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->flush();

                return $this->redirectToRoute('books');
            }
        }

        return $this->render('common/create_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit Book'
        ]);
    }
}
