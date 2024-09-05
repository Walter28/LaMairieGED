<?php

// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    // Afficher la liste des notifications
    public function index()
    {
        $notifications = Notification::all();
        return response()->json($notifications);
    }

    // Afficher une notification spécifique
    public function show(Notification $notification)
    {
        return response()->json($notification);
    }

    // Créer une nouvelle notification
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|string',
            'message' => 'required|string',
        ]);

        $notification = Notification::create($request->all());

        return response()->json($notification, Response::HTTP_CREATED);
    }

    // Mettre à jour une notification
    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'status' => 'required|string',
            'message' => 'required|string',
        ]);

        $notification->update($request->all());

        return response()->json($notification);
    }

    // Supprimer une notification
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
