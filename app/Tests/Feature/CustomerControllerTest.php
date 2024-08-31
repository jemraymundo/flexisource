<?php

namespace Tests\Feature;

use App\Entities\Customer;
use App\Repositories\Doctrines\CustomerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{

    /**
     * Test the GET /customers endpoint.
     */
    public function test_can_retrieve_all_customers()
    {
        // @todo should have used Faker for the values
        
        $mockCustomer = new Customer();
        $mockCustomer->setProperty('firstName', 'Jem');
        $mockCustomer->setProperty('lastName', 'Raymundo');
        $mockCustomer->setProperty('email', 'jempogi123@gmail.com');
        $mockCustomer->setProperty('country', 'Australia');

        $repository = $this->createMock(CustomerRepository::class);
        $repository->method('findAll')->willReturn([$mockCustomer]);

        $this->app->instance(CustomerRepository::class, $repository);

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['full_name', 'email', 'country']
                 ]);
    }

    /**
     * Test the GET /customers/{customerId} endpoint.
     */
    public function test_can_retrieve_single_customer()
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

        $repository = $this->createMock(CustomerRepository::class);
        $repository->method('find')->willReturn($mockCustomer);

        $this->app->instance(CustomerRepository::class, $repository);

        $response = $this->getJson('/api/customers/1');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'full_name', 'email', 'username', 'gender', 'country', 'city', 'phone'
                 ]);
    }

    /**
     * Test the GET /customers/{customerId} endpoint with a non-existing customer.
     */
    public function test_cannot_retrieve_non_existing_customer()
    {
        $repository = $this->createMock(CustomerRepository::class);
        $repository->method('find')->willReturn(null);

        $this->app->instance(CustomerRepository::class, $repository);

        $response = $this->getJson('/api/customers/999');

        $response->assertStatus(404)
                 ->assertJson([
                     'error' => 'Customer not found'
                 ]);
    }
}
