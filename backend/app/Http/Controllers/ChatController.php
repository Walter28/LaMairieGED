<?php

// app/Http/Controllers/ChatController.php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    // Afficher la liste des messages (optionnel : filtrer par utilisateur)
    public function index(Request $request)
    {
        $chats = Chat::query();

        // Filtrer par user_from_id ou user_to_id si fourni
        if ($request->has('user_from_id')) {
            $chats->where('user_from_id', $request->user_from_id);
        }
        if ($request->has('user_to_id')) {
            $chats->where('user_to_id', $request->user_to_id);
        }

        return response()->json($chats->get());
    }

    // Afficher un message spécifique
    public function show(Chat $chat)
    {
        return response()->json($chat);
    }

    // Créer un nouveau message
    public function store(Request $request)
    {
        $request->validate([
            'user_from_id' => 'required|exists:users,id',
            'user_to_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $chat = Chat::create($request->all());

        return response()->json($chat, Response::HTTP_CREATED);
    }

    // Mettre à jour un message
    public function update(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string',
            'status' => 'required|string',
        ]);

        $chat->update($request->all());

        return response()->json($chat);
    }

    // Supprimer un message
    public function destroy(Chat $chat)
    {
        $chat->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
