<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItem extends JsonResource
{
    public function toArray($request)
    {
        return [
            'amount' => $this->resource['amount'] ?? 0,
            'id' => $this->resource['id'] ?? 0,
        ];
    }
}
