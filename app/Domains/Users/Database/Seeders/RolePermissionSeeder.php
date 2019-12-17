<?php

namespace App\Domains\Users\Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Permission list
        Permission::create(['name' => 'admin.menu']);
        //Roles module
        Permission::create(['name' => 'role.index']);
        Permission::create(['name' => 'role.create']);
        Permission::create(['name' => 'role.show']);
        Permission::create(['name' => 'role.edit']);
        //Permission module
        Permission::create(['name' => 'permission.index']);
        Permission::create(['name' => 'permission.create']);
        Permission::create(['name' => 'permission.edit']);
        Permission::create(['name' => 'permission.show']);
        //User Module
        Permission::create(['name' => 'user.index']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.show']);

        //Admin Role
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
