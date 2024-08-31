<?php

namespace App\Providers;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Doctrines\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CustomerRepositoryInterface::class, function ($app) {
            return new CustomerRepository($app->make(EntityManagerInterface::class));
        });
    }
}
