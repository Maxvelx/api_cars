<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{

    protected $table = 'cars';
    protected $guarded = false;

    // або fillable для більшої безпеки

    public function scopeFilter($query, $data)
    {
        return $query->when(isset($data['models'])
            || isset($data['manufacturers'])
            || isset($data['years']),

            function ($query) use ($data) {
                if (isset($data['manufacturers'])) {
                    $query->whereIn('manufacturer', $data['manufacturers']);
                }
                if (isset($data['models'])) {
                    $query->whereIn('model', $data['models']);
                }
                if (isset($data['years'])) {
                    $query->whereIn('year', $data['years']);
                }
            });
    }

    public function scopeSearch($query, $data)
    {
        return $query->when(isset($data['keyword']), function ($query) use ($data) {
            $query->where('gov_number', $data['keyword'])
                ->orWhere('name', $data['keyword'])
                ->orWhere('vin_number', $data['keyword']);
        });
    }

    public function scopeOrderByArray($query, $data)
    {
        return $query->when(isset($data['field']), function ($query) use ($data) {
            $query->orderBy($data['field'], $data['direction'] ?? 'asc');
        });
    }
}
