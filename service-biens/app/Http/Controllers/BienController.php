<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BienController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Bien::query();
            
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('designation', 'LIKE', "%{$search}%")
                      ->orWhere('numero_serie', 'LIKE', "%{$search}%");
            }
            
            if ($request->has('categorie')) {
                $query->where('categorie', $request->input('categorie'));
            }
            
            if ($request->has('etat')) {
                $query->where('etat', $request->input('etat'));
            }
            
            $biens = $query->latest()->paginate($request->input('per_page', 10));
            return response()->json($biens, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des biens',
                'error' => config('app.debug') ? $e->getMessage() : 'Erreur serveur'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'designation' => 'required|string|max:255',
                'description' => 'nullable|string',
                'categorie' => 'required|string|max:255',
                'marque' => 'nullable|string|max:255',
                'modele' => 'nullable|string|max:255',
                'numero_serie' => 'nullable|string|max:255|unique:biens',
                'date_achat' => 'nullable|date',
                'valeur' => 'nullable|numeric|min:0',
                'etat' => 'required|in:Neuf,Bon,Moyen,Dégradé,Hors service',
                'emplacement' => 'nullable|string|max:255',
                'responsable' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
            ]);

            $bien = Bien::create($validated);
            return response()->json([
                'message' => 'Bien créé avec succès',
                'data' => $bien
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function show(string $id)
    {
        try {
            $bien = Bien::findOrFail($id);
            return response()->json($bien, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $bien = Bien::findOrFail($id);
            
            $validated = $request->validate([
                'designation' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'categorie' => 'sometimes|required|string|max:255',
                'marque' => 'nullable|string|max:255',
                'modele' => 'nullable|string|max:255',
                'numero_serie' => 'nullable|string|max:255|unique:biens,numero_serie,'.$id,
                'date_achat' => 'nullable|date',
                'valeur' => 'nullable|numeric|min:0',
                'etat' => 'sometimes|required|in:Neuf,Bon,Moyen,Dégradé,Hors service',
                'emplacement' => 'nullable|string|max:255',
                'responsable' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
            ]);

            $bien->update($validated);
            return response()->json([
                'message' => 'Bien mis à jour avec succès',
                'data' => $bien
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $bien = Bien::findOrFail($id);
            $bien->delete();
            return response()->json(['message' => 'Bien supprimé avec succès'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }
    }
}
