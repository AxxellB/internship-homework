<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductCreateFormType;
use App\Form\ProductEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductsDisplayController extends AbstractController
{
    private $em;
    private $repository;
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Product::class);
        $this->serializer = $serializer;
    }

    #[Route('/products_display', name: 'app_products_display')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
        ]);
    }

    #[Route('/product_create', name: 'app_products_create')]
    public function createProduct(): Response
    {
        $form = $this->createForm(ProductCreateFormType::class);

        return $this->render('product/createProduct.html.twig', [
            'form' => $form->createView(),
            'title' => 'Create Product',
        ]);
    }

    #[Route('/product_edit/{id}', name: 'app_product_edit')]
    public function categoryEdit(int $id): Response
    {
        $category = $this->repository->find($id);
        if (!$category) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ProductEditFormType::class, $category);

        return $this->render('product/editProduct.html.twig', [
                'form' => $form->createView(),
                'title' => 'Edit Product'
            ]

        );
    }
}
