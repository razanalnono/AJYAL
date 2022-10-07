<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Contact;
use App\Models\Info;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Info::factory()->create([
                'email' => 'ajyal@gmail.com',
                'mobile' => '0599455777',
                'telephone' => '08556465',
                'address' => 'تل الهوا بالقرب من كيرفور',
                'fax' => 'لايوجد فاكس',
            ]);

        // Contact::factory(10)->create();

    }
}
