<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'employee', 'reader'] as $name){
            Role::create([
               'name' => $name
            ]);
        }
    }
}
