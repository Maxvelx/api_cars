<?php

namespace App\Http\Controllers\API\Cars;

use App\Service\Cars\CarsService;
use App\Service\Cars\SortCarsService;

class BaseController
{
    public CarsService $service;
    public SortCarsService $filter;

    public function __construct(CarsService $service, SortCarsService $filter)
{
    $this->service = $service;
    $this->filter = $filter;
}
}
