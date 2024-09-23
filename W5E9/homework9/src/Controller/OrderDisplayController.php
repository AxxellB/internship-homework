<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderCreateFormType;
use App\Form\OrderEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderDisplayController extends AbstractController
{
    private $em;
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Order::class);
    }

    #[Route('/orders_display', name: 'app_orders_display')]
    public function ordersDisplay(): Response
    {
        return $this->render('order/index.html.twig', []);
    }

    #[Route('/order_create', name: 'app_order_create')]
    public function orderCreate(): Response
    {
        $form = $this->createForm(OrderCreateFormType::class);

        return $this->render('order/createOrder.html.twig', [
            'form' => $form->createView(),
            'title' => 'Create Order'
        ]);
    }

    #[Route('/order_edit/{id}', name: 'app_order_edit')]
    public function orderEdit(int $id): Response
    {
        $order = $this->repository->find($id);
        if (!$order) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(OrderEditFormType::class, $order);

        return $this->render('order/editOrder.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit Order'
        ]);
    }
}
