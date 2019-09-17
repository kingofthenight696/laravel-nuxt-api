<?php

use App\Models\Cities;
use App\Models\Distance;
use Illuminate\Database\Seeder;

class DistancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = Cities::all();
        $distances = [];

        $cities->map(function ($city_from) use ($cities, &$distances) {
            $cities->map(function ($city_to) use ($city_from, &$distances) {

                $cost = ($city_from->id == $city_to->id) ? 0 : random_int(10, 1000);
                $distances[] = [
                    'city_from' => $city_from->id,
                    'city_to' => $city_to->id,
                    'distance' => $cost,
                ];
            });
        });

        Distance::insert($distances);
    }
}
