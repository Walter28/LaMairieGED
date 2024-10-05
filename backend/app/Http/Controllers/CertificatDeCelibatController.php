<?php

namespace App\Http\Controllers;

use App\Models\CertificatDeCelibat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificatDeCelibatController extends Controller
{
    // Afficher la liste des certificats de célibat
    public function index()
    {
        $certificats = CertificatDeCelibat::all();
        return response()->json($certificats);
    }

    // Afficher un certificat de célibat spécifique
    public function show($id)
    {
        $certificat = CertificatDeCelibat::findOrFail($id);
        return response()->json($certificat);
    }

    // Créer un nouveau certificat de célibat
    public function store(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_complet_celibataire' => 'required|string|max:255',
            'date_de_naissance' => 'required|date',
            'lieu_de_naissance' => 'required|string|max:255',
            'preuve_identite' => 'required|file|mimes:pdf|max:2048',
            'acte_de_naissance' => 'required|file|mimes:pdf|max:2048',
            'declaration_sur_honneur' => 'required|string',
        ]);

        // Dossier de stockage
        $storagePath = "demandes/certificat_de_celibat/{$validated['demande_id']}";

        // Fonction pour générer un nom de fichier unique
        function generateFileName($fieldName, $originalName)
        {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            return Str::snake($fieldName) . '_' . Str::slug($nameWithoutExtension) . '.' . $extension;
        }

        // Gérer le téléchargement de fichier pour `preuve_identite`
        if ($request->hasFile('preuve_identite')) {
            $fileName = generateFileName('preuve_identite', $request->file('preuve_identite')->getClientOriginalName());
            $request->file('preuve_identite')->storeAs("public/{$storagePath}", $fileName);
            $preuve_identite_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `acte_de_naissance`
        if ($request->hasFile('acte_de_naissance')) {
            $fileName = generateFileName('acte_de_naissance', $request->file('acte_de_naissance')->getClientOriginalName());
            $request->file('acte_de_naissance')->storeAs("public/{$storagePath}", $fileName);
            $acte_de_naissance_path = "{$storagePath}/{$fileName}";
        }

        // Création de l'enregistrement
        $certificatDeCelibat = CertificatDeCelibat::create([
            'demande_id' => $validated['demande_id'],
            'nom_complet_celibataire' => $validated['nom_complet_celibataire'],
            'date_de_naissance' => $validated['date_de_naissance'],
            'lieu_de_naissance' => $validated['lieu_de_naissance'],
            'preuve_identite' => $preuve_identite_path,
            'acte_de_naissance' => $acte_de_naissance_path,
            'declaration_sur_honneur' => $validated['declaration_sur_honneur'],
        ]);

        return response()->json([
            'message' => 'Certificat de célibat enregistré avec succès',
            'certificat_de_celibat' => $certificatDeCelibat
        ], 201);
    }

    // Méthode pour récupérer les certificats de célibat par demande_id
    public function getByDemandeId($demande_id)
    {
        $certificats = CertificatDeCelibat::where('demande_id', $demande_id)->get();

        if ($certificats->isEmpty()) {
            return response()->json([
                'message' => 'Aucun certificat trouvé pour cette demande.'
            ], 404);
        }

        return response()->json($certificats);
    }

    // Mettre à jour un certificat de célibat existant
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_complet_celibataire' => 'sometimes|string|max:255',
            'date_de_naissance' => 'sometimes|date',
            'lieu_de_naissance' => 'sometimes|string|max:255',
            'preuve_identite' => 'sometimes|file|mimes:pdf|max:2048',
            'acte_de_naissance' => 'sometimes|file|mimes:pdf|max:2048',
            'declaration_sur_honneur' => 'sometimes|string',
        ]);

        $certificatDeCelibat = CertificatDeCelibat::findOrFail($id);
        $storagePath = "demandes/certificat_de_celibat/{$validated['demande_id']}";

        // Gérer le téléchargement des fichiers
        if ($request->hasFile('preuve_identite')) {
            if ($certificatDeCelibat->preuve_identite) {
                Storage::delete("public/{$certificatDeCelibat->preuve_identite}");
            }
            $fileName = generateFileName('preuve_identite', $request->file('preuve_identite')->getClientOriginalName());
            $request->file('preuve_identite')->storeAs("public/{$storagePath}", $fileName);
            $certificatDeCelibat->preuve_identite = "{$storagePath}/{$fileName}";
        }

        if ($request->hasFile('acte_de_naissance')) {
            if ($certificatDeCelibat->acte_de_naissance) {
                Storage::delete("public/{$certificatDeCelibat->acte_de_naissance}");
            }
            $fileName = generateFileName('acte_de_naissance', $request->file('acte_de_naissance')->getClientOriginalName());
            $request->file('acte_de_naissance')->storeAs("public/{$storagePath}", $fileName);
            $certificatDeCelibat->acte_de_naissance = "{$storagePath}/{$fileName}";
        }

        $certificatDeCelibat->update($validated);

        return response()->json([
            'message' => 'Certificat de célibat mis à jour avec succès',
            'certificat_de_celibat' => $certificatDeCelibat
        ], 200);
    }

    // Supprimer un certificat de célibat
    public function destroy($id)
    {
        $certificatDeCelibat = CertificatDeCelibat::findOrFail($id);

        if ($certificatDeCelibat->preuve_identite) {
            Storage::delete("public/{$certificatDeCelibat->preuve_identite}");
        }

        if ($certificatDeCelibat->acte_de_naissance) {
            Storage::delete("public/{$certificatDeCelibat->acte_de_naissance}");
        }

        $certificatDeCelibat->delete();

        return response()->json([
            'message' => 'Certificat de célibat supprimé avec succès'
        ], 200);
    }
}
