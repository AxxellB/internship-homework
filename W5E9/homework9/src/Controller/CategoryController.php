<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class CategoryController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/categories', name: 'category_create', methods: ['POST'])]
    public function createCategory(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        $category = new Category();
        $category->setName($data['name']);
        $category->setDescription($data['description']);
        $this->em->persist($category);
        $this->em->flush();

        return new JsonResponse(['message' => 'Category created with id '. $category->getId(), Response::HTTP_CREATED]);
    }

    #[Route('/categories', name: 'category_list', methods: ['GET'])]
    public function listCategories(EntityManagerInterface $em): JsonResponse
    {
        // Your logic for listing all categories
    }

    #[Route('/categories/{id}', name: 'category_detail', methods: ['GET'])]
    public function getCategory(int $id, EntityManagerInterface $em): JsonResponse
    {
        // Your logic for getting a specific category by ID
    }

    #[Route('/categories/{id}', name: 'category_update', methods: ['PUT'])]
    public function updateCategory(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        // Your logic for updating a category
    }

    #[Route('/categories/{id}', name: 'category_delete', methods: ['DELETE'])]
    public function deleteCategory(int $id, EntityManagerInterface $em): JsonResponse
    {
        // Your logic for deleting a category
    }
}
