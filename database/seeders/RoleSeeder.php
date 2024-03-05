<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $role_manager = Role::create(['name' => 'MANAGER']);
        $role_student = Role::create(['name' => 'STUDENT']);
        $role_teacher = Role::create(['name' => 'TEACHER']);

        // Create permissions
        $create_user = Permission::create(['name' => 'create user']);
        $read_user = Permission::create(['name' => 'read user']);
        $edit_user = Permission::create(['name' => 'edit user']);
        $delete_user = Permission::create(['name' => 'delete user']);

        $create_role = Permission::create(['name' => 'create role']);
        $read_role = Permission::create(['name' => 'read role']);
        $edit_role = Permission::create(['name' => 'edit role']);
        $delete_role = Permission::create(['name' => 'delete role']);

        $create_project = Permission::create(['name' => 'create project']);
        $read_project = Permission::create(['name' => 'read project']);
        $edit_project = Permission::create(['name' => 'edit project']);
        $delete_project = Permission::create(['name' => 'delete project']);

        $create_events = Permission::create(['name' => 'create events']);
        $read_events = Permission::create(['name' => 'read events']);
        $edit_events = Permission::create(['name' => 'edit events']);
        $delete_events = Permission::create(['name' => 'delete events']);

        $create_news = Permission::create(['name' => 'create news']);
        $read_news = Permission::create(['name' => 'read news']);
        $edit_news = Permission::create(['name' => 'edit news']);
        $delete_news = Permission::create(['name' => 'delete news']);

        // Assign permissions to roles
        $gestor_permissions = [
            $create_user,
            $read_user,
            $edit_user,
            $delete_user,
            $create_role,
            $read_role,
            $edit_role,
            $delete_role,
            $create_project,
            $read_project,
            $edit_project,
            $delete_project,
            $create_events,
            $read_events,
            $edit_events,
            $delete_events,
            $create_news,
            $read_news,
            $edit_news,
            $delete_news
        ];

        $role_manager->syncPermissions($gestor_permissions);

        $student_permissions = [
            $read_user,
            $edit_user,
            $read_role,
            $create_project,
            $read_project,
            $edit_project,
            $read_events,
            $read_news
        ];

        $role_student->syncPermissions($student_permissions);

        $teacher_permissions = [
            $read_user,
            $read_role,
            $read_project,
            $read_events,
            $read_news
        ];

        $role_teacher->syncPermissions($teacher_permissions);
    }
}
