<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryCollection;
use App\Models\Deliveries;
use App\Models\Distance;
use App\Models\Product;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function getDeliveryDepartment(Request $request, Deliveries $deliveries)
    {
        try {
            $products = $request->get('product_ids');
            $cityTo = $request->get('city_id');

            $deliveries = $deliveries->getDeliveriesByCity($cityId = 1)->get();

            $distance = Distance::whereCityFrom(1)->whereCityTo($cityTo)->first();
            $productsWeight = Product::find($products)->sum('weight');

            $deliveries->map(function ($delivery) use ($distance, $productsWeight) {
                $deliveryCost = $distance->distance * ($delivery->cost_per_km + $productsWeight * $delivery->mass_koeff_kg);
                $delivery->delivery_cost = ceil($deliveryCost);
            });


        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new DeliveryCollection($deliveries));
    }
}
