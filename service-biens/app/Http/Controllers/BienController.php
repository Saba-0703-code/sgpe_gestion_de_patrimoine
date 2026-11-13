<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use Illuminate\Http\Request;

class BienController extends Controller
{
    public function index()
    {
        return response()->json(Bien::all(), 200);
    }

    public function store(Request $request)
    {
        $valide = $request->validate([
            'reference' => 'required|string|unique:biens',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categorie' => 'required|string',
            'etat' => 'required|string',
            'valeur' => 'required|numeric|min:0',
            'date_acquisition' => 'required|date',
            'localisation' => 'required|string',
            'photo' => 'nullable|string'
        ]);

        $bien = Bien::create($valide);
        return response()->json($bien, 201);
    }

    public function show(string $id)
    {
        $bien = Bien::findOrFail($id);
        return response()->json($bien, 200);
    }

    public function update(Request $request, string $id)
    {
        $bien = Bien::findOrFail($id);
        $bien->update($request->all());
        return response()->json($bien, 200);
    }

    public function destroy(string $id)
    {
        Bien::findOrFail($id)->delete();
        return response()->json(['message' => 'Bien supprimé'], 200);
    }
}
