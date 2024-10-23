<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'student']);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'x@x.com',
            'password' => Hash::make('x'),
        ])->addRole('admin');
    }
}
