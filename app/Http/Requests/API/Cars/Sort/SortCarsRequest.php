<?php

namespace App\Http\Requests\API\Cars\Sort;

use Illuminate\Foundation\Http\FormRequest;

class SortCarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'page'            => 'max:255|string',
            'field'           => 'nullable|string|max:255',
            'direction'       => 'nullable|string|max:4',
            'keyword'         => 'nullable|string|max:255',
            'years'           => 'nullable|array',
            'years.*'         => 'string|max:255',
            'models'          => 'nullable|array',
            'models.*'        => 'string|max:255',
            'manufacturers'   => 'nullable|array',
            'manufacturers.*' => 'string|max:255',
            'export'          => 'integer|max:1'
        ];
    }
}
