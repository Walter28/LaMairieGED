<?php

namespace App\Http\Controllers;

use App\Models\CarteIdentiteNationale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarteIdentiteNationaleController extends Controller
{
    // Afficher la liste des cartes d'identité nationale
    public function index()
    {
        $cartes = CarteIdentiteNationale::all();
        return response()->json($cartes);
    }

    // Afficher une carte d'identité nationale spécifique
    public function show($id)
    {
        $carte = CarteIdentiteNationale::findOrFail($id);
        return response()->json($carte);
    }

    // Méthode pour créer une nouvelle carte d'identité nationale
    public function store(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_complet_citoyen' => 'required|string|max:255',
            'date_de_naissance' => 'required|date',
            'lieu_de_naissance' => 'required|string|max:255',
            'adresse_actuelle' => 'required|string|max:255',
            'photo_identite' => 'required|file|mimes:jpg,png,jpeg|max:2048',
            'preuve_identite' => 'required|file|mimes:pdf|max:2048',
            'empreintes_digitales' => 'sometimes|file|mimes:pdf|max:2048',
        ]);

        // Dossier de stockage pour la carte d'identité
        $storagePath = "demandes/carte_identite_nationale/{$validated['demande_id']}";

        // Fonction pour générer un nom de fichier unique et descriptif
        function generateFileName($fieldName, $originalName)
        {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            return Str::snake($fieldName) . '_' . Str::slug($nameWithoutExtension) . '.' . $extension;
        }

        // Gérer le téléchargement de fichier pour `photo_identite`
        if ($request->hasFile('photo_identite')) {
            $fileName = generateFileName('photo_identite', $request->file('photo_identite')->getClientOriginalName());
            $request->file('photo_identite')->storeAs("public/{$storagePath}", $fileName);
            $photo_identite_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `preuve_identite`
        if ($request->hasFile('preuve_identite')) {
            $fileName = generateFileName('preuve_identite', $request->file('preuve_identite')->getClientOriginalName());
            $request->file('preuve_identite')->storeAs("public/{$storagePath}", $fileName);
            $preuve_identite_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `empreintes_digitales` (si applicable)
        if ($request->hasFile('empreintes_digitales')) {
            $fileName = generateFileName('empreintes_digitales', $request->file('empreintes_digitales')->getClientOriginalName());
            $request->file('empreintes_digitales')->storeAs("public/{$storagePath}", $fileName);
            $empreintes_digitales_path = "{$storagePath}/{$fileName}";
        }

        // Création de l'enregistrement de la carte d'identité nationale
        $carteIdentiteNationale = CarteIdentiteNationale::create([
            'demande_id' => $validated['demande_id'],
            'nom_complet_citoyen' => $validated['nom_complet_citoyen'],
            'date_de_naissance' => $validated['date_de_naissance'],
            'lieu_de_naissance' => $validated['lieu_de_naissance'],
            'adresse_actuelle' => $validated['adresse_actuelle'],
            'photo_identite' => $photo_identite_path,  // Chemin complet de la photo d'identité
            'preuve_identite' => $preuve_identite_path,  // Chemin complet de la preuve d'identité
            'empreintes_digitales' => $empreintes_digitales_path ?? null, // Chemin complet des empreintes digitales
        ]);

        return response()->json([
            'message' => 'Carte d\'identité nationale enregistrée avec succès',
            'carte_identite_nationale' => $carteIdentiteNationale
        ], 201);
    }

    // Méthode pour récupérer les cartes d'identité nationale par demande_id
    public function getByDemandeId($demande_id)
    {
        // Récupérer toutes les cartes d'identité nationales associées à un demande_id spécifique
        $cartes = CarteIdentiteNationale::where('demande_id', $demande_id)->get();

        // Si aucune carte d'identité nationale n'est trouvée
        if ($cartes->isEmpty()) {
            return response()->json([
                'message' => 'Aucune carte d\'identité nationale trouvée pour cette demande.'
            ], 404);
        }

        return response()->json($cartes);
    }

    // Méthode pour mettre à jour une carte d'identité nationale existante
    public function update(Request $request, $id)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_complet_citoyen' => 'sometimes|string|max:255',
            'date_de_naissance' => 'sometimes|date',
            'lieu_de_naissance' => 'sometimes|string|max:255',
            'adresse_actuelle' => 'sometimes|string|max:255',
            'photo_identite' => 'sometimes|file|mimes:jpg,png,jpeg|max:2048',
            'preuve_identite' => 'sometimes|file|mimes:pdf|max:2048',
            'empreintes_digitales' => 'sometimes|file|mimes:pdf|max:2048',
        ]);

        // Récupérer la carte d'identité nationale existante
        $carteIdentiteNationale = CarteIdentiteNationale::findOrFail($id);

        // Dossier de stockage pour la carte d'identité
        $storagePath = "demandes/carte_identite_nationale/{$validated['demande_id']}";

        // Gérer le téléchargement de fichier pour `photo_identite`
        if ($request->hasFile('photo_identite')) {
            // Supprimer l'ancien fichier s'il existe
            if ($carteIdentiteNationale->photo_identite) {
                Storage::delete("public/{$carteIdentiteNationale->photo_identite}");
            }

            $fileName = generateFileName('photo_identite', $request->file('photo_identite')->getClientOriginalName());
            $request->file('photo_identite')->storeAs("public/{$storagePath}", $fileName);
            $carteIdentiteNationale->photo_identite = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `preuve_identite`
        if ($request->hasFile('preuve_identite')) {
            // Supprimer l'ancien fichier s'il existe
            if ($carteIdentiteNationale->preuve_identite) {
                Storage::delete("public/{$carteIdentiteNationale->preuve_identite}");
            }

            $fileName = generateFileName('preuve_identite', $request->file('preuve_identite')->getClientOriginalName());
            $request->file('preuve_identite')->storeAs("public/{$storagePath}", $fileName);
            $carteIdentiteNationale->preuve_identite = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour `empreintes_digitales`
        if ($request->hasFile('empreintes_digitales')) {
            // Supprimer l'ancien fichier s'il existe
            if ($carteIdentiteNationale->empreintes_digitales) {
                Storage::delete("public/{$carteIdentiteNationale->empreintes_digitales}");
            }

            $fileName = generateFileName('empreintes_digitales', $request->file('empreintes_digitales')->getClientOriginalName());
            $request->file('empreintes_digitales')->storeAs("public/{$storagePath}", $fileName);
            $carteIdentiteNationale->empreintes_digitales = "{$storagePath}/{$fileName}";
        }

        // Mettre à jour les autres champs
        $carteIdentiteNationale->update($validated);

        return response()->json([
            'message' => 'Carte d\'identité nationale mise à jour avec succès',
            'carte_identite_nationale' => $carteIdentiteNationale
        ], 200);
    }

    // Méthode pour supprimer une carte d'identité nationale
    public function destroy($id)
    {
        // Récupérer la carte d'identité nationale existante
        $carteIdentiteNationale = CarteIdentiteNationale::findOrFail($id);

        // Supprimer les fichiers associés
        if ($carteIdentiteNationale->photo_identite) {
            Storage::delete("public/{$carteIdentiteNationale->photo_identite}");
        }
        if ($carteIdentiteNationale->preuve_identite) {
            Storage::delete("public/{$carteIdentiteNationale->preuve_identite}");
        }
        if ($carteIdentiteNationale->empreintes_digitales) {
            Storage::delete("public/{$carteIdentiteNationale->empreintes_digitales}");
        }

        // Supprimer la carte d'identité nationale
        $carteIdentiteNationale->delete();

        return response()->json([
            'message' => 'Carte d\'identité nationale supprimée avec succès'
        ], 204);
    }
}
