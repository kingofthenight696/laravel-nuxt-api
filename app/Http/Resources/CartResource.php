<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class CartResource extends JsonResource
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
            'id' => $this->id ?? null,
            'user_id' => $this->user_id ?? null,
            'total_quantity' => $this->total_quantity ?? 0,
            'product_price' => $this->product_price ?? 0,
            'total_price' => $this->total_price ?? 0,
            'cart_items' => $this->cartItems ?? [],
            'shipping' => $this->shipping ?? null,
            'contacts' => $this->contact ?? null,
        ];
    }
}
