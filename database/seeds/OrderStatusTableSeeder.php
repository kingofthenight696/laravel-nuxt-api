<?php

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (OrderStatus::ORDER_STATUSES as $orderStatus) {

            factory(OrderStatus::class)->create([
                'name' => $orderStatus,
            ]);
        }
    }
}
