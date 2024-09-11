<?php

namespace App\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
#[Route('/api/customers')]
class CustomerController extends AbstractController
{
    private $em;
    private $customerRepository;
    private $serializer;
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->customerRepository = $this->em->getRepository(Customer::class);
        $this->serializer = $serializer;
    }

    public function isEmailDuplicate(string $email){
        $customer = $this->customerRepository->findOneBy(['email' => $email]);
        if($customer){
            return true;
        }
        return false;
    }

    public function validateCustomerData($data){
        if(strlen($data['name'] < 2)){
            return ['error' => 'Name must be at least 2 characters long'];
        }
        else if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Invalid email address'];
        }else if(strlen($data['address']) < 5){
            return ['error' => 'Address must be at least 5 characters long'];
        }
        else if($this->isEmailDuplicate($data['email'])){
            return ['error' => 'Email already exist'];
        } else if (isset($data['phone']) && !empty($data['phone'])) {
            if (strlen($data['phone']) != 10) {
                return ['error' => 'Phone must be 10 characters long'];
            }
        }
        return null;
    }

    #[Route('', name: 'customer_create', methods: ['POST'])]
    public function createCustomer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $validationErrors = $this->validateCustomerData($data);

        if ($validationErrors) {
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $customer = new Customer();
        $customer->setName($data['name']);
        $customer->setEmail($data['email']);
        $customer->setAddress($data['address']);
        if (isset($data['phone']) && !empty($data['phone'])) {
            $customer->setPhone($data['phone']);
        } else {
            $customer->setPhone(null);
        }

        $this->em->persist($customer);
        $this->em->flush();

        $jsonCustomer = $this->serializer->serialize($customer, 'json');

        return new JsonResponse($jsonCustomer, Response::HTTP_CREATED, [], true);
    }

    #[Route('', name: 'customers_list', methods: ['GET'])]
    public function listCustomers(): JsonResponse
    {
        $customers = $this->customerRepository->findAll();
        if(!$customers){
            return new JsonResponse(['message' => 'No customers found'], Response::HTTP_NOT_FOUND);
        }

        $jsonCustomers = $this->serializer->serialize($customers, 'json');
        return new JsonResponse($jsonCustomers, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'customer_details', methods: ['GET'])]
    public function getCustomer(int $id): JsonResponse
    {
        $customer = $this->customerRepository->find($id);
        if(!$customer){
            return new JsonResponse(['message' => 'No customer found'], Response::HTTP_NOT_FOUND);
        }

        $jsonCustomer = $this->serializer->serialize($customer, 'json');
        return new JsonResponse($jsonCustomer, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'update_customer', methods: ['PUT'])]
    public function updateCustomer(Request $request, int $id): JsonResponse
    {
        $customer = $this->customerRepository->find($id);
        if(!$customer){
            return new JsonResponse(['message' => 'No customer found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $validationErrors = $this->validateCustomerData($data);

        if ($validationErrors) {
            return new JsonResponse($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $customer->setName($data['name']);
        $customer->setEmail($data['email']);
        $customer->setAddress($data['address']);
        if(isset($data['phone']) && !empty($data['phone'])){
            $customer->setPhone($data['phone']);
        } else {
            $customer->setPhone(null);
        }

        $jsonCustomer = $this->serializer->serialize($customer, 'json');
        return new JsonResponse($jsonCustomer, Response::HTTP_OK, [], true);
    }


    #[Route('/{id}', name: 'customer_delete', methods: ['DELETE'])]
    public function deleteCustomer(int $id): JsonResponse
    {
        $customer = $this->customerRepository->find($id);
        if(!$customer){
            return new JsonResponse(['message' => 'No customer found'], Response::HTTP_NOT_FOUND);
        }

        $this->em->remove($customer);
        $this->em->flush();
        return new JsonResponse(['message' => 'Customer removed successfully'], Response::HTTP_OK);
    }
}
