<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view medication']);
        Permission::create(['name' => 'create medication']);
        Permission::create(['name' => 'update medication']);
        Permission::create(['name' => 'delete medication']);
        Permission::create(['name' => 'p_delete medication']);
        Permission::create(['name' => 'view customer']);
        Permission::create(['name' => 'create customer']);
        Permission::create(['name' => 'update customer']);
        Permission::create(['name' => 'delete customer']);
        Permission::create(['name' => 'p_delete customer']);

        $role = Role::create(['name' => 'manager']);
        $role->givePermissionTo([
            'view medication',
            'update medication',
            'delete medication',
            'view customer',
            'update medication',
            'delete medication'
        ]);

        $role = Role::create(['name' => 'cashier']);
        $role->givePermissionTo([
            'view medication',
            'update medication',
            'view customer',
            'update medication',
        ]);

        $role = Role::create(['name' => 'owner']);
        $role->givePermissionTo(Permission::all());

    }
}
