<?php

namespace App\Service\Cars;

use App\Models\Cars;
use GuzzleHttp\Client;

class CarsService
{
    private mixed $url_decode_vin = 'https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVin/';
    private mixed $format = '?format=json';

    private mixed $result = [];

    private function decodeVin($vin): void
    {
        $client = new Client();

        $response = $client
            ->get($this->url_decode_vin.$vin.$this->format);

        $data = json_decode((string) $response->getBody());

        foreach ($data->Results as $object) {
            if (in_array($object->Variable, ["Make", "Model", "Model Year"])) {
                $this->result[$object->Variable] = $object->Value;
            }
        }
    }

    public function setKeyforValue($data)
    {
        $data['manufacturer'] = $this->result['Make'];
        $data['model']        = $this->result['Model'];
        $data['year']         = $this->result['Model Year'];

        return $data;
    }

    public function store($data)
    {
        try {

            \DB::beginTransaction();

            $this->decodeVin($data['vin_number']);

            $data = $this->setKeyforValue($data);

            Cars::firstOrCreate(
                [
                    'vin_number' => $data['vin_number']
                ],
                $data
            );

            \DB::commit();

            return response(['message' => 'Користувача додано в базу'], 201);

        } catch (\Exception $e) {
            \DB::rollBack();
            abort(500);
        }
    }

    public function update($data, $car)
    {
        try {

            \DB::beginTransaction();

            if ($data['vin_number'] !== $car->vin_number) {

                $this->decodeVin($data['vin_number']);

                $data = $this->setKeyforValue($data);
            }

            $car->update($data);

            \DB::commit();

            return response(['message' => 'Користувач був успішно відредагований'], 200);

        } catch (\Exception $e) {
            \DB::rollBack();
            abort(500);
        }
    }
}
