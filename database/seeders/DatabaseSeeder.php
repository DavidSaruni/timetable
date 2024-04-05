<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([ // admin
            'title' => 'Eng',
            'name' => 'Samuel Uzima',
            'email' => 'samueluzima@kabarak.ac.ke',
            'password' => '23+67Timetable',
            'role' => 'ADMIN',
        ]);
        User::create([ // admin
            'title' => 'Eng',
            'name' => 'Captain David',
            'email' => 'nsaruni@kabarak.ac.ke',
            'password' => '23+67Timetable',
            'role' => 'ADMIN',
        ]);
        $this->call([
            UserSeeder::class,
        ]);
    }
}
