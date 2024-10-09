<?php

namespace App\Http\Controllers;

use App\Models\CertificatDeDece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificatDeDeceController extends Controller
{
    // Afficher la liste des certificats de décès
    public function index()
    {
        $certificats = CertificatDeDece::all();
        return response()->json($certificats);
    }

    // Afficher un certificat de décès spécifique
    public function show($id)
    {
        $certificat = CertificatDeDece::findOrFail($id);
        return response()->json($certificat);
    }

    // Méthode pour créer un nouveau certificat de décès
    public function store(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_complet_defunt' => 'required|string|max:255',
            'date_de_deces' => 'required|date',
            'lieu_de_deces' => 'required|string|max:255',
            'certificat_medical_deces' => 'required|file|mimes:pdf|max:2048',
            'preuve_identite_defunt' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Dossier de stockage pour le certificat de décès
        $storagePath = "demandes/certificat_de_deces/{$validated['demande_id']}";

        // Fonction pour générer un nom de fichier unique et descriptif
        function generateFileName($fieldName, $originalName)
        {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            return Str::snake($fieldName) . '_' . Str::slug($nameWithoutExtension) . '.' . $extension;
        }

        // Gérer le téléchargement de fichier pour certificat_medical
        if ($request->hasFile('certificat_medical_deces')) {
            $fileName = generateFileName('certificat_medical_deces', $request->file('certificat_medical_deces')->getClientOriginalName());
            $request->file('certificat_medical_deces')->storeAs("public/{$storagePath}", $fileName);
            $certificat_medical_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour preuve_identite_defunt
        if ($request->hasFile('preuve_identite_defunt')) {
            $fileName = generateFileName('preuve_identite_defunt', $request->file('preuve_identite_defunt')->getClientOriginalName());
            $request->file('preuve_identite_defunt')->storeAs("public/{$storagePath}", $fileName);
            $preuve_identite_path = "{$storagePath}/{$fileName}";
        }

        // Création de l'enregistrement du certificat de décès
        $certificatDeDece = CertificatDeDece::create([
            'demande_id' => $validated['demande_id'],
            'nom_complet_defunt' => $validated['nom_complet_defunt'],
            'date_de_deces' => $validated['date_de_deces'],
            'lieu_de_deces' => $validated['lieu_de_deces'],
            'certificat_medical_deces' => $certificat_medical_path,
            'preuve_identite_defunt' => $preuve_identite_path,
        ]);

        return response()->json([
            'message' => 'Certificat de décès enregistré avec succès',
            'certificat_de_dece' => $certificatDeDece
        ], 201);
    }

    // Méthode pour mettre à jour un certificat de décès existant
    public function update(Request $request, $id)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_complet_defunt' => 'sometimes|string|max:255',
            'date_de_deces' => 'sometimes|date',
            'lieu_de_deces' => 'sometimes|string|max:255',
            'certificat_medical_deces' => 'sometimes|file|mimes:pdf|max:2048',
            'preuve_identite_defunt' => 'sometimes|file|mimes:pdf|max:2048',
        ]);

        // Récupérer le certificat de décès existant
        $certificatDeDece = CertificatDeDece::findOrFail($id);

        // Dossier de stockage pour le certificat de décès
        $storagePath = "demandes/certificat_de_deces/{$validated['demande_id']}";

        // Gérer le téléchargement de fichier pour certificat_medical_deces
        if ($request->hasFile('certificat_medical_deces')) {
            if ($certificatDeDece->certificat_medical_deces) {
                Storage::delete("public/{$certificatDeDece->certificat_medical_deces}");
            }

            $fileName = generateFileName('certificat_medical_deces', $request->file('certificat_medical_deces')->getClientOriginalName());
            $request->file('certificat_medical_deces')->storeAs("public/{$storagePath}", $fileName);
            $certificatDeDece->certificat_medical_deces = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour preuve_identite_defunt
        if ($request->hasFile('preuve_identite_defunt')) {
            if ($certificatDeDece->preuve_identite_defunt) {
                Storage::delete("public/{$certificatDeDece->preuve_identite_defunt}");
            }

            $fileName = generateFileName('preuve_identite_defunt', $request->file('preuve_identite_defunt')->getClientOriginalName());
            $request->file('preuve_identite_defunt')->storeAs("public/{$storagePath}", $fileName);
            $certificatDeDece->preuve_identite_defunt = "{$storagePath}/{$fileName}";
        }

        // Mettre à jour les autres champs
        $certificatDeDece->update($validated);

        return response()->json([
            'message' => 'Certificat de décès mis à jour avec succès',
            'certificat_de_dece' => $certificatDeDece
        ], 200);
    }

    // Méthode pour supprimer un certificat de décès
    public function destroy($id)
    {
        // Récupérer le certificat de décès existant
        $certificatDeDece = CertificatDeDece::findOrFail($id);

        // Supprimer les fichiers associés
        if ($certificatDeDece->certificat_medical_deces) {
            Storage::delete("public/{$certificatDeDece->certificat_medical_deces}");
        }
        if ($certificatDeDece->preuve_identite_defunt) {
            Storage::delete("public/{$certificatDeDece->preuve_identite_defunt}");
        }

        // Supprimer l'enregistrement du certificat de décès
        $certificatDeDece->delete();

        return response()->json([
            'message' => 'Certificat de décès supprimé avec succès'
        ], 200);
    }

    // Méthode pour récupérer les certificats de décès par demande_id
    public function getByDemandeId($demande_id)
    {
        $certificats = CertificatDeDece::where('demande_id', $demande_id)->get();
        return response()->json($certificats);
    }
}
