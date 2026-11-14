<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Client\Factory as Http;
use App\Http\Controllers\Controller;

class BiensController extends Controller
{
    protected $http;
    protected $serviceBiensUrl;

    public function __construct(Http $http)
    {
        $this->http = $http;
        $this->serviceBiensUrl = env('APP_URL_BIENS', 'http://service-biens:9000');
    }

    // Récupérer la liste des biens depuis le service Biens
    public function index()
    {
        try {
            $response = $this->http->get("{$this->serviceBiensUrl}/api/biens");
            
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de connexion au service Biens : ' . $e->getMessage()
            ], 503);
        }
    }

    // Vérifier si un bien existe avant de l'affecter
    public function show($id)
    {
        try {
            $response = $this->http->get("{$this->serviceBiensUrl}/api/biens/{$id}");
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bien introuvable'], 404);
        }
    }
}
