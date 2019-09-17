<?php

use App\Models\Cities;
use App\Models\Deliveries;
use App\Models\Departments;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $cities = Cities::all();
        $deliveries = Deliveries::all();
        $departments = [];

        $deliveries->map(function ($delivery) use ($faker, $cities, &$departments) {
            $cities->map(function ($city) use ($faker, $delivery , &$departments) {

                $needsDepartmentsByCity = range(1, 10);
                foreach ($needsDepartmentsByCity as $index) {

                    $departments[] = [
                        'number' => $index,
                        'city_id' => $city->id,
                        'delivery_id' => $delivery->id,
                        'working_time' => json_encode([
                            'working' => 'Monday - Friday: 08:00-20:00',
                            'day_off' => 'Saturday - Sunday',
                        ]),
                        'address' => json_encode([
                            'street' => $faker->streetName,
                            'building' => $faker->buildingNumber,
                        ]),
                        'phone' => $faker->phoneNumber,
                    ];
                }
            });
        });

        Departments::insert($departments);
    }
}
