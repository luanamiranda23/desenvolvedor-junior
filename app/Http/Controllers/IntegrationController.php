<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Municipio;
use GuzzleHttp\Client;

class IntegrationController extends Controller
{
    public function listarItens()
    {
        $itens = Item::all();
        return response()->json($itens);
    }

    public function consultarMunicipiosRio()
    {
        $httpClient = new Client();
        $response = $httpClient->get('https://servicodados.ibge.gov.br/api/v1/localidades/distritos');

        $municipios = json_decode($response->getBody(), true);

        foreach ($municipios as $municipio) {
            // Verifica se o município já está cadastrado no banco de dados
            $existingMunicipio = Municipio::where('ibge_id', $municipio['id'])->first();

            if (!$existingMunicipio) {
                // Insere o município no banco de dados
                Municipio::create([
                    'ibge_id' => $municipio['id'],
                    'ibge_name' => $municipio['nome']
                ]);
            }
        }

        return response()->json(['message' => 'Municipios do Rio de Janeiro inseridos com sucesso']);
    }
}
