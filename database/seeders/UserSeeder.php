<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'dev@krogen.ro';
        $raw = env('DEV_USER_PASSWORD');

        User::updateOrCreate([
            'email' => $email,
        ], [
            'name' => 'Developer',
            'password' => Hash::make($raw),
        ]);
    }
}
