<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        function insertPermissionsIntoTable($targetPermissions) {
            $arrayOfPermissionNames = $targetPermissions;
            $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
                return ['name' => $permission, 'guard_name' => 'web'];
            });

            Permission::insert($permissions->toArray());
        }

        // List of Permissions
        $permissionsForAdmin = [
            'user index', 'show user', 'edit user', 'update user', 'destroy user', // users
            'task index', 'create task', 'store task', 'destroy task', // tasks
            'employee index', 'show employee', 'edit employee', 'update employee', // employees
            'destination index', 'create destination', 'store destination', 'show destination', 'edit destination', 'update destination', 'destroy destination', // destinations
            'registered-email index', 'create registered-email', 'store registered-email', // registered-emails
            'business-category index', 'create business-category', 'store business-category', 'edit business-category', 'update business-category', 'destroy business-category', // business-categories
            'schedule index', 'store schedule', 'destroy schedule' // schedules
        ];

        $permissionsForEmployee = [
            'mobile profile', 'mobile edit profile', 'mobile update profile', // users
            'mobile destination index', 'mobile show destination', // destinations
            'mobile goal index', 'mobile update goal', 'mobile goal history' // goals
        ];

        insertPermissionsIntoTable($permissionsForAdmin);
        insertPermissionsIntoTable($permissionsForEmployee);

        $admin = Role::create(['name'=>'admin'])->givePermissionTo($permissionsForAdmin);
        $employee = Role::create(['name'=>'employee'])->givePermissionTo($permissionsForEmployee);

        $count = User::all()->count();
        for ($id = 1; $id <= $count; $id++) {
            $user_name = User::query()->find($id);
            $job = $user_name->job;
            if ($job == 'admin') {
                $user_name->assignRole('admin');
            } else ($job == 'employee') {
                $user_name->assignRole('employee')
            };
        }
    }
}
