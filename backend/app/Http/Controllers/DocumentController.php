<?php

namespace App\Http\Controllers;

use App\Models\Document;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Document::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        // $document = Document::create([
        //     'type' => $request->type,
        //     'user_id' => Auth::id(),
        //     'status' => $request->status,
        // ]);

        $document = Document::create($request->all());
        
        return response()->json(['document' => $document], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Document::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::find($id);
        $document->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Document::destroy($id);
    }
}
