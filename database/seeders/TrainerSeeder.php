<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $trainer = new \App\Models\Trainer();

        $trainer->firstName = 'trainer';
        $trainer->lastName = 'trainer';
        $trainer->nationalID = '2807';
        $trainer->gender = 'female';
        $trainer->avatar = '';
        $trainer->email = 'trainer@ajyal.com';
        $trainer->mobile = '0597750952';
        // $adminUser->password = \Illuminate\Support\Facades\Hash::make('password');
        $trainer->save();
        
        $role = Role::create(['name' => 'trainer']);
        $permissions = [1,2,3];
        $role->syncPermissions($permissions);
        $trainer->assignRole($role);
    }
}