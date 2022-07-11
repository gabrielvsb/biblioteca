<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    public function run(): void
    {

        $toEmployee = [
            'create_loan',
            'view_loan_detail',
            'view_loan_list',
            'view_loan_user',
            'view_loan_book',
            'view_loan_complete',
            'update_loan',
            'create_book',
            'view_book_loans',
            'update_book',
            'create_author',
            'update_author',
            'create_publisher',
            'update_publisher',
        ];

        $toReader = [
            'view_loan_detail',
            'view_loan_user',
            'view_loan_book',
            'view_loan_complete',
        ];

        $permissionsEmpployees = Permission::whereIn('name', $toEmployee)->pluck('id', 'id');
        $permissionsReaders = Permission::whereIn('name', $toReader)->pluck('id', 'id');
        $permissionsAdmin = Permission::pluck('id', 'id');

        Role::findByName('employee')->syncPermissions($permissionsEmpployees);
        Role::findByName('reader')->syncPermissions($permissionsReaders);
        Role::findByName('admin')->syncPermissions($permissionsAdmin);
    }
}
