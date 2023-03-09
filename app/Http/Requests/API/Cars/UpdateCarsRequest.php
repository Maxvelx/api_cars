<?php

namespace App\Http\Requests\API\Cars;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarsRequest extends FormRequest
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
            'name'       => 'required|string|max:255',
            'gov_number' => 'required|string|max:10',
            'color'      => 'required|string|max:255',
            'vin_number' => 'required|string|max:17|min:17|unique:cars,vin_number',
        ];
    }

    public function messages()
    {
        return [
            'name.required'       => 'Обов\'язково до заповнення',
            'gov_number.max'      => 'Максимальна кількість символів 10',
            'color.required'      => 'Вкажіть колір',
            'vin_number.required' => 'Обов\'язково до заповнення',
            'vin_number.max'      => 'Кількість символів повинна бути 17',
            'vin_number.min'      => 'Кількість символів повинна бути 17',
            'vin_number.unique'   => 'Введений Vin код вже є в базі',
        ];
    }
}
