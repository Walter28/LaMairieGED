<?php

namespace App\Http\Controllers;

use App\Models\ActeDeNaissance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActeDeNaissanceController extends Controller
{
    // Afficher la liste des actes de naissance
    public function index()
    {
        $actes = ActeDeNaissance::all();
        return response()->json($actes);
    }

    // 2. Afficher un acte de naissance spécifique
    public function show($id)
    {
        $acte = ActeDeNaissance::findOrFail($id);
        return response()->json($acte);
    }

    // Méthode pour créer un nouvel acte de naissance
    public function store(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'kid_full_name' => 'required|string|max:255',
            'kid_birth_date' => 'required|date',
            'kid_birth_place' => 'required|string|max:255',
            'kid_certificat_medical' => 'required|file|mimes:pdf|max:2048',
            'dad_full_name' => 'required|string|max:255',
            'dad_id_card' => 'required|file|mimes:pdf|max:2048',
            'mum_full_name' => 'required|string|max:255',
            'mum_id_card' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Dossier de stockage pour l'acte de naissance
        $storagePath = "demandes/acte_de_naissance/{$validated['demande_id']}";

        // Fonction pour générer un nom de fichier unique et descriptif
        function generateFileName($fieldName, $originalName)
        {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            return Str::snake($fieldName) . '_' . Str::slug($nameWithoutExtension) . '.' . $extension;
        }

        // Gérer le téléchargement de fichier pour `kid_certificat_medical`
        if ($request->hasFile('kid_certificat_medical')) {
            $fileName = generateFileName('kid_certificat_medical', $request->file('kid_certificat_medical')->getClientOriginalName());
            $request->file('kid_certificat_medical')->storeAs("public/{$storagePath}", $fileName);
            $kid_certificat_medical_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `dad_id_card`
        if ($request->hasFile('dad_id_card')) {
            $fileName = generateFileName('dad_id_card', $request->file('dad_id_card')->getClientOriginalName());
            $request->file('dad_id_card')->storeAs("public/{$storagePath}", $fileName);
            $dad_id_card_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `mum_id_card`
        if ($request->hasFile('mum_id_card')) {
            $fileName = generateFileName('mum_id_card', $request->file('mum_id_card')->getClientOriginalName());
            $request->file('mum_id_card')->storeAs("public/{$storagePath}", $fileName);
            $mum_id_card_path = "{$storagePath}/{$fileName}";
        }

        // Création de l'enregistrement de l'acte de naissance
        $acteDeNaissance = ActeDeNaissance::create([
            'demande_id' => $validated['demande_id'],
            'kid_full_name' => $validated['kid_full_name'],
            'kid_birth_date' => $validated['kid_birth_date'],
            'kid_birth_place' => $validated['kid_birth_place'],
            'kid_certificat_medical' => $kid_certificat_medical_path,  // Chemin complet du certificat médical de l'enfant
            'dad_full_name' => $validated['dad_full_name'],
            'dad_id_card' => $dad_id_card_path,  // Chemin complet de la carte d'identité du père
            'mum_full_name' => $validated['mum_full_name'],
            'mum_id_card' => $mum_id_card_path,  // Chemin complet de la carte d'identité de la mère
        ]);

        return response()->json([
            'message' => 'Acte de naissance enregistré avec succès',
            'acte_de_naissance' => $acteDeNaissance
        ], 201);
    }

    // Méthode pour mettre à jour un acte de naissance existant
    public function update(Request $request, $id)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'kid_full_name' => 'sometimes|string|max:255',
            'kid_birth_date' => 'sometimes|date',
            'kid_birth_place' => 'sometimes|string|max:255',
            'kid_certificat_medical' => 'sometimes|file|mimes:pdf|max:2048',
            'dad_full_name' => 'sometimes|string|max:255',
            'dad_id_card' => 'sometimes|file|mimes:pdf|max:2048',
            'mum_full_name' => 'sometimes|string|max:255',
            'mum_id_card' => 'sometimes|file|mimes:pdf|max:2048',
        ]);

        // Récupérer l'acte de naissance existant
        $acteDeNaissance = ActeDeNaissance::findOrFail($id);

        // Dossier de stockage pour l'acte de naissance
        $storagePath = "demandes/acte_de_naissance/{$validated['demande_id']}";

        // Gérer le téléchargement de fichier pour `kid_certificat_medical`
        if ($request->hasFile('kid_certificat_medical')) {
            // Supprimer l'ancien fichier s'il existe
            if ($acteDeNaissance->kid_certificat_medical) {
                Storage::delete("public/{$acteDeNaissance->kid_certificat_medical}");
            }

            $fileName = generateFileName('kid_certificat_medical', $request->file('kid_certificat_medical')->getClientOriginalName());
            $request->file('kid_certificat_medical')->storeAs("public/{$storagePath}", $fileName);
            $acteDeNaissance->kid_certificat_medical = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `dad_id_card`
        if ($request->hasFile('dad_id_card')) {
            // Supprimer l'ancien fichier s'il existe
            if ($acteDeNaissance->dad_id_card) {
                Storage::delete("public/{$acteDeNaissance->dad_id_card}");
            }

            $fileName = generateFileName('dad_id_card', $request->file('dad_id_card')->getClientOriginalName());
            $request->file('dad_id_card')->storeAs("public/{$storagePath}", $fileName);
            $acteDeNaissance->dad_id_card = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `mum_id_card`
        if ($request->hasFile('mum_id_card')) {
            // Supprimer l'ancien fichier s'il existe
            if ($acteDeNaissance->mum_id_card) {
                Storage::delete("public/{$acteDeNaissance->mum_id_card}");
            }

            $fileName = generateFileName('mum_id_card', $request->file('mum_id_card')->getClientOriginalName());
            $request->file('mum_id_card')->storeAs("public/{$storagePath}", $fileName);
            $acteDeNaissance->mum_id_card = "{$storagePath}/{$fileName}";
        }

        // Mettre à jour les autres champs
        $acteDeNaissance->update($validated);

        return response()->json([
            'message' => 'Acte de naissance mis à jour avec succès',
            'acte_de_naissance' => $acteDeNaissance
        ], 200);
    }

    // Méthode pour supprimer un acte de naissance
    public function destroy($id)
    {
        // Récupérer l'acte de naissance existant
        $acteDeNaissance = ActeDeNaissance::findOrFail($id);

        // Supprimer les fichiers associés
        if ($acteDeNaissance->kid_certificat_medical) {
            Storage::delete("public/{$acteDeNaissance->kid_certificat_medical}");
        }
        if ($acteDeNaissance->dad_id_card) {
            Storage::delete("public/{$acteDeNaissance->dad_id_card}");
        }
        if ($acteDeNaissance->mum_id_card) {
            Storage::delete("public/{$acteDeNaissance->mum_id_card}");
        }

        // Supprimer l'enregistrement de l'acte de naissance
        $acteDeNaissance->delete();

        return response()->json([
            'message' => 'Acte de naissance supprimé avec succès'
        ], 200);
    }

    // Supprimer un acte de naissance
    // public function destroy(ActeDeNaissance $acteDeNaissance)
    // {
    //     $acteDeNaissance->delete();
    //     return response()->json(null, Response::HTTP_NO_CONTENT);
    // }
}
