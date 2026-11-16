<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UtilisateurController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Utilisateur::query();
            
            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where('nom', 'LIKE', "%{$search}%")
                      ->orWhere('prenom', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%");
            }
            
            if ($request->has('role')) {
                $query->where('role', $request->input('role'));
            }
            
            if ($request->has('statut')) {
                $query->where('statut', $request->input('statut'));
            }
            
            $utilisateurs = $query->latest()->paginate($request->input('per_page', 10));
            return response()->json($utilisateurs, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des utilisateurs',
                'error' => config('app.debug') ? $e->getMessage() : 'Erreur serveur'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:utilisateurs',
                'mot_de_passe' => 'required|string|min:8',
                'telephone' => 'nullable|string|max:20',
                'role' => 'required|in:admin,gestionnaire,utilisateur',
                'statut' => 'required|in:Actif,Inactif',
            ]);

            $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
            $utilisateur = Utilisateur::create($validated);
            
            return response()->json([
                'message' => 'Utilisateur créé avec succès',
                'data' => $utilisateur
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'mot_de_passe' => 'required|string',
            ]);

            $utilisateur = Utilisateur::where('email', $validated['email'])->first();
            
            if (!$utilisateur || !Hash::check($validated['mot_de_passe'], $utilisateur->mot_de_passe)) {
                return response()->json([
                    'message' => 'Identifiants incorrects'
                ], 401);
            }

            if ($utilisateur->statut !== 'Actif') {
                return response()->json([
                    'message' => 'Compte inactif'
                ], 403);
            }

            $token = $utilisateur->createToken('sgpe-token')->plainTextToken;
            
            return response()->json([
                'message' => 'Connexion réussie',
                'utilisateur' => [
                    'id' => $utilisateur->id,
                    'nom' => $utilisateur->nom,
                    'prenom' => $utilisateur->prenom,
                    'email' => $utilisateur->email,
                    'role' => $utilisateur->role
                ],
                'token' => $token
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function me(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }

    public function show(string $id)
    {
        try {
            $utilisateur = Utilisateur::findOrFail($id);
            return response()->json($utilisateur, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $utilisateur = Utilisateur::findOrFail($id);

            // Admin : tout modifier — Utilisateur : uniquement son propre profil
            $auteur = $request->user();
            if ($auteur->role !== 'admin' && $auteur->id !== $utilisateur->id) {
                return response()->json(['message' => 'Accès refusé'], 403);
            }

            $validated = $request->validate([
                'nom' => 'sometimes|required|string|max:255',
                'prenom' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|string|email|max:255|unique:utilisateurs,email,'.$id,
                'mot_de_passe' => 'nullable|string|min:8',
                'telephone' => 'nullable|string|max:20',
                'role' => 'sometimes|required|in:admin,gestionnaire,utilisateur',
                'statut' => 'sometimes|required|in:Actif,Inactif',
            ]);

            // Changement de mot de passe par l'utilisateur lui-même : vérifier l'ancien
            if (!empty($validated['mot_de_passe'])
                && $auteur->role !== 'admin'
                && $auteur->id === $utilisateur->id
                && (empty($request->mot_de_passe_actuel)
                    || !Hash::check($request->mot_de_passe_actuel, $utilisateur->mot_de_passe))) {
                return response()->json([
                    'message' => 'Mot de passe actuel incorrect',
                    'errors' => ['mot_de_passe_actuel' => ['Le mot de passe actuel est incorrect']]
                ], 422);
            }

            if (!empty($validated['mot_de_passe'])) {
                $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
            } else {
                unset($validated['mot_de_passe']);
            }

            $utilisateur->update($validated);
            
            return response()->json([
                'message' => 'Utilisateur mis à jour avec succès',
                'data' => $utilisateur
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $utilisateur = Utilisateur::findOrFail($id);
            $utilisateur->delete();
            return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
    }
}
