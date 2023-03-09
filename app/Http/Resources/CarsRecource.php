<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarsRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'gov_number'   => $this->gov_number,
            'color'        => $this->color,
            'vin_number'   => $this->vin_number,
            'manufacturer' => $this->manufacturer,
            'model'        => $this->model,
            'year'         => $this->year,
        ];
    }
}
