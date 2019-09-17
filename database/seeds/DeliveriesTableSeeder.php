<?php

use App\Models\Deliveries;
use Illuminate\Database\Seeder;

class DeliveriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 4;
        factory(Deliveries::class, $count)->create();
    }
}
