<?php

namespace App\Http\Controllers;

use App\Models\PermisDeConstruire;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PermisDeConstruireController extends Controller
{
    // Afficher la liste des permis de construire
    public function index()
    {
        $permis = PermisDeConstruire::all();
        return response()->json($permis);
    }

    // Afficher un permis de construire spécifique
    public function show($id)
    {
        $permis = PermisDeConstruire::findOrFail($id);
        return response()->json($permis);
    }

    // Méthode pour créer un nouveau permis de construire
    public function store(Request $request)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_demandeur' => 'required|string|max:255',
            'adresse_site_construction' => 'required|string|max:255',
            'plans_construction' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'permis_urbanisme' => 'sometimes|file|mimes:pdf|max:2048',
            'preuve_propriete_terrain' => 'required|file|mimes:pdf|max:2048',
            'preuve_identite' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Dossier de stockage pour le permis de construire
        $storagePath = "demandes/permis_de_construire/{$validated['demande_id']}";

        // Fonction pour générer un nom de fichier unique et descriptif
        function generateFileName($fieldName, $originalName)
        {
            $nameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            return Str::snake($fieldName) . '_' . Str::slug($nameWithoutExtension) . '.' . $extension;
        }

        // Gérer le téléchargement de fichier pour plans_construction
        if ($request->hasFile('plans_construction')) {
            $fileName = generateFileName('plans_construction', $request->file('plans_construction')->getClientOriginalName());
            $request->file('plans_construction')->storeAs("public/{$storagePath}", $fileName);
            $plans_construction_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour permis_urbanisme
        if ($request->hasFile('permis_urbanisme')) {
            $fileName = generateFileName('permis_urbanisme', $request->file('permis_urbanisme')->getClientOriginalName());
            $request->file('permis_urbanisme')->storeAs("public/{$storagePath}", $fileName);
            $permis_urbanisme_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour preuve_propriete_terrain
        if ($request->hasFile('preuve_propriete_terrain')) {
            $fileName = generateFileName('preuve_propriete_terrain', $request->file('preuve_propriete_terrain')->getClientOriginalName());
            $request->file('preuve_propriete_terrain')->storeAs("public/{$storagePath}", $fileName);
            $preuve_propriete_terrain_path = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour preuve_identite
        if ($request->hasFile('preuve_identite')) {
            $fileName = generateFileName('preuve_identite', $request->file('preuve_identite')->getClientOriginalName());
            $request->file('preuve_identite')->storeAs("public/{$storagePath}", $fileName);
            $preuve_identite_path = "{$storagePath}/{$fileName}";
        }

        // Création de l'enregistrement du permis de construire
        $permisDeConstruire = PermisDeConstruire::create([
            'demande_id' => $validated['demande_id'],
            'nom_demandeur' => $validated['nom_demandeur'],
            'adresse_site_construction' => $validated['adresse_site_construction'],
            'plans_construction' => $plans_construction_path,
            'permis_urbanisme' => $permis_urbanisme_path ?? null,
            'preuve_propriete_terrain' => $preuve_propriete_terrain_path,
            'preuve_identite' => $preuve_identite_path,
        ]);

        return response()->json([
            'message' => 'Permis de construire enregistré avec succès',
            'permis_de_construire' => $permisDeConstruire
        ], 201);
    }

    // Méthode pour récupérer les permis de construire par demande_id
    public function getByDemandeId($demande_id)
    {
        // Récupérer tous les permis de construire associés à un demande_id spécifique
        $permis = PermisDeConstruire::where('demande_id', $demande_id)->get();

        // Si aucun permis de construire n'est trouvé
        if ($permis->isEmpty()) {
            return response()->json([
                'message' => 'Aucun permis de construire trouvé pour cette demande.'
            ], 404);
        }

        return response()->json($permis);
    }

    // Méthode pour mettre à jour un permis de construire existant
    public function update(Request $request, $id)
    {
        // Validation des champs
        $validated = $request->validate([
            'demande_id' => 'required|exists:demandes,id',
            'nom_demandeur' => 'sometimes|string|max:255',
            'adresse_site_construction' => 'sometimes|string|max:255',
            'plans_construction' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'permis_urbanisme' => 'sometimes|file|mimes:pdf|max:2048',
            'preuve_propriete_terrain' => 'sometimes|file|mimes:pdf|max:2048',
            'preuve_identite' => 'sometimes|file|mimes:pdf|max:2048',
        ]);

        // Récupérer le permis de construire existant
        $permisDeConstruire = PermisDeConstruire::findOrFail($id);

        // Dossier de stockage pour le permis de construire
        $storagePath = "demandes/permis_de_construire/{$validated['demande_id']}";

        // Gérer le téléchargement de fichier pour plans_construction
        if ($request->hasFile('plans_construction')) {
            // Supprimer l'ancien fichier s'il existe
            if ($permisDeConstruire->plans_construction) {
                Storage::delete("public/{$permisDeConstruire->plans_construction}");
            }

            $fileName = generateFileName('plans_construction', $request->file('plans_construction')->getClientOriginalName());
            $request->file('plans_construction')->storeAs("public/{$storagePath}", $fileName);
            $permisDeConstruire->plans_construction = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour permis_urbanisme
        if ($request->hasFile('permis_urbanisme')) {
            // Supprimer l'ancien fichier s'il existe
            if ($permisDeConstruire->permis_urbanisme) {
                Storage::delete("public/{$permisDeConstruire->permis_urbanisme}");
            }

            $fileName = generateFileName('permis_urbanisme', $request->file('permis_urbanisme')->getClientOriginalName());
            $request->file('permis_urbanisme')->storeAs("public/{$storagePath}", $fileName);
            $permisDeConstruire->permis_urbanisme = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour preuve_propriete_terrain
        if ($request->hasFile('preuve_propriete_terrain')) {
            // Supprimer l'ancien fichier s'il existe
            if ($permisDeConstruire->preuve_propriete_terrain) {
                Storage::delete("public/{$permisDeConstruire->preuve_propriete_terrain}");
            }

            $fileName = generateFileName('preuve_propriete_terrain', $request->file('preuve_propriete_terrain')->getClientOriginalName());
            $request->file('preuve_propriete_terrain')->storeAs("public/{$storagePath}", $fileName);
            $permisDeConstruire->preuve_propriete_terrain = "{$storagePath}/{$fileName}";
        }

        // Gérer le téléchargement de fichier pour preuve_identite
        if ($request->hasFile('preuve_identite')) {
            // Supprimer l'ancien fichier s'il existe
            if ($permisDeConstruire->preuve_identite) {
                Storage::delete("public/{$permisDeConstruire->preuve_identite}");
            }

            $fileName = generateFileName('preuve_identite', $request->file('preuve_identite')->getClientOriginalName());
            $request->file('preuve_identite')->storeAs("public/{$storagePath}", $fileName);
            $permisDeConstruire->preuve_identite = "{$storagePath}/{$fileName}";
        }

        // Mettre à jour les autres champs
        $permisDeConstruire->demande_id = $validated['demande_id'];
        if (isset($validated['nom_demandeur'])) {
            $permisDeConstruire->nom_demandeur = $validated['nom_demandeur'];
        }
        if (isset($validated['adresse_site_construction'])) {
            $permisDeConstruire->adresse_site_construction = $validated['adresse_site_construction'];
        }

        // Sauvegarder les modifications
        $permisDeConstruire->save();

        return response()->json([
            'message' => 'Permis de construire mis à jour avec succès',
            'permis_de_construire' => $permisDeConstruire
        ], 200);
    }

    // Méthode pour supprimer un permis de construire
    public function destroy($id)
    {
        $permisDeConstruire = PermisDeConstruire::findOrFail($id);

        // Supprimer les fichiers associés s'ils existent
        if ($permisDeConstruire->plans_construction) {
            Storage::delete("public/{$permisDeConstruire->plans_construction}");
        }
        if ($permisDeConstruire->permis_urbanisme) {
            Storage::delete("public/{$permisDeConstruire->permis_urbanisme}");
        }
        if ($permisDeConstruire->preuve_propriete_terrain) {
            Storage::delete("public/{$permisDeConstruire->preuve_propriete_terrain}");
        }
        if ($permisDeConstruire->preuve_identite) {
            Storage::delete("public/{$permisDeConstruire->preuve_identite}");
        }

        // Supprimer l'enregistrement
        $permisDeConstruire->delete();

        return response()->json([
            'message' => 'Permis de construire supprimé avec succès'
        ], 200);
    }
}
