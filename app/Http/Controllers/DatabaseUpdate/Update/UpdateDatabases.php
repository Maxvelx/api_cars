<?php

namespace App\Http\Controllers\DatabaseUpdate\Update;

use App\Models\CarModel;
use App\Models\Manufacturer;
use GuzzleHttp\Client;

class UpdateDatabases
{
    private mixed $url_manufacturer = 'https://vpic.nhtsa.dot.gov/api/vehicles/getallmakes';
    private mixed $url_models = 'https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformakeid/';

    private mixed $format = '?format=json';

    public function update()
    {
        $client = new Client();

        //Получаемо виробників
        $response = $client
            ->get($this->url_manufacturer.$this->format);

        //конвертуємо в колекцію
        $manufacturers_data = json_decode((string) $response->getBody());

        //створюємо массив $manufacturers, туди кладемо массив $models, все це підготовлюємо до оновлення або створення
        $manufacturers = array_map(function ($manufacturer_data) use ($client) {
            $manufacturer = Manufacturer::updateOrCreate(
                ['make_id' => $manufacturer_data->Make_ID],
                ['title' => $manufacturer_data->Make_Name]
            );

            //Получаемо моделі
            $response = $client->get($this->url_models.$manufacturer->make_id.$this->format);
            //конвертуємо
            $models_data = json_decode((string) $response->getBody());
            // підготовлюємо
            $models = array_map(function ($model_data) use ($manufacturer) {
                return new CarModel([
                    'model_id'        => $model_data->Model_ID,
                    'manufacturer_id' => $manufacturer->id,
                    'title'           => $model_data->Model_Name
                ]);
            }, $models_data->Results);

            $manufacturer->carModels()->saveMany($models);

            return $manufacturer;
        }, $manufacturers_data->Results);


        //Записуємо
        Manufacturer::upsert($manufacturers, ['make_id'], ['title']);
        CarModel::upsert($manufacturers->flatMap(function ($manufacturer) {
            return $manufacturer->carModels;
        })->all(), ['model_id'], ['manufacturer_id', 'title']);

    }
}
