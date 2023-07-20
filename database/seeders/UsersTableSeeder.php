<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        if (User::whereEmail('su@bythepixel.com')->exists()) {
            $this->command->warn('User already exists!');
            return;
        }

        User::factory()->create([
            'name' => 'BTP',
            'email' => 'su@bythepixel.com',
        ]);
    }
}
