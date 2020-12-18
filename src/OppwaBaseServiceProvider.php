<?php

namespace Rabcreatives\Oppwa;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Rabcreatives\Oppwa\Http\Controllers\CheckoutController;
use Rabcreatives\Oppwa\Facades\Oppwa;

use Rabcreatives\Oppwa\Components\Interfaces\ConfigurationRepositoryInterface;
use Rabcreatives\Oppwa\Components\Interfaces\IntegrationRepositoryInterface;
use Rabcreatives\Oppwa\Components\Interfaces\CredentialRepositoryInterface;
use Rabcreatives\Oppwa\Components\Interfaces\HistoryRepositoryInterface;
use Rabcreatives\Oppwa\Components\Interfaces\InvoiceRepositoryInterface;
use Rabcreatives\Oppwa\Components\Interfaces\TransactionRepositoryInterface;
use Rabcreatives\Oppwa\Components\Configuration\ConfigurationRepository;
use Rabcreatives\Oppwa\Components\Integration\IntegrationRepository;
use Rabcreatives\Oppwa\Components\Credential\CredentialRepository;
use Rabcreatives\Oppwa\Components\History\HistoryRepository;
use Rabcreatives\Oppwa\Components\Invoice\InvoiceRepository;
use Rabcreatives\Oppwa\Components\Transaction\TransactionRepository;



class OppwaBaseServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerResources();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->commands([
            Console\ProcessCommand::class,
        ]);

         $this->registerRepositories();
    }


    /**
     * Register the package resources.
     *
     * @return void
     */
    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'oppwa');

        $this->registerFacades();
        $this->registerRoutes();
        //$this->registerFields();
    }



    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/oppwa.php' => config_path('oppwa.php'),
        ], 'oppwa-config');

    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php', 'oppwa');
        });
    }

    /**
     * Get the Oppwa route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
           // 'prefix' => 'oppwa',
            'as' => 'oppwa.checkout',
            'namespace' => 'Rabcreatives\Oppwa\Http\Controllers',
        ];
    }

    /**
     * Register any bindings to the app.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $this->app->singleton('Oppwa', function ($app) {
            return new \Rabcreatives\Oppwa\Oppwa();
        });
    }


    protected function registerRepositories()
    {
        $this->app->bind(
            ConfigurationRepositoryInterface::class,
            ConfigurationRepository::class
        );

        $this->app->bind(
            IntegrationRepositoryInterface::class,
            IntegrationRepository::class
        );

        $this->app->bind(
            CredentialRepositoryInterface::class,
            CredentialRepository::class
        );

        $this->app->bind(
            InvoiceRepositoryInterface::class,
            InvoiceRepository::class
        );

        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class
        );

        $this->app->bind(
            HistoryRepositoryInterface::class,
            HistoryRepository::class
        );
    }
}
