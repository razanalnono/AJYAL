<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = new \App\Models\Admin();

        $adminUser->firstName = 'Super-Admin';
        $adminUser->lastName= 'Super-Admin';
        $adminUser->nationalID='2807';
        $adminUser->gender='female';
        $adminUser->avatar='';
        $adminUser->email = 'superadmin@ajyal.com';
        $adminUser->mobile = '0597750952';
        $adminUser->password = \Illuminate\Support\Facades\Hash::make('password');
        $adminUser->save();
        $role = Role::updateOrCreate(['name' => 'Super-Admin',
         'guard_name' => 'admin']);
        $adminUser->assignRole($role);
        }
}