<?php
namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use App\Providers\AppServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            AppServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Use in-memory sqlite for faster tests
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        // Create clients table in in-memory sqlite for feature tests
        $schema = $app['db']->connection()->getSchemaBuilder();
        if (! $schema->hasTable('clients')) {
            $schema->create('clients', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('phone')->nullable();
                $table->string('cpf')->nullable();
                $table->string('address')->nullable();
                $table->date('birth_date')->nullable();
                $table->string('status')->default('active');
                $table->timestamps();
            });
        }

        // Load package routes for tests
        require_once __DIR__ . '/../routes/api.php';
    }
}
