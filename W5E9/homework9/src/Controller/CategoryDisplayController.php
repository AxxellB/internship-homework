<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryEditFormType;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CategoryDisplayController extends AbstractController
{
    private $em;
    private $repository;
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Category::class);
        $this->serializer = $serializer;
    }

    #[Route('/categories_display', name: 'app_categories_display')]
    public function categoriesDisplay(): Response
    {
        return $this->render('category/index.html.twig', []

        );
    }

    #[Route('/category_create', name: 'app_category_create')]
    public function categoryCreate(): Response
    {
        $form = $this->createForm(CategoryFormType::class);


        return $this->render('category/createCategory.html.twig', [
                'form' => $form->createView(),
                'title' => 'Create Category'
            ]

        );
    }

    #[Route('/category_edit/{id}', name: 'app_category_edit')]
    public function categoryEdit(int $id): Response
    {
        $category = $this->repository->find($id);
        if (!$category) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CategoryEditFormType::class, $category);


        return $this->render('category/editCategory.html.twig', [
                'form' => $form->createView(),
                'title' => 'Edit Category'
            ]

        );
    }


}
