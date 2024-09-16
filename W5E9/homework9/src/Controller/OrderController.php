<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Customer;
use App\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/api/orders')]
class OrderController extends AbstractController
{
    private $em;
    private $customerRepository;
    private $orderRepository;
    private $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->customerRepository = $this->em->getRepository(Customer::class);
        $this->orderRepository = $this->em->getRepository(Order::class);
        $this->serializer = $serializer;
    }

    public function validateOrderData($data){
        if (isset($data['order_date'])) {
            try {
                $orderDate = new \DateTime($data['order_date']);
            } catch (\Exception $e) {
                return ['error' => 'Invalid order date provided'];
            }
        }
        if(!isset($data['total']) || $data['total'] < 1) {
             return ['error' => 'Total must be greater than 1'];
         }
        if(!isset($data['status']) || !in_array($data['status'], ['Pending', 'Completed', 'Cancelled'])) {
             return ['error' => 'Invalid order status'];
        }
         if(!isset($data['customer_id']) || !$this->customerRepository->find($data['customer_id'])){
             return ['error' => 'Customer not found'];
         }
        return null;
    }

    #[Route('/', name: 'order_create', methods: ['POST'])]
    public function createOrder(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $validationErrors = $this->validateOrderData($data);

        if ($validationErrors) {
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $customer = $this->customerRepository->find($data['customer_id']);
        $order = new Order();
        $order->setOrderDate(new \DateTime($data['order_date']));
        $order->setTotal($data['total']);
        $order->setStatus(OrderStatus::from($data['status']));
        $order->setCustomer($customer);

        $this->em->persist($order);
        $this->em->flush();

        $jsonOrder = $this->serializer->serialize($order, 'json');

        return new JsonResponse($jsonOrder, Response::HTTP_CREATED, [], true);
    }

    #[Route('/filterTotal', name: 'orders_list_filtered_by_total', methods: ['GET'])]
    public function listProductsFilteredByPrice(Request $request): JsonResponse
    {
        $totalAbove = $request->query->get('totalAbove');
        $totalBelow = $request->query->get('totalBelow');

        if (!$totalAbove || !$totalBelow) {
            return new JsonResponse(['error' => 'Both totalAbove and totalBelow parameters are required'], Response::HTTP_BAD_REQUEST);
        }

        if (!is_numeric($totalAbove) || !is_numeric($totalBelow)) {
            return new JsonResponse(['error' => 'Total values must be numeric'], Response::HTTP_BAD_REQUEST);
        }

        $orders = $this->orderRepository->createQueryBuilder('o')
            ->where('o.total > :totalAbove AND o.total < :totalBelow')
            ->setParameter('totalAbove', (float)$totalAbove)
            ->setParameter('totalBelow', (float)$totalBelow)
            ->getQuery()
            ->getResult();

        if (!$orders) {
            return new JsonResponse(['message' => 'No orders found in this price range'], Response::HTTP_NOT_FOUND);
        }

        $jsonOrders = $this->serializer->serialize($orders, 'json');
        return new JsonResponse($jsonOrders, Response::HTTP_OK, [], true);
    }

    #[Route('/filterStatus', name: 'orders_list_filtered_by_status', methods: ['GET'])]
    public function listProductsFilteredByStatus(Request $request): JsonResponse
    {
        $orderStatus = $request->query->get('orderStatus');

        if (!in_array($orderStatus, ['Pending', 'Completed', 'Cancelled'], true)) {
            return new JsonResponse(['error' => 'Invalid order status'], Response::HTTP_BAD_REQUEST);
        }

        $orders = $this->orderRepository->findBy(['status' => $orderStatus]);

        if (!$orders) {
            return new JsonResponse(['message' => 'No orders found with this status'], Response::HTTP_NOT_FOUND);
        }

        $jsonOrders = $this->serializer->serialize($orders, 'json');
        return new JsonResponse($jsonOrders, Response::HTTP_OK, [], true);
    }

    #[Route('', name: 'orders_list', methods: ['GET'])]
    public function listOrders(): JsonResponse
    {
        $orders = $this->orderRepository->findAll();
        if(!$orders){
            return new JsonResponse(['message' => 'No orders found'], Response::HTTP_NOT_FOUND);
        }

        $jsonOrders = $this->serializer->serialize($orders, 'json');
        return new JsonResponse($jsonOrders, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'order_details', methods: ['GET'])]
    public function getOrder(int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);
        if(!$order){
            return new JsonResponse(['message' => 'No order found'], Response::HTTP_NOT_FOUND);
        }

        $jsonOrder = $this->serializer->serialize($order, 'json');
        return new JsonResponse($jsonOrder, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'update_order', methods: ['PUT'])]
    public function updateOrder(Request $request, int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);
        if(!$order){
            return new JsonResponse(['message' => 'No order found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $validationErrors = $this->validateOrderData($data);

        if ($validationErrors) {
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $customer = $this->customerRepository->find($data['customer_id']);
        $order->setOrderDate(new \DateTime($data['order_date']));
        $order->setTotal($data['total']);
        $order->setStatus(orderStatus::from($data['status']));
        $order->setCustomer($customer);

        $this->em->persist($order);
        $this->em->flush();

        $jsonOrder = $this->serializer->serialize($order, 'json');
        return new JsonResponse($jsonOrder, Response::HTTP_OK, [], true);
    }


    #[Route('/{id}', name: 'order_delete', methods: ['DELETE'])]
    public function deleteOrder(int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);
        if(!$order){
            return new JsonResponse(['message' => 'No order found'], Response::HTTP_NOT_FOUND);
        }

        $this->em->remove($order);
        $this->em->flush();
        return new JsonResponse(['message' => 'Order removed successfully'], Response::HTTP_OK);
    }
}
