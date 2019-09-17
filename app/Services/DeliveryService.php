<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\Deliveries;
use App\Models\Distance;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DeliveryService
{
    public function getDeliveryCost(Deliveries $delivery, Distance $distance, float $productsWeight): int
    {
        return ceil($distance->distance * ($delivery->cost_per_km + $productsWeight * $delivery->mass_koeff_kg));
    }
}