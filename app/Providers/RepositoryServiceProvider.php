<?php

namespace App\Providers;

use App\Repository\AddressRepository;
use App\Repository\BeneficiaryRepository;
use App\Repository\Contracts\Interfaces\AddressRepositoryInterface;
use App\Repository\Contracts\Interfaces\BeneficiaryRepositoryInterface;
use App\Repository\Contracts\Interfaces\CustomerRepositoryInterface;
use App\Repository\Contracts\Interfaces\OrderRepositoryInterface;
use App\Repository\Contracts\Interfaces\PageRepositoryInterface;
use App\Repository\Contracts\Interfaces\ProcessRepositoryInterface;
use App\Repository\Contracts\Interfaces\ProductRepositoryInterface;
use App\Repository\Contracts\Interfaces\ServiceRepositoryInterface;
use App\Repository\Contracts\Interfaces\TemplateRepositoryInterface;
use App\Repository\Contracts\Interfaces\TenantRepositoryInterface;
use App\Repository\Contracts\Interfaces\UserRepositoryInterface;
use App\Repository\Contracts\Interfaces\SpacecraftRepositoryInterface;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Repository\PageRepository;
use App\Repository\ProcessRepository;
use App\Repository\ProductRepository;
use App\Repository\ServiceRepository;
use App\Repository\TemplateRepository;
use App\Repository\TenantRepository;
use App\Repository\UserRepository;
use App\Repository\SpacecraftRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->singleton(BeneficiaryRepositoryInterface::class, BeneficiaryRepository::class);
        $this->app->singleton(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->singleton(ProcessRepositoryInterface::class, ProcessRepository::class);
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->singleton(TemplateRepositoryInterface::class, TemplateRepository::class);
        $this->app->singleton(TenantRepositoryInterface::class, TenantRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(PageRepositoryInterface::class, PageRepository::class);
        $this->app->singleton(SpacecraftRepositoryInterface::class, SpacecraftRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
