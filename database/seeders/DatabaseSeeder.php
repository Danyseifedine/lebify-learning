<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DifficultyLevel;
use App\Models\Duration;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Create roles
        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'student']);

        // \App\Models\User::factory()->create([
        //     'name' => 'Dany Seifeddine',
        //     'email' => 'dany.a.seifeddine@gmail.com',
        //     'password' => Hash::make('idkpass881@@'),
        // ])->addRole('admin');

        Duration::create([
            'name' => 'Rapid',
            'minutes' => 10,
        ]);

        Duration::create([
            'name' => 'Blitz',
            'minutes' => 5,
        ]);

        Duration::create([
            'name' => 'Bullet',
            'minutes' => 2,
        ]);

        DifficultyLevel::create([
            'level' => 1,
            'name' => 'Beginner',
        ]);

        DifficultyLevel::create([
            'level' => 2,
            'name' => 'Intermediate',
        ]);

        DifficultyLevel::create([
            'level' => 3,
            'name' => 'Advanced',
        ]);
    }
}
