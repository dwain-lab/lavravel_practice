<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class PermissionDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'edit models']);
        Permission::create(['name' => 'delete models']);
        Permission::create(['name' => 'create models']);
        Permission::create(['name' => 'view models']);
        Permission::create(['name' => 'export models']);
        Permission::create(['name' => 'import models']);
        Permission::create(['name' => 'administrator']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'viewer']);
        $role1->givePermissionTo('view models');

        $role3 = Role::create(['name' => 'editor']);
        $role3->givePermissionTo('edit models');
        $role3->givePermissionTo('view models');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('edit models');
        $role2->givePermissionTo('create models');
        $role2->givePermissionTo('view models');
        $role2->givePermissionTo('export models');
        $role2->givePermissionTo('administrator');

        $role4 = Role::create(['name' => 'super admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
    }
}
