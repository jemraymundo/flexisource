<?php

namespace App\Services;

use App\Entities\Customer;
use App\Repositories\Doctrines\CustomerRepository;
use \Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerService
{
    private $customerRepository;

    /**
     * CustomerService constructor
     * 
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Retrieve the list of all customers.
     *
     * @return array
     */
    public function findAllCustomers(): array
    {
        return $this->customerRepository->getAllCustomers();
    }


    /**
     * Get Customer by Id
     * 
     * @param string $customerId
     * @return array
     * @throws NotFoundHttpException
     */
    public function findCustomer(string $customerId): ?Customer
    {
        return $customer = $this->customerRepository->getCustomer($customerId);

        // if (!$customer instanceof Customer) {
        //     throw new NotFoundHttpException('Customer does not exist');
        // }

        // return $customer;
    }

}
