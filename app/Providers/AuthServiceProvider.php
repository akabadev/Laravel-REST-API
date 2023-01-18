<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Beneficiary;
use App\Models\Customer;
use App\Models\Listing;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PersonalAccessToken;
use App\Models\Product;
use App\Models\Service;
use App\Models\Template;
use App\Models\Tenant;
use App\Models\User;
use App\Policies\AddressPolicy;
use App\Policies\BeneficiaryPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\ListingPolicy;
use App\Policies\OrderDetailPolicy;
use App\Policies\OrderPolicy;
use App\Policies\PersonalAccessTokenPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ServicePolicy;
use App\Policies\TemplatePolicy;
use App\Policies\TenantPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Address::class => AddressPolicy::class,
        Beneficiary::class => BeneficiaryPolicy::class,
        Customer::class => CustomerPolicy::class,
        OrderDetail::class => OrderDetailPolicy::class,
        Order::class => OrderPolicy::class,
        Product::class => ProductPolicy::class,
        Service::class => ServicePolicy::class,
        User::class => UserPolicy::class,
        Tenant::class => TenantPolicy::class,
        Template::class => TemplatePolicy::class,
        PersonalAccessToken::class => PersonalAccessTokenPolicy::class,
        Listing::class => ListingPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
