<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerCreateFormType;
use App\Form\CustomerEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CustomerDisplayController extends AbstractController
{
    private $em;
    private $repository;
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Customer::class);
        $this->serializer = $serializer;
    }

    #[Route('/customers_display', name: 'app_customers_display')]
    public function customersDisplay(): Response
    {
        return $this->render('customer/index.html.twig', []);
    }

    #[Route('/customer_create', name: 'app_customer_create')]
    public function customerCreate(): Response
    {
        $form = $this->createForm(CustomerCreateFormType::class);

        return $this->render('customer/createCustomer.html.twig', [
            'form' => $form->createView(),
            'title' => 'Create Customer'
        ]);
    }

    #[Route('/customer_edit/{id}', name: 'app_customer_edit')]
    public function customerEdit(int $id): Response
    {
        $customer = $this->repository->find($id);
        if (!$customer) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CustomerEditFormType::class, $customer);

        return $this->render('customer/editCustomer.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit Customer'
        ]);
    }
}

