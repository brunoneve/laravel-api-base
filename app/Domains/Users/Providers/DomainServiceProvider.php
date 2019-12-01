<?php

namespace App\Domains\Users\Providers;

use App\Domains\Users\Database\Migrations\CreatePasswordResetTable;
use App\Domains\Users\Database\Migrations\CreateUsersTable;
use Illuminate\Support\ServiceProvider;
use Migrator\MigratorTrait as HasMigrations;

class DomainServiceProvider extends ServiceProvider
{
    use HasMigrations;

    public function register()
    {
        $this->registerMigrations();
        $this->registerFactories();
    }

    protected function registerMigrations()
    {
        $this->migrations([
            CreateUsersTable::class,
            CreatePasswordResetTable::class,
        ]);
    }

    protected function registerFactories()
    {

    }
}
