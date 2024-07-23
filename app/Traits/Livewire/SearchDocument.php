<?php

namespace  App\Traits\Livewire;

use App\Models\Client as ModelsClient;
use App\Models\Provider;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;

trait SearchDocument
{
    public function searchDocument($type, $number)
    {
        $token = config('services.api_dni_ruc.token');
        $url = config('services.api_dni_ruc.url');

        $document_type = ($type == 'dni') ? 'DNI' : 'RUC';

        if ($type == 'dni') {
            $user = ModelsClient::where('document_number', $number)
                ->first();
        } else {
            $user = Provider::where('ruc', $number)
                ->first();
        }

        if ($user) {
            if ($type == 'ruc') {
                return [
                    'success' => true,
                    'nombre' => $user->name,
                ];
            } else {
                return [
                    'success' => true,
                    'nombre' => $user->name,
                ];
            }
        } else {
            $client = new Client(['base_uri' => $url, 'verify' => false]);

            $parameters = [
                'http_errors' => false,
                'connect_timeout' => 5,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Referer' => 'https://apis.net.pe/api-consulta-' . $type,
                    'User-Agent' => 'laravel/guzzle',
                    'Accept' => 'application/json',
                ],
                'query' => ['numero' => $number]
            ];
            // Para usar la versión 1 de la api, cambiar a /v1/ruc
            $res = $client->request('GET', '/v1/' . $type, $parameters);
            $response = json_decode($res->getBody()->getContents(), true);
            $status = $res->getStatusCode();
            if ($status == 200) {
                if ($type == 'ruc') {
                    Provider::create([
                        'ruc' => $number,
                        'name' => $response['nombre'],
                        'address' => $response['direccion'] ?? null,
                    ]);
                    return [
                        'success' => true,
                        'nombre' => $response['nombre'],
                    ];
                } else {
                    ModelsClient::create([
                        'type_document' => $document_type,
                        'document_number' => $number,
                        'username' => $number,
                        'name' => $response['nombres'] . ' ' . $response['apellidoPaterno'] . ' ' . $response['apellidoMaterno'],
                        'password' => Hash::make($number),
                    ]);
                    return [
                        'success' => true,
                        'nombre' => $response['nombres'] . ' ' . $response['apellidoPaterno'] . ' ' . $response['apellidoMaterno'],
                    ];
                }
            } else {
                return [
                    'success' => false,
                ];
            }
        }
    }
}
