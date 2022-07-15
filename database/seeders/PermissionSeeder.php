<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'create_loan',
            'view_loan_detail',
            'view_loan_list',
            'view_loan_user',
            'view_loan_book',
            'view_loan_complete',
            'update_loan',
            'delete_loan',
            'create_book',
            'view_book_copies',
            'update_book',
            'delete_book',
            'create_author',
            'update_author',
            'delete_author',
            'create_publisher',
            'update_publisher',
            'delete_publisher',
            'create_copy',
            'view_copy_detail',
            'view_copy_list',
            'update_copy',
            'delete_copy'
        ];
        foreach ($permissions as $name){
            Permission::create([
                'name' => $name
            ]);
        }
    }
}
