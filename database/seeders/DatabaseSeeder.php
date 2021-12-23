<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create(['name' => 'student']);
        $role = Role::create(['name' => 'admin']);


        $add_assignments = Permission::create(['name' => 'add assignments']);
        $add_quizzes = Permission::create(['name' => 'add quizzes']);
        $add_badges = Permission::create(['name' => 'add badges']);

        $role = Role::create(['name' => 'teaching_assistant']);
        $role->givePermissionTo($add_assignments);
        $role->givePermissionTo($add_quizzes);
        $role->givePermissionTo($add_badges);

        $role = Role::create(['name' => 'instructor']);
        $role->givePermissionTo($add_assignments);
        $role->givePermissionTo($add_quizzes);
        $role->givePermissionTo($add_badges);

        // \App\Models\User::factory(10)->create();
    }
}
