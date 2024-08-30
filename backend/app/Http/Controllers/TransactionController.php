<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Transaction::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'user_id' => 'required|exists:users,id',
            'action' => 'required|string|max:255',
        ]);

        $transaction = Transaction::create($request->all());

        return response()->json(['transaction' => $transaction], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Transaction::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::find($id);
        $transaction->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Trasaction::destroy($id);
    }


    /**
     * This will search for a transaction.
     * 
     * @param str $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Transaction::where('name', 'like', '%'.$name.'%')->get();
    }
}
