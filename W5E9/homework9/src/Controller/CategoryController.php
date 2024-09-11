<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class CategoryController extends AbstractController
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
    #[Route('/categories', name: 'category_create', methods: ['POST'])]
    public function createCategory(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (strlen($data['name']) < 2 || strlen($data['description'])  < 2) {
            return new JsonResponse(['message' => 'Name and description must be at least 2 characters long'], Response::HTTP_BAD_REQUEST);
        }

        $category = new Category();
        $category->setName($data['name']);
        $category->setDescription($data['description']);
        $this->em->persist($category);
        $this->em->flush();
        $jsonCategory = $this->serializer->serialize($category, 'json');

        return new JsonResponse($jsonCategory, Response::HTTP_CREATED, [], true);
    }

    #[Route('/categories', name: 'category_list', methods: ['GET'])]
    public function listCategories(): JsonResponse
    {
        $categories = $this->repository->findAll();
        if(!$categories){
            return new JsonResponse(['message' => 'No categories found'], Response::HTTP_NOT_FOUND);
        }

        $jsonCategories = $this->serializer->serialize($categories, 'json');
        return new JsonResponse($jsonCategories, Response::HTTP_OK, [], true);
    }

    #[Route('/categories/{id}', name: 'category_detail', methods: ['GET'])]
    public function getCategory(int $id): JsonResponse
    {
        $category = $this->repository->find($id);
        if(!$category){
            return new JsonResponse(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $jsonCategory = $this->serializer->serialize($category, 'json');
        return new JsonResponse($jsonCategory, Response::HTTP_OK, [], true);
    }

    #[Route('/categories/{id}', name: 'category_update', methods: ['PUT'])]
    public function updateCategory(int $id, Request $request): JsonResponse
    {
        $category = $this->repository->find($id);
        if(!$category){
            return new JsonResponse(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        if (strlen($data['name']) < 2 || strlen($data['description'])  < 2) {
            return new JsonResponse(['message' => 'Name and description must be at least 2 characters long'], Response::HTTP_BAD_REQUEST);
        }

        $category->setName($data['name']);
        $category->setDescription($data['description']);
        $this->em->persist($category);
        $this->em->flush();
        $jsonCategory = $this->serializer->serialize($category, 'json');
        return new JsonResponse($jsonCategory, Response::HTTP_OK, [], true);
    }

    #[Route('/categories/{id}', name: 'category_delete', methods: ['DELETE'])]
    public function deleteCategory(int $id): JsonResponse
    {
        $category = $this->repository->find($id);
        if(!$category){
            return new JsonResponse(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $this->em->remove($category);
        $this->em->flush();

        return new JsonResponse(['message' => 'Category deleted successfully'], Response::HTTP_OK);
    }
}
