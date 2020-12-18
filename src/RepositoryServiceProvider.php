<?php

namespace Rabcreatives\Oppwa;

use Illuminate\Support\ServiceProvider;

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

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
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
