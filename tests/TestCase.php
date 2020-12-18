<?php

namespace Rabcreatives\Oppwa\Tests;

use Rabcreatives\Oppwa\OppwaBaseServiceProvider
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected function getPackageProviders($app)
    {
        return [
            OppwaBaseServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetup($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
