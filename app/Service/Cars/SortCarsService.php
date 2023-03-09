<?php

namespace App\Service\Cars;

use App\Http\Resources\CarsRecource;
use App\Models\Cars;

class SortCarsService
{
    public function sortAndFilter($data): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
            $cars = Cars::where('stolen', true)
                ->search($data)
                ->filter($data)
                ->orderByArray($data)
                ->paginate(10, ['*'], 'page');

            $filters = $this->getFilters($data);


            return  CarsRecource::collection($cars)->additional(['filters' => $filters ?? '']);
    }


    private function getFilters($data): array
    {
        $filters_before = Cars::where('stolen', true)
            ->search($data)
            ->filter($data)
            ->orderByArray($data)
            ->select('model', 'manufacturer', 'year')
            ->get()
            ->toArray();

        $filters = [];
        //Тут би ще сортування для фільтрів :)
        foreach ($filters_before as $filter) {
            foreach ($filter as $key => $value) {
                if (!in_array($value, $filters[$key.'s'] ?? [])) {
                    $filters[$key.'s'][] = $value;
                }
            }
        }

        return $filters;
    }

}
