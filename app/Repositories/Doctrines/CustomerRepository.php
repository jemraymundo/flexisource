<?php

namespace App\Repositories\Doctrines;

use App\Entities\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Hidehalo\Nanoid\Client;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{
    private $nanoId;

    /**
     * Summary of __construct
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \Hidehalo\Nanoid\Client $nanoId
     */
    public function __construct(EntityManagerInterface $em, Client $nanoId)
    {
        parent::__construct($em, $em->getClassMetadata(Customer::class));

        $this->nanoId = $nanoId;
    }

    public function getAllCustomers(): array
    {
        return $this->findBy([]) ?? [];
    }

    public function getCustomer($id)
    {
        return $this->findOneBy(['id'=> $id]);
    }

    /**
     * Upsert the user details
     * 
     * @param \App\Entities\Customer $customer
     * @return \App\Entities\Customer
     */
    public function upsert(Customer $customer): Customer
    {
        $result = $customer;

        $existingCustomer = $this->findOneBy(['email' => $customer->getProperty('email')]);

        if ($existingCustomer instanceof Customer) {
            $existingCustomer->setProperty('firstName', $customer->getProperty('firstName'));
            $existingCustomer->setProperty('lastName', $customer->getProperty('lastName'));
            $existingCustomer->setProperty('email', $customer->getProperty('email'));
            $existingCustomer->setProperty('username', $customer->getProperty('username'));
            $existingCustomer->setProperty('password', $customer->getProperty('password'));
            $existingCustomer->setProperty('gender', $customer->getProperty('gender'));
            $existingCustomer->setProperty('country', $customer->getProperty('country'));
            $existingCustomer->setProperty('city', $customer->getProperty('city'));
            $existingCustomer->setProperty('phone', $customer->getProperty('phone'));
            $customer->setProperty('updatedAt', new \DateTime());

            $this->getEntityManager()->merge($existingCustomer);
            
            $result = $existingCustomer;
            
        } else {
            $customer->setProperty('id', $this->nanoId->generateId($size = 21));
            $customer->setProperty('createdAt', new \DateTime());
            $customer->setProperty('updatedAt', new \DateTime());

            $this->getEntityManager()->persist($customer);
        }

        $this->getEntityManager()->flush();

        return $result;
    }
}
