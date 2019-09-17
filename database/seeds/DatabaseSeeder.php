<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OrderStatusTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(DistancesTableSeeder::class);
    }
}
