<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "car_count"=>$this->cars->count(),
            //"car_list"=>CarResource::collection($this->cars)
        ];
    }
}
