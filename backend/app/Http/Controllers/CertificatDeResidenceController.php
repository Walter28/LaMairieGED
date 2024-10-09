<?php

namespace App\Http\Controllers;

use App\Models\CertificatDeResidence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificatDeResidenceController extends Controller
{
    // Afficher la liste des certificats de résidence
    public function index()
    {
        $certificats = CertificatDeResidence::all();
        return response()->json($certificats);
    }

    // Afficher un certificat de résidence spécifique
    public function show($id)
    {
        $certificat = CertificatDeResidence::findOrFail($id);
        return response()->json($certificat);
    }

    // Méthode pour créer un nouveau certificat de résidence
    public function store(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_complet_du_resident' => 'required|string|max:255',
            'adresse_actuelle_de_la_residence' => 'required|string|max:255',
            'preuve_de_residence' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'carte_identite_du_resident' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'declaration_sur_l_honneur' => 'required|string|max:255',
        ]);

        // Dossier de stockage pour le certificat de résidence
        $storagePath = "demandes/certificat_de_residence/{$validated['demande_id']}";

        // Fonction pour générer un nom de fichier unique et descriptif
        function generateFileName($fieldName, $originalName)
        {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            return Str::snake($fieldName) . '_' . Str::slug($nameWithoutExtension) . '.' . $extension;
        }

        // Gérer le téléchargement de fichier pour preuve_de_residence
        if ($request->hasFile('preuve_de_residence')) {
            $fileName = generateFileName('preuve_de_residence', $request->file('preuve_de_residence')->getClientOriginalName());
            $request->file('preuve_de_residence')->storeAs("public/{$storagePath}", $fileName);
            $preuve_de_residence_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour carte_identite_du_resident
        if ($request->hasFile('carte_identite_du_resident')) {
            $fileName = generateFileName('carte_identite_du_resident', $request->file('carte_identite_du_resident')->getClientOriginalName());
            $request->file('carte_identite_du_resident')->storeAs("public/{$storagePath}", $fileName);
            $carte_identite_path = "{$storagePath}/{$fileName}";
        }

        // Création de l'enregistrement du certificat de résidence
        $certificatDeResidence = CertificatDeResidence::create([
            'demande_id' => $validated['demande_id'],
            'nom_complet_du_resident' => $validated['nom_complet_du_resident'],
            'adresse_actuelle_de_la_residence' => $validated['adresse_actuelle_de_la_residence'],
            'preuve_de_residence' => $preuve_de_residence_path,  // Chemin complet de la preuve de résidence
            'carte_identite_du_resident' => $carte_identite_path,  // Chemin complet de la carte d'identité
            'declaration_sur_l_honneur' => $validated['declaration_sur_l_honneur'],
        ]);

        return response()->json([
            'message' => 'Certificat de résidence enregistré avec succès',
            'certificat_de_residence' => $certificatDeResidence
        ], 201);
    }

    // Méthode pour mettre à jour un certificat de résidence existant
    public function update(Request $request, $id)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_complet_du_resident' => 'sometimes|string|max:255',
            'adresse_actuelle_de_la_residence' => 'sometimes|string|max:255',
            'preuve_de_residence' => 'sometimes|file|mimes:jpeg,png,pdf|max:2048',
            'carte_identite_du_resident' => 'sometimes|file|mimes:jpeg,png,pdf|max:2048',
            'declaration_sur_l_honneur' => 'sometimes|string|max:255',
        ]);

        // Récupérer le certificat de résidence existant
        $certificatDeResidence = CertificatDeResidence::findOrFail($id);

        // Dossier de stockage pour le certificat de résidence
        $storagePath = "demandes/certificat_de_residence/{$validated['demande_id']}";

        // Gérer le téléchargement de fichier pour preuve_de_residence
        if ($request->hasFile('preuve_de_residence')) {
            // Supprimer l'ancien fichier s'il existe
            if ($certificatDeResidence->preuve_de_residence) {
                Storage::delete("public/{$certificatDeResidence->preuve_de_residence}");
            }

            $fileName = generateFileName('preuve_de_residence', $request->file('preuve_de_residence')->getClientOriginalName());
            $request->file('preuve_de_residence')->storeAs("public/{$storagePath}", $fileName);
            $certificatDeResidence->preuve_de_residence = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour carte_identite_du_resident
        if ($request->hasFile('carte_identite_du_resident')) {
            // Supprimer l'ancien fichier s'il existe
            if ($certificatDeResidence->carte_identite_du_resident) {
                Storage::delete("public/{$certificatDeResidence->carte_identite_du_resident}");
            }

            $fileName = generateFileName('carte_identite_du_resident', $request->file('carte_identite_du_resident')->getClientOriginalName());
            $request->file('carte_identite_du_resident')->storeAs("public/{$storagePath}", $fileName);
            $certificatDeResidence->carte_identite_du_resident = "{$storagePath}/{$fileName}";
        }

        // Mettre à jour les autres champs
        $certificatDeResidence->update($validated);

        return response()->json([
            'message' => 'Certificat de résidence mis à jour avec succès',
            'certificat_de_residence' => $certificatDeResidence
        ], 200);
    }

    // Méthode pour supprimer un certificat de résidence
    public function destroy($id)
    {
        // Récupérer le certificat de résidence existant
        $certificatDeResidence = CertificatDeResidence::findOrFail($id);

        // Supprimer les fichiers associés
        if ($certificatDeResidence->preuve_de_residence) {
            Storage::delete("public/{$certificatDeResidence->preuve_de_residence}");
        }
        if ($certificatDeResidence->carte_identite_du_resident) {
            Storage::delete("public/{$certificatDeResidence->carte_identite_du_resident}");
        }

        // Supprimer l'enregistrement du certificat de résidence
        $certificatDeResidence->delete();

        return response()->json([
            'message' => 'Certificat de résidence supprimé avec succès'
        ], 200);
    }

    // Méthode pour récupérer les certificats de résidence par demande_id
    public function getByDemandeId($demande_id)
    {
        $certificats = CertificatDeResidence::where('demande_id', $demande_id)->get();

        if ($certificats->isEmpty()) {
            return response()->json([
                'message' => 'Aucun certificat de résidence trouvé pour cette demande.'
            ], 404);
        }

        return response()->json($certificats);
    }
}
