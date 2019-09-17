<?php

use App\Models\Cities;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 30;
        factory(Cities::class, $count)->create();
    }
}
