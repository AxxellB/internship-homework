<?php

namespace App\Controller;

use App\Entity\Genres;
use App\Form\GenreFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/genres')]
class GenreController extends AbstractController
{

    private $em;
    private $genreRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->genreRepository = $em->getRepository(Genres::class);
    }

    #[Route('/', name: 'genres')]
    public function index(): Response
    {
        $genres = $this->genreRepository->findAll();

        return $this->render('genre/index.html.twig', [
            'genres' => $genres,
        ]);
    }

    #[Route('/create', name: 'genre_create')]
    public function create(Request $request): Response
    {
        $genre = new genres();

        $form = $this->createForm(GenreFormType::class, $genre);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {

                $this->em->persist($genre);
                $this->em->flush();

                return $this->redirectToRoute('genres');
            }
        }

        return $this->render('common/create_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Create genre',
        ]);
    }

    #[Route('/edit', name: 'genre_edit')]
    public function edit(Request $request): Response
    {
        $id = $request->query->get('id');
        $genre = $this->genreRepository->find($id);

        if (!$genre) {
            throw $this->createNotFoundException('No genre found for id ' . $id);
        }

        $form = $this->createForm(GenreFormType::class, $genre);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->flush();
                return $this->redirectToRoute('genres');
            }
        }

        return $this->render('common/create_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit genre'
        ]);
    }
}
