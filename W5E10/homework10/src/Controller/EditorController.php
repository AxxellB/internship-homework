<?php

namespace App\Controller;

use App\Entity\Editors;
use App\Form\EditorFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/editors')]
class EditorController extends AbstractController
{

    private $em;
    private $editorRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->editorRepository = $em->getRepository(Editors::class);
    }

    #[Route('/', name: 'editors')]
    public function index(): Response
    {
        $editors = $this->editorRepository->findAll();

        return $this->render('editor/index.html.twig', [
            'editors' => $editors,
        ]);
    }

    #[Route('/create', name: 'book_create')]
    public function create(Request $request): Response
    {
        $editor = new Editors();

        $form = $this->createForm(EditorFormType::class, $editor);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {

                $this->em->persist($editor);
                $this->em->flush();

                return $this->redirectToRoute('editors');
            }
        }

        return $this->render('common/create_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Add Editor'
        ]);
    }
    #[Route('/edit', name: 'editor_edit')]
    public function edit(Request $request): Response
    {
        $id = $request->query->get('id');
        $editor = $this->editorRepository->find($id);

        if (!$editor) {
            throw $this->createNotFoundException('No editor found for id ' . $id);
        }

        $form = $this->createForm(EditorFormType::class, $editor);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->flush();

                return $this->redirectToRoute('editors');
            }
        }

        return $this->render('common/create_edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit editor'
        ]);
    }
}
