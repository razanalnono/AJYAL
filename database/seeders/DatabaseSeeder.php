<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Achievements;
use App\Models\Contact;
use App\Models\Group;
use App\Models\Info;
use App\Models\Program;
use App\Models\Project;
use App\Models\Social;
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

        // Info::factory()->create([
        //         'email' => 'ajyal@gmail.com',
        //         'mobile' => '0599455777',
        //         'telephone' => '08556465',
        //         'address' => 'تل الهوا بالقرب من كيرفور',
        //         'fax' => 'لايوجد فاكس',
        //     ]);

        // Contact::factory(10)->create();
        // Program::factory(10)->create();
        // Social::factory(1)->create();
        // Project::factory(10)->create();
        // Group::factory(30)->create();
        Achievements::factory(16)->create();
    }
}