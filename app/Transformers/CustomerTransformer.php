<?php

namespace App\Transformers;

use App\Entities\Customer;

class CustomerTransformer
{
    /**
     * Transform the given customer into an array.
     *
     * @param Customer $customer
     * @return array
     */
    public function transform(Customer $customer): array
    {
        return [
            'full_name' => $customer->fullName(),
            'email' => $customer->getProperty('email'),
            'username' => $customer->getProperty('username'),
            'gender' => $customer->getProperty('gender'),
            'country' => $customer->getProperty('country'),
            'city' => $customer->getProperty('city'),
            'phone' => $customer->getProperty('phone'),
        ];
    }
}
