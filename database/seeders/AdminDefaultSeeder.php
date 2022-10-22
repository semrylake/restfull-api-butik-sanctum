<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jufento Semri Lake',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('23117027'),
        ]);
        User::create([
            'name' => 'Semry Lake',
            'username' => 'admin2',
            'role' => 'admin',
            'password' => bcrypt('23117027'),
        ]);
    }
}
