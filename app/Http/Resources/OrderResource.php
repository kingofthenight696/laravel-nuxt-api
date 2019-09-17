<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_quantity' => $this->total_quantity,
            'product_price' => $this->product_price,
            'total_price' => $this->total_price,
            'items' => $this->items,
            'full_shipment' => $this->fullShipment,
            'contacts' => $this->contact,
            'created_at' => $this->created_at,
            'order_status' => $this->order_status,
        ];
    }
}
