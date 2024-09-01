<?php

namespace App\Http\Controllers;

use App\Models\ActeDeNaissance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActeDeNaissanceController extends Controller
{
    // Afficher la liste des actes de naissance
    public function index()
    {
        $actes = ActeDeNaissance::all();
        return response()->json($actes);
    }

    // Afficher un acte de naissance spécifique
    public function show(ActeDeNaissance $acteDeNaissance)
    {
        return response()->json($acteDeNaissance);
    }

    // Créer un nouvel acte de naissance
    public function store(Request $request)
    {
        $request->validate([
            'demande_id' => 'required|exists:demandes,id|unique:acte_de_naissances,demande_id',
            'kid_full_name' => 'required|string',
            'kid_birth_date' => 'required|date',
            'kid_birth_place' => 'required|string',
            'kid_certificat_medical' => 'nullable|string',
            'dad_full_name' => 'required|string',
            'dad_id_card' => 'required|string',
            'mum_full_name' => 'required|string',
            'mum_id_card' => 'required|string',
        ]);

        $acteDeNaissance = ActeDeNaissance::create($request->all());

        return response()->json($acteDeNaissance, Response::HTTP_CREATED);
    }

    // Mettre à jour un acte de naissance
    public function update(Request $request, ActeDeNaissance $acteDeNaissance)
    {
        $request->validate([
            'kid_full_name' => 'required|string',
            'kid_birth_date' => 'required|date',
            'kid_birth_place' => 'required|string',
            'kid_certificat_medical' => 'nullable|string',
            'dad_full_name' => 'required|string',
            'dad_id_card' => 'required|string',
            'mum_full_name' => 'required|string',
            'mum_id_card' => 'required|string',
        ]);

        $acteDeNaissance->update($request->all());

        return response()->json($acteDeNaissance);
    }

    // Supprimer un acte de naissance
    public function destroy(ActeDeNaissance $acteDeNaissance)
    {
        $acteDeNaissance->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
