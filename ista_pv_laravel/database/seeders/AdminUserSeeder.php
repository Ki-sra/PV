<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $now = now();
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('ChangeMe123!'),
            'role' => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
