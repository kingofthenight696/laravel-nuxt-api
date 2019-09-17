<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'second_name' => $this->second_name,
            'third_name' => $this->third_name,
            'gender' => $this->gender,
            'photo' => $this->photo,
            'phone' => $this->phone,
            'city' => $this->city,
            'street' => $this->street,
            'building_number' => $this->building_number,
        ];

    }
}
