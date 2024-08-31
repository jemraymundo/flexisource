<?php

namespace App\Services;

use App\Entities\Customer;
use Doctrine\ORM\EntityManagerInterface;
use App\Gateways\RandomUserGateway;
use App\Repositories\Doctrines\CustomerRepository;

class ImporterService
{
    protected $entityManager;

    protected $randomUserGateway;

    protected $customerRepository;

    /**
     * ImporterService constructor
     * 
     * @param EntityManagerInterface $entityManager
     * @param RandomUserGateway $randomUserGateway
     */
    public function __construct(
        EntityManagerInterface $entityManager, 
        RandomUserGateway $randomUserGateway, 
        CustomerRepository $customerRepository
    ){
        $this->entityManager = $entityManager;
        $this->randomUserGateway = $randomUserGateway;
        $this->customerRepository = $customerRepository;
    }
    /**
     * Fetch the user
     * 
     * @param integer $totalUsers
     * @param string $nationality
     * @return array
     */
    public function fetchUsers($totalUsers = 100, $nationality = 'AU'): array
    {
        $results = [];

        $customers = $this->randomUserGateway->fetchUsers($totalUsers, $nationality);

        foreach ($customers as $customer) {
            $results[] = $this->createCustomer($customer);
        }

        return $results;
    }

    /**
     * Create Customer
     * 
     * @param array $data
     * @return Customer
     */
    protected function createCustomer(array $data): Customer
    {
        $customer = new Customer();
        $customer->setProperty('firstName', $data['name']['first']);
        $customer->setProperty('lastName', $data['name']['last']);
        $customer->setProperty('email', $data['email']);
        $customer->setProperty('username', $data['login']['username']);
        $customer->setProperty('password', md5($data['login']['password']));
        $customer->setProperty('gender', $data['gender']);
        $customer->setProperty('country', $data['location']['country']);
        $customer->setProperty('city', $data['location']['city']);
        $customer->setProperty('phone', $data['phone']);

        return $this->customerRepository->upsert($customer);
    }
}
