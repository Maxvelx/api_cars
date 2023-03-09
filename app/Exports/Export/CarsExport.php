<?php

namespace App\Exports\Export;

use App\Models\Cars;
use Maatwebsite\Excel\Concerns\FromCollection;

class CarsExport implements FromCollection
{

    public mixed $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Cars::where('stolen', true)
            ->search($this->data)
            ->filter($this->data)
            ->orderByArray($this->data)
            ->limit(1000)
            ->get();
    }
}
