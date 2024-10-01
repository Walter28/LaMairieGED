<?php

namespace App\Http\Controllers;

use App\Models\ActeDeMariage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActeDeMariageController extends Controller
{
    // Afficher la liste des actes de mariage
    public function index()
    {
        $actes = ActeDeMariage::all();
        return response()->json($actes);
    }

    // Afficher un acte de mariage spécifique
    public function show($id)
    {
        $acte = ActeDeMariage::findOrFail($id);
        return response()->json($acte);
    }

    // Méthode pour créer un nouvel acte de mariage
    public function store(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id|unique:acte_de_mariages,demande_id',
            'husband_full_name' => 'required|string|max:255',
            'husband_id_card' => 'required|file|mimes:pdf|max:2048',
            'husband_certificat_naiss' => 'required|file|mimes:pdf|max:2048',
            'marry_full_name' => 'required|string|max:255',
            'marry_id_card' => 'required|file|mimes:pdf|max:2048',
            'marry_certificat_naiss' => 'required|file|mimes:pdf|max:2048',
            'wedding_place' => 'required|string|max:255',
            'couple_leaving_proof' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Dossier de stockage pour l'acte de mariage
        $storagePath = "demandes/acte_de_mariage/{$validated['demande_id']}";

        // Fonction pour générer un nom de fichier unique et descriptif
        function generateFileName($fieldName, $originalName)
        {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            return Str::snake($fieldName) . '_' . Str::slug($nameWithoutExtension) . '.' . $extension;
        }

        // Gérer le téléchargement de fichier pour chaque pièce jointe
        $filePaths = [];
        $fileFields = [
            'husband_id_card',
            'husband_certificat_naiss',
            'marry_id_card',
            'marry_certificat_naiss',
            'couple_leaving_proof'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $fileName = generateFileName($field, $request->file($field)->getClientOriginalName());
                $request->file($field)->storeAs("public/{$storagePath}", $fileName);
                $filePaths[$field] = "{$storagePath}/{$fileName}";
            }
        }

        // Création de l'acte de mariage
        $acteDeMariage = ActeDeMariage::create(array_merge($validated, $filePaths));

        return response()->json([
            'message' => 'Acte de mariage enregistré avec succès',
            'acte_de_mariage' => $acteDeMariage
        ], 201);
    }

    // Méthode pour récupérer les actes de mariage par demande_id
    public function getByDemandeId($demande_id)
    {
        // Récupérer tous les actes de mariage associés à un demande_id spécifique
        $actes = ActeDeMariage::where('demande_id', $demande_id)->get();

        // Si aucun acte de mariage n'est trouvé
        if ($actes->isEmpty()) {
            return response()->json([
                'message' => 'Aucun acte de mariage trouvé pour cette demande.'
            ], 404);
        }

        return response()->json($actes);
    }


    // Méthode pour mettre à jour un acte de mariage existant
    public function update(Request $request, $id)
    {
        // Validation des champs
        $validated = $request->validate([
            'husband_full_name' => 'sometimes|string|max:255',
            'husband_id_card' => 'sometimes|file|mimes:pdf|max:2048',
            'husband_certificat_naiss' => 'sometimes|file|mimes:pdf|max:2048',
            'marry_full_name' => 'sometimes|string|max:255',
            'marry_id_card' => 'sometimes|file|mimes:pdf|max:2048',
            'marry_certificat_naiss' => 'sometimes|file|mimes:pdf|max:2048',
            'wedding_place' => 'sometimes|string|max:255',
            'couple_leaving_proof' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Récupérer l'acte de mariage existant
        $acteDeMariage = ActeDeMariage::findOrFail($id);

        // Dossier de stockage pour l'acte de mariage
        $storagePath = "demandes/acte_de_mariage/{$acteDeMariage->demande_id}";

        // Gérer les mises à jour de fichier
        $fileFields = [
            'husband_id_card',
            'husband_certificat_naiss',
            'marry_id_card',
            'marry_certificat_naiss',
            'couple_leaving_proof'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Supprimer l'ancien fichier s'il existe
                if ($acteDeMariage->{$field}) {
                    Storage::delete("public/{$acteDeMariage->{$field}}");
                }

                $fileName = generateFileName($field, $request->file($field)->getClientOriginalName());
                $request->file($field)->storeAs("public/{$storagePath}", $fileName);
                $acteDeMariage->{$field} = "{$storagePath}/{$fileName}";
            }
        }

        // Mettre à jour les autres champs
        $acteDeMariage->update($validated);

        return response()->json([
            'message' => 'Acte de mariage mis à jour avec succès',
            'acte_de_mariage' => $acteDeMariage
        ], 200);
    }

    // Méthode pour supprimer un acte de mariage
    public function destroy($id)
    {
        // Récupérer l'acte de mariage existant
        $acteDeMariage = ActeDeMariage::findOrFail($id);

        // Supprimer les fichiers associés
        $fileFields = [
            'husband_id_card',
            'husband_certificat_naiss',
            'marry_id_card',
            'marry_certificat_naiss',
            'couple_leaving_proof'
        ];

        foreach ($fileFields as $field) {
            if ($acteDeMariage->{$field}) {
                Storage::delete("public/{$acteDeMariage->{$field}}");
            }
        }

        // Supprimer l'enregistrement de l'acte de mariage
        $acteDeMariage->delete();

        return response()->json([
            'message' => 'Acte de mariage supprimé avec succès'
        ], 200);
    }
}
