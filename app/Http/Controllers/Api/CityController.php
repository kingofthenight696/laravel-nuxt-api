<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityCollection;
use App\Models\Cities;

class CityController extends Controller
{
    public function getCities()
    {
        if ($cities = Cities::all()) {
            return $this->successApiResponse(null, new CityCollection($cities));
        }

        return $this->errorApiResponse('Not found');
    }
}
