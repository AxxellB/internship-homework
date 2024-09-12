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
#[Route('/api/products')]
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

    public function validateProductData($data)
    {
        if (strlen($data['name'] < 2)) {
            return ['error' => 'Name must be at least 2 characters long'];
        }
        if ($data['price'] < 1) {
            return ['error' => 'Price must be at least $1'];
        }
        if ($data['quantity'] < 1) {
            return ['error' => 'Quantity must be at least 1'];
        }
        return null;
    }

    #[Route('', name: 'product_create', methods: ['POST'])]
    public function createProduct(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $validationErrors = $this->validateProductData($data);

        if ($validationErrors) {
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
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
        if (!$category) {
            return new JsonResponse(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $product->setCategory($category);
        $this->em->persist($product);
        $this->em->flush();

        $jsonProduct = $this->serializer->serialize($product, 'json');

        return new JsonResponse($jsonProduct, Response::HTTP_CREATED, [], true);
    }

    #[Route('/filterCategory', name: 'products_list_filtered_by_category', methods: ['GET'])]
    public function listProductsFilteredByCategory(Request $request): JsonResponse
    {
        $category = $request->query->get('category');

        if (!$category) {
            return new JsonResponse(['error' => 'Category parameter is required'], Response::HTTP_BAD_REQUEST);
        }

        $categoryObj = $this->categoryRepository->findOneBy(['name' => $category]);
        if (!$categoryObj) {
            return new JsonResponse(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $products = $this->productRepository->findBy(['category' => $categoryObj]);
        if (!$products) {
            return new JsonResponse(['message' => 'No products found for this category'], Response::HTTP_NOT_FOUND);
        }

        $jsonProducts = $this->serializer->serialize($products, 'json');
        return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
    }

    #[Route('/filterPrice', name: 'products_list_filtered_by_price', methods: ['GET'])]
    public function listProductsFilteredByPrice(Request $request): JsonResponse
    {
        $priceAbove = $request->query->get('priceAbove');
        $priceBelow = $request->query->get('priceBelow');

        if (!$priceAbove || !$priceBelow) {
            return new JsonResponse(['error' => 'Both priceAbove and priceBelow parameters are required'], Response::HTTP_BAD_REQUEST);
        }

        if (!is_numeric($priceAbove) || !is_numeric($priceBelow)) {
            return new JsonResponse(['error' => 'Price values must be numeric'], Response::HTTP_BAD_REQUEST);
        }

        $products = $this->productRepository->createQueryBuilder('p')
            ->where('p.price > :priceAbove AND p.price < :priceBelow')
            ->setParameter('priceAbove', (float)$priceAbove)
            ->setParameter('priceBelow', (float)$priceBelow)
            ->getQuery()
            ->getResult();

        if (!$products) {
            return new JsonResponse(['message' => 'No products found in this price range'], Response::HTTP_NOT_FOUND);
        }

        $jsonProducts = $this->serializer->serialize($products, 'json');
        return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
    }
    #[Route('', name: 'products_list', methods: ['GET'])]
    public function listProducts(): JsonResponse
    {
        $products = $this->productRepository->findAll();
        if(!$products){
            return new JsonResponse(['message' => 'No products found'], Response::HTTP_NOT_FOUND);
        }

        $jsonProducts = $this->serializer->serialize($products, 'json');
        return new JsonResponse($jsonProducts, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'product_details', methods: ['GET'])]
    public function getProduct(int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if(!$product){
            return new JsonResponse(['message' => 'No product found'], Response::HTTP_NOT_FOUND);
        }

        $jsonProduct = $this->serializer->serialize($product, 'json');
        return new JsonResponse($jsonProduct, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'update_product', methods: ['PUT'])]
    public function updateProduct(Request $request, int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        if(!$product){
            return new JsonResponse(['message' => 'No product found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $validationErrors = $this->validateProductData($data);

        if ($validationErrors) {
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
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


    #[Route('/{id}', name: 'product_delete', methods: ['DELETE'])]
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
