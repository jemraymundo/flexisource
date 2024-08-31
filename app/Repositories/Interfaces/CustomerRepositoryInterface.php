<?php

namespace App\Repositories\Interfaces;

use App\Entities\Customer;

interface CustomerRepositoryInterface
{
    /**
     * Summary of upSertMultiple
     * 
     * @param Customer $customer
     * @return Customer
     */
    public function upsert(Customer $customer): Customer;


}
