<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //permission for roles
        Permission::create(['name' => 'roles.index']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.delete']);

        //permission for permissions
        Permission::create(['name' => 'permissions.index']);

        //permission for users
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'accounts.index']);
        Permission::create(['name' => 'accounts.create']);
        Permission::create(['name' => 'accounts.edit']);
        Permission::create(['name' => 'accounts.delete']);
        Permission::create(['name' => 'journals.index']);
        Permission::create(['name' => 'journals.create']);
        Permission::create(['name' => 'journals.edit']);
        Permission::create(['name' => 'journals.delete']);
        Permission::create(['name' => 'expenses.index']);
        Permission::create(['name' => 'expenses.create']);
        Permission::create(['name' => 'expenses.edit']);
        Permission::create(['name' => 'expenses.delete']);
        Permission::create(['name' => 'vendrs.index']);
        Permission::create(['name' => 'vendrs.create']);
        Permission::create(['name' => 'vendrs.edit']);
        Permission::create(['name' => 'vendrs.delete']);
        Permission::create(['name' => 'transactions.index']);
        Permission::create(['name' => 'transactions.create']);
        Permission::create(['name' => 'transactions.edit']);
        Permission::create(['name' => 'transactions.delete']);
        Permission::create(['name' => 'taxes.index']);
        Permission::create(['name' => 'taxes.create']);
        Permission::create(['name' => 'taxes.edit']);
        Permission::create(['name' => 'taxes.delete']);
        Permission::create(['name' => 'budget-plans.index']);
        Permission::create(['name' => 'budget-plans.create']);
        Permission::create(['name' => 'budget-plans.edit']);
        Permission::create(['name' => 'budget-plans.delete']);
    }
}
