<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions=['store-page-content','update-page-content','delete-page-content',
                      'add-news','update-news','delete-news',
                    'store-contact','delete-contact',
                    'store-info','update-info','delete-info',
                    'store-program','update-program','delete-program',
                    'add-social','update-social','delete-social',
                    
                   'index-admin', 'add-admin','update-admin','delete-admin',
                   'index-trainee','show-trainee' , 'add-trainee','update-trainee','delete-trainee',
                    'index-trainer','show-trainer','add-trainer','update-trainer','delete-trainer',
                    
                   'index-project','show-project', 'add-project','update-project','delete-project',
                    'index-group','add-group','update-group','delete-group',
                   'index-course','show-course', 'add-course','update-course','delete-course',
                   'index-achievements','show-achievements', 'add-achievements','update-achievements','delete-achievements',
                    'index-apresence','add-apresence','delete-apresence',
                    'index-city','show-city','add-city','update-city','delete-city',
                    'index-rate','add-rate','update-rate','delete-rate',
                   'index-work' ,'add-work','update-work','delete-work',
                    'send-notifications'];

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }
    }
}