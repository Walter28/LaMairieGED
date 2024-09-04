<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\TypeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class DemandeController extends Controller
{
    // Afficher la liste des demandes
    public function index()
    {
        $demandes = Demande::all();
        return response()->json($demandes);
    }

    // Afficher les détails d'une demande
    public function show(Demande $demande)
    {
        return response()->json($demande);
    }

    // Créer une nouvelle demande
    public function store(Request $request)
    {

        $request->validate([
            'type_document_id' => 'required|exists:type_documents,id',
            'status' => 'required|string',
            'submitting_date' => 'nullable|date',
            'traitement_date' => 'nullable|date',
        ]);

        $demande = Demande::create([
            'user_id' => Auth::id(),
            'type_document_id' => $request->type_document_id,
            'status' => $request->status,
            'submitting_date' => $request->submitting_date,
            'traitement_date' => $request->traitement_date,
        ]);

        return response()->json($demande, Response::HTTP_CREATED);
    }

    // Mettre à jour une demande
    public function update(Request $request, Demande $demande)
    {
        $request->validate([
            'type_document_id' => 'required|exists:type_documents,id',
            'status' => 'required|string',
            'submitting_date' => 'nullable|date',
            'traitement_date' => 'nullable|date',
        ]);

        $demande->update([
            'type_document_id' => $request->type_document_id,
            'status' => $request->status,
            'submitting_date' => $request->submitting_date,
            'traitement_date' => $request->traitement_date,
        ]);

        return response()->json($demande);
    }

    // Supprimer une demande
    public function destroy(Demande $demande)
    {
        $demande->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
