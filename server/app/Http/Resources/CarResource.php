<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'body_type_id' => $this->body_type_id,
            'fuel_id' => $this->fuel_id,
            'name' => $this->name,
            'year' => $this->year,
            'km_min' => $this->km_min,
            'km_max' => $this->km_max,
            'transmission' => $this->transmission,
            'status' => $this->status,
            'condition' => $this->condition,
            'price' => $this->price,
            'stock' => $this->stock,
            'image' => $this->image,
            'image_url' => $this->image_url,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'car_brand' => new CarBrandResource($this->whenLoaded('brand')),
            'car_body_type' => new CarBodyTypeResource($this->whenLoaded('bodyType')),
            'car_fuel' => new CarFuelResource($this->whenLoaded('fuel')),
            // 'detail_transactions' => DetailTransactionResource::collection($this->detailTransactions),
        ];
    }
}
