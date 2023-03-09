<?php

namespace App\Http\Controllers\API\Cars;

use App\Exports\Export\CarsExport;
use App\Http\Requests\API\Cars\Sort\SortCarsRequest;
use App\Http\Requests\API\Cars\StoreCarsRequest;
use App\Http\Requests\API\Cars\UpdateCarsRequest;
use App\Models\Cars;
use Maatwebsite\Excel\Facades\Excel;

class CarsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(SortCarsRequest $request)
    {
        if ($request->export == 1) {
            return Excel::download(new CarsExport($request->validated()), 'cars.xlsx');
        }
        return $this->filter->sortAndFilter($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarsRequest $request)
    {
        return $this->service->store($request->validated());
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarsRequest $request, Cars $car)
    {
        return $this->service->update($request->validated(), $car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cars $car)
    {
        $car->delete();

        return response(status: 200);
    }
}
