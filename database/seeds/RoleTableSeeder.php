<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Role::ROLES as $role) {
            factory(Role::class)->create([
                'name' => $role,
            ]);
        }
    }
}
