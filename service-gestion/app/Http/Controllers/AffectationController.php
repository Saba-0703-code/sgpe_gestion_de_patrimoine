<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AffectationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Affectation::query();
            
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('nom_bien', 'LIKE', "%{$search}%")
                      ->orWhere('service_destinataire', 'LIKE', "%{$search}%");
            }
            
            if ($request->has('etat')) {
                $query->where('etat', $request->input('etat'));
            }
            
            $affectations = $query->latest()->paginate($request->input('per_page', 10));
            return response()->json($affectations, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des affectations',
                'error' => config('app.debug') ? $e->getMessage() : 'Erreur serveur'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'bien_id' => 'nullable|integer|min:1',
                'nom_bien' => 'required|string|max:255',
                'service_destinataire' => 'required|string|max:255',
                'responsable' => 'required|string|max:255',
                'date_affectation' => 'required|date',
                'date_fin' => 'nullable|date|after:date_affectation',
                'motif' => 'nullable|string|max:500',
                'etat' => 'required|in:En cours,Terminée,Annulée',
            ]);

            $affectation = Affectation::create($validated);
            return response()->json([
                'message' => 'Affectation enregistrée avec succès',
                'data' => $affectation
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
            $affectation = Affectation::findOrFail($id);
            return response()->json($affectation, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Affectation non trouvée'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $affectation = Affectation::findOrFail($id);
            
            $validated = $request->validate([
                'bien_id' => 'nullable|integer|min:1',
                'nom_bien' => 'sometimes|required|string|max:255',
                'service_destinataire' => 'sometimes|required|string|max:255',
                'responsable' => 'sometimes|required|string|max:255',
                'date_affectation' => 'sometimes|required|date',
                'date_fin' => 'nullable|date|after:date_affectation',
                'motif' => 'nullable|string|max:500',
                'etat' => 'sometimes|required|in:En cours,Terminée,Annulée',
            ]);

            $affectation->update($validated);
            return response()->json([
                'message' => 'Affectation mise à jour avec succès',
                'data' => $affectation
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Affectation non trouvée'], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $affectation = Affectation::findOrFail($id);
            $affectation->delete();
            return response()->json(['message' => 'Affectation supprimée avec succès'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Affectation non trouvée'], 404);
        }
    }
}
