<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $password = 11111111;
        factory(User::class)->create([
            'name' => 'Tester',
            'role_id' => Role::where('name', Role::ADMIN_ROLE)->first()->id,
            'email' => 'test@test.com',
            'password' => bcrypt($password),
        ]);

        factory(User::class, 50)->create([
            'role_id' => Role::where('name', Role::USER_ROLE)->first()->id,
            'password' => bcrypt($password),
        ]);
    }
}
