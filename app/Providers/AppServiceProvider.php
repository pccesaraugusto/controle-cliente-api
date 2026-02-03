<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ClientRepository;
use App\Services\ClientService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ClientRepository::class, function ($app) {
            return new ClientRepository();
        });

        $this->app->singleton(ClientService::class, function ($app) {
            return new ClientService($app->make(ClientRepository::class));
        });
    }

    public function boot(): void
    {
        // Bootstrapping if needed
    }
}
