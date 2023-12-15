<?php

namespace  App\Traits\Livewire;

use App\Models\Client as ModelsClient;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;

trait SearchSunat
{
    public function searchDocument($type, $number)
    {
        $token = config('services.api_dni_ruc.token');
        $url = config('services.api_dni_ruc.url');

        $document_type = ($type == 'dni') ? '01' : '06';

        $user = ModelsClient::where('document_number', $number)
            ->first();

        if ($user) {
            if ($type == 'ruc') {
                return [
                    'success' => true,
                    'razon_social' => $user->name,
                    'nombre_comercial' => $user->name,
                    'direccion' => null,
                    'distrit_id' => $user->distrit_id,
                ];
            } else {
                return [
                    'success' => true,
                    'nombres' => $user->name,
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
                    ModelsClient::create([
                        'type_document' => strtoupper($type),
                        'document_number' => $number,
                        'name' => $response['nombre'],
                        'address' => $response['direccion'] ?? null,
                    ]);
                    return [
                        'success' => true,
                        'razon_social' => $response['nombre'],
                        'nombre_comercial' => $response['nombre'],
                        'address' => $response['direccion'],
                    ];
                } else {
                    ModelsClient::create([
                        'type_document' => strtoupper($type),
                        'document_number' => $number,
                        'name' => $response['nombres'] . ' ' . $response['apellidoPaterno'] . ' ' . $response['apellidoMaterno'],
                    ]);
                    return [
                        'success' => true,
                        'nombres' => $response['nombres'] . ' ' . $response['apellidoPaterno'] . ' ' . $response['apellidoMaterno'],
                        'address' => null,
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
