<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        
        Gate::define('home-admin', function($user){
            //return count(array_intersect(["SUPERADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || 
                    $user->roles == 'ADMIN' || 
                    $user->roles == 'SUPERVISOR' || 
                    $user->roles == 'OWNER' || 
                    $user->roles == 'SALES-COUNTER'
            );
        });
        
        Gate::define('manage-client', function($user){
            //return count(array_intersect(["SUPERADMIN"], json_decode($user->roles)));
            return ($user->roles == 'OWNER');
        });

        Gate::define('manage-users', function($user){
            //return count(array_intersect(["SUPERADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN');
        });

        Gate::define('manage-categories', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-products', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN' || $user->roles == 'SUPERVISOR');
        });

        Gate::define('manage-vouchers', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-orders', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || 
                    $user->roles == 'ADMIN' || 
                    $user->roles == 'SUPERVISOR' ||
                    $user->roles == 'SALES-COUNTER'
                );
        });

        Gate::define('manage-edit-orders', function($user){
            //return count(array_intersect(["SUPERADMIN"], json_decode($user->roles)));
            return $user->roles == 'SUPERADMIN';
        });

        Gate::define('change-password', function($user){
           // return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || 
                    $user->roles == 'ADMIN' || 
                    $user->roles == 'OWNER' || 
                    $user->roles == 'SUPERVISOR' || 
                    $user->roles == 'SALES-COUNTER'
                );
        });

        Gate::define('manage-banner', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-sales', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN' || $user->roles == 'SUPERVISOR');
        });

        Gate::define('manage-customers', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN' || $user->roles == 'SUPERVISOR');
        });

        Gate::define('manage-spv', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-group', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-paket', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-target', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN' || $user->roles == 'SUPERVISOR');
        });

        Gate::define('work-plan', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('checkout-reasons', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('sales-login', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('point-vouchers', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('points-products', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('point-periods', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('customers-point', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('point-order-customers', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN' || $user->roles == 'SUPERVISOR');
        });

        Gate::define('claim-point-order', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN' || $user->roles == 'SUPERVISOR');
        });

        Gate::define('volume-discount', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });
    }
}
