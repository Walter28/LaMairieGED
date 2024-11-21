<?php

namespace App\Http\Controllers;

use App\Models\TypeDocument;
use Illuminate\Http\Request;

class TypeDocumentController extends Controller
{
    /**
     * Afficher tous les types de documents.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typeDocuments = TypeDocument::all();
        return response()->json($typeDocuments);
    }

    /**
     * Afficher un type de document par ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $typeDocument = TypeDocument::find($id);

        if ($typeDocument) {
            return response()->json($typeDocument);
        } else {
            return response()->json(['message' => 'Type de document non trouvé.'], 404);
        }
    }

    /**
     * Créer un nouveau type de document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $typeDocument = TypeDocument::create($request->all());

        return response()->json($typeDocument, 201);
    }

    /**
     * Mettre à jour un type de document existant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $typeDocument = TypeDocument::find($id);

        if ($typeDocument) {
            $typeDocument->update($request->all());
            return response()->json($typeDocument);
        } else {
            return response()->json(['message' => 'Type de document non trouvé.'], 404);
        }
    }

    /**
     * Supprimer un type de document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $typeDocument = TypeDocument::find($id);

        if ($typeDocument) {
            $typeDocument->delete();
            return response()->json(['message' => 'Type de document supprimé avec succès.']);
        } else {
            return response()->json(['message' => 'Type de document non trouvé.'], 404);
        }
    }
}
