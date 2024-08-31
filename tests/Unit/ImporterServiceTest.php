<?php

namespace Tests\Unit;

use App\Services\ImporterService;
use App\Gateways\RandomUserGateway;
use App\Repositories\Doctrines\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entities\Customer;
use PHPUnit\Framework\TestCase;

class ImporterServiceTest extends TestCase
{
    /**
     * Test that service correctly fetches and processes customers.
     */
    public function test_service_fetches_and_processes_customers()
    {
        $mockCustomer = new Customer();
        $mockCustomer->setProperty('firstName', 'Jem');
        $mockCustomer->setProperty('lastName', 'Raymundo');
        $mockCustomer->setProperty('email', 'jempogi123@gmail.com');
        $mockCustomer->setProperty('username', 'johnny');
        $mockCustomer->setProperty('gender', 'male');
        $mockCustomer->setProperty('country', 'Australia');
        $mockCustomer->setProperty('city', 'Sydney');
        $mockCustomer->setProperty('phone', 'Sydney');


        $mockResponse = [
            'results' => [
                [
                    'name' => ['first' => 'Jem', 'last' => 'Raymundo'],
                    'email' => 'jempogi123@gmail.com',
                    'login' => ['username' => 'johnny', 'password' => 'jempogi123'],
                    'gender' => 'male',
                    'location' => ['country' => 'Australia', 'city' => 'Sydney'],
                    'phone' => '123-456-7890',
                ]
            ]
        ];

        $repository = $this->createMock(CustomerRepository::class);
        $repository->method('upsert')->willReturn($mockCustomer);

        $em = $this->createMock(EntityManagerInterface::class);

        $gateway = $this->createMock(RandomUserGateway::class);
        $gateway->method('fetchUsers')->willReturn($mockResponse['results']);

        $service = new ImporterService($em, $gateway, $repository);
        $customers = $service->fetchUsers(1, 'AU');

        $this->assertCount(1, $customers);
        $this->assertEquals('Jem', $customers[0]->getProperty('firstName'));
        $this->assertEquals('jempogi123@gmail.com', $customers[0]->getProperty('email'));
        $this->assertEquals('Australia', $customers[0]->getProperty('country'));
    }

    /**
     * Test that service handles an error during customer fetching.
     */
    public function test_service_handles_fetch_error()
    {
        $repository = $this->createMock(CustomerRepository::class);
        $em = $this->createMock(EntityManagerInterface::class);

        $gateway = $this->createMock(RandomUserGateway::class);
        $gateway->method('fetchUsers')->willThrowException(new \Exception('Failed to fetch customers'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to fetch customers');

        $service = new ImporterService($em, $gateway, $repository);
        $service->fetchUsers(1, 'AU');
    }
}
