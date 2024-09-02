<?php

namespace App\Http\Controllers;

use App\Models\ActeDeMariage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActeDeMariageController extends Controller
{
    // Afficher la liste des actes de mariage
    public function index()
    {
        $actes = ActeDeMariage::all();
        return response()->json($actes);
    }

    // Afficher un acte de mariage spécifique
    public function show(ActeDeMariage $acteDeMariage)
    {
        return response()->json($acteDeMariage);
    }

    // Créer un nouvel acte de mariage
    public function store(Request $request)
    {
        $request->validate([
            'demande_id' => 'required|exists:demandes,id|unique:acte_de_mariages,demande_id',
            'husband_full_name' => 'required|string',
            'husband_id_card' => 'required|string',
            'husband_certificat_naiss' => 'nullable|string',
            'marry_full_name' => 'required|string',
            'marry_id_card' => 'required|string',
            'marry_certificat_naiss' => 'nullable|string',
            'wedding_place' => 'required|string',
            'couple_leaving_proof' => 'nullable|string',
        ]);

        $acteDeMariage = ActeDeMariage::create($request->all());

        return response()->json($acteDeMariage, Response::HTTP_CREATED);
    }

    // Mettre à jour un acte de mariage
    public function update(Request $request, ActeDeMariage $acteDeMariage)
    {
        $request->validate([
            'husband_full_name' => 'required|string',
            'husband_id_card' => 'required|string',
            'husband_certificat_naiss' => 'nullable|string',
            'marry_full_name' => 'required|string',
            'marry_id_card' => 'required|string',
            'marry_certificat_naiss' => 'nullable|string',
            'wedding_place' => 'required|string',
            'couple_leaving_proof' => 'nullable|string',
        ]);

        $acteDeMariage->update($request->all());

        return response()->json($acteDeMariage);
    }

    // Supprimer un acte de mariage
    public function destroy(ActeDeMariage $acteDeMariage)
    {
        $acteDeMariage->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
