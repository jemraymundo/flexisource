<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entities\Customer;
use App\Transformers\CustomerTransformer;

class CustomerController extends Controller
{
    private $customerService;
    protected $customerTransformer;

    /**
     * CustomerController constructor
     * 
     * @param CustomerService $customerService
     * @param CustomerTransformer $customerTransformer
     */
    public function __construct(
        CustomerService $customerService, 
        CustomerTransformer $customerTransformer
    ){
        $this->customerService = $customerService;
        $this->customerTransformer = $customerTransformer;
    }

    /**
     * Retrieve the list of all customers.
     *
     * @return JsonResponse
     */
    public function getAllCustomers(): JsonResponse
    {
        $customers = $this->customerService->findAllCustomers();

        //@todo whould have a transformer that handles collections
        $response = array_map(function($customer) {
            return [
                'full_name' => $customer->fullName(),
                'email' => $customer->getProperty('email'),
                'country' => $customer->getProperty('country')
            ];
        }, $customers);

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Retrieve details of a single customer by ID.
     *
     * @param string $customerId
     * @return JsonResponse
     */
    public function getCustomer(string $customerId): JsonResponse
    {
        $customer = $this->customerService->findCustomer($customerId);

        //@todo should be on the service layer 
        if (!$customer instanceof Customer) {
            return response()->json(['error' => 'Customer not found'], Response::HTTP_NOT_FOUND);
        }

        $response = $this->customerTransformer->transform($customer);

        return response()->json($response, Response::HTTP_OK);
    }
}
