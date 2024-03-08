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
            'password' => Hash::make('adminpassword'),
        ]);

        $student_user = User::create([
            'name' => 'invitado',
            'email' => 'user@correo.com',
            'password' => Hash::make('invitado'),
        ]);

        $teacher_user = User::create([
            'name' => 'guillermo antonio',
            'email' => 'guillermo.antonio@uniremington.edu.co',
            'password' => Hash::make('guillermo'),
        ]);

        $admin_user->assignRole('MANAGER');
        $student_user->assignRole('STUDENT');
        $teacher_user->assignRole('TEACHER');
    }
}
