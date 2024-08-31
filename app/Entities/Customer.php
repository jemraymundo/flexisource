<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers", indexes={
 *      @ORM\Index(name="customers_password_idx", columns={"password"}),
 *      @ORM\Index(name="customers_created_at_idx", columns={"created_at"}),
 *      @ORM\Index(name="customers_updated_at_idx", columns={"updated_at"})
 * })
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=150, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=150, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="text")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=6, options={"default": "male"})
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $country;

    /**
     * @ORM\Column(type="text")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP", "onUpdate": "CURRENT_TIMESTAMP"})
     */
    private $updatedAt;


    /**
     * Mutator of first name and last name
     * 
     */
    public function fullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }


    /**
     * Set Property
     * 
     * @param string $property
     * @param mixed $value
     * @return \App\Entities\Customer
     */
    public function setProperty(string $property, $value): self
    {
        $this->{$property} = $value;
        return $this;
    }

    /**
     * Get the Property
     * @param string $property
     * @return mixed
     */
    public function getProperty(string $property)
    {
        return $this->{$property};
    }
}
