<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/api')]
class ProductController extends AbstractController
{
    private $em;
    private $categoryRepository;
    private $productRepository;
    private $serializer;
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->categoryRepository = $this->em->getRepository(Category::class);
        $this->productRepository = $this->em->getRepository(Product::class);
        $this->serializer = $serializer;
    }

    #[Route('/products', name: 'product_create', methods: ['POST'])]
    public function createProduct(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if(strlen($data['name'] < 2)){
            return new JsonResponse(['error' => 'Name must be at least 2 characters long'], Response::HTTP_BAD_REQUEST);
        }else if($data['price'] < 1){
            return new JsonResponse(['error' => 'Price must be at least $1'], Response::HTTP_BAD_REQUEST);
        }else if($data['quantity'] < 1){
            return new JsonResponse(['error' => 'Quantity must be at least 1'], Response::HTTP_BAD_REQUEST);
        }

        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setQuantity($data['quantity']);
        if (isset($data['description']) && !empty($data['description'])) {
            $product->setDescription($data['description']);
        } else {
            $product->setDescription(null);
        }

        $category = $this->categoryRepository->findOneBy(['name' => $data['category']]);
        if(!$category){
            return new JsonResponse(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $product->setCategory($category);
        $this->em->persist($product);
        $this->em->flush();

        $jsonProduct = $this->serializer->serialize($product, 'json');

        return new JsonResponse($jsonProduct, Response::HTTP_CREATED, [], true);
    }

    #[Route('/products', name: 'products_list', methods: ['GET'])]
    public function listProducts(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        if(!$products){
            return new JsonResponse(['message' => 'No products found'], Response::HTTP_NOT_FOUND);
        }

        $jsonProducts = $this->serializer->serialize($products, 'json');
        return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
    }
    #[Route('/products/{id}', name: 'product_details', methods: ['GET'])]
    public function getProduct(int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if(!$product){
            return new JsonResponse(['message' => 'No product found'], Response::HTTP_NOT_FOUND);
        }

        $jsonProduct = $this->serializer->serialize($product, 'json');
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }

    #[Route('/products/{id}', name: 'update_product', methods: ['PUT'])]
    public function updateProduct(Request $request, int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if(!$product){
            return new JsonResponse(['message' => 'No product found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        if(strlen($data['name'] < 2)){
            return new JsonResponse(['error' => 'Name must be at least 2 characters long'], Response::HTTP_BAD_REQUEST);
        }else if($data['price'] < 1){
            return new JsonResponse(['error' => 'Price must be at least $1'], Response::HTTP_BAD_REQUEST);
        }else if($data['quantity'] < 1){
            return new JsonResponse(['error' => 'Quantity must be at least 1'], Response::HTTP_BAD_REQUEST);
        }

        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setQuantity($data['quantity']);
        if (isset($data['description']) && !empty($data['description'])) {
            $product->setDescription($data['description']);
        } else {
            $product->setDescription(null);
        }

        $jsonProduct = $this->serializer->serialize($product, 'json');
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }


    #[Route('/products/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function deleteProduct(int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if(!$product){
            return new JsonResponse(['message' => 'No product found'], Response::HTTP_NOT_FOUND);
        }

        $this->em->remove($product);
        $this->em->flush();
        return new JsonResponse(['message' => 'Product removed successfully'], Response::HTTP_OK);
    }
}
