<?php
namespace App\Http\Controllers\Api;

use App\Models\Bien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BienController extends Controller
{
    public function index()     { return response()->json(Bien::all()); }
    public function show($id)    { return response()->json(Bien::findOrFail($id)); }
    public function store(Request $request)   { return response()->json(Bien::create($request->all()), 201); }
    public function update(Request $request, $id) { return response()->json(Bien::findOrFail($id)->update($request->all())); }
    public function destroy($id) { return response()->json(Bien::findOrFail($id)->delete()); }
}
