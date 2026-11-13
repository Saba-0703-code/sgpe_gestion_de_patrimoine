<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    public function index()
    {
        return response()->json(Affectation::all(), 200);
    }

    public function store(Request $request)
    {
        $valide = $request->validate([
            'bien_id' => 'required|exists:biens,id',
            'nom_responsable' => 'required|string',
            'service_departement' => 'required|string',
            'motif' => 'nullable|string',
            'date_affectation' => 'required|date',
            'date_retour' => 'nullable|date',
            'statut' => 'required|in:en_cours,retourne,perdu'
        ]);

        $affectation = Affectation::create($valide);
        return response()->json($affectation, 201);
    }

    public function show(string $id)
    {
        return response()->json(Affectation::findOrFail($id), 200);
    }

    public function update(Request $request, string $id)
    {
        $affectation = Affectation::findOrFail($id);
        $affectation->update($request->all());
        return response()->json($affectation, 200);
    }
}
