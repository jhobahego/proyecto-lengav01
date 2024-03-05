<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        $student_user = User::create([
            'name' => 'invitado',
            'email' => 'user@correo.com',
            'password' => Hash::make('invitado'),
        ]);

        $admin_user->assignRole('MANAGER');
        $student_user->assignRole('STUDENT');
    }
}
