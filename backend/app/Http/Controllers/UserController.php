<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // GET /api/users
    public function index(Request $request)
    {
        $users = User::all();
        return response()->json($users);
    }

    // GET /api/users/{id}
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }
        return response()->json($user);
    }

    // POST /api/users (Enregistrement d'un nouvel utilisateur)
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', 
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'sexe' => 'required|string|max:255',
            'role' => 'string|default:citoyen|max:255',
            'profile_pic' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'identity_card' => 'required|mimes:pdf|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $userData = $request->all();

        // Gérer le téléchargement de fichier pour `profile_pic`
        if ($request->hasFile('profile_pic')) {
            $fileName = $request->file('profile_pic')->getClientOriginalName();
            $request->file('profile_pic')->storeAs('public/uploads/'.$userData['email'], $fileName);
            $userData['profile_pic'] = 'uploads/'.$userData['email'].'/'.$fileName;
        }

        // Gérer le téléchargement de fichier pour `identity_card`
        if ($request->hasFile('identity_card')) {
            $fileName = $request->file('identity_card')->getClientOriginalName();
            $request->file('identity_card')->storeAs('public/uploads/'.$userData['email'], $fileName);
            $userData['identity_card'] = 'uploads/'.$userData['email'].'/'.$fileName;
        }

        $userData['password'] = Hash::make($request->password);

        $user = User::create($userData);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Utilisateur enregistré avec succès'
        ], 201);
    }

    // PUT /api/users/{id} (Mise à jour d'un utilisateur)
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $request->validate([
            'full_name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'birth_date' => 'date',
            'birth_place' => 'string|max:255',
            'address' => 'string|max:255',
            'nationality' => 'string|max:255',
            'sexe' => 'string|max:255',
            'role' => 'string|max:255',
            'profile_pic' => 'image|mimes:jpg,png,jpeg|max:2048',
            'identity_card' => 'mimes:pdf|max:2048',
            'password' => 'string|min:8|confirmed',
        ]);

        $userData = $request->all();

        // Gérer le téléchargement de fichier pour `profile_pic`
        if ($request->hasFile('profile_pic')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->profile_pic && Storage::exists('public/' . $user->profile_pic)) {
                Storage::delete('public/' . $user->profile_pic);
            }

            $fileName = $request->file('profile_pic')->getClientOriginalName();
            $request->file('profile_pic')->storeAs('public/uploads/'.$userData['email'], $fileName);
            $userData['profile_pic'] = 'uploads/'.$userData['email'].'/'.$fileName;
        }

        // Gérer le téléchargement de fichier pour `identity_card`
        if ($request->hasFile('identity_card')) {
            // Supprimer l'ancienne carte d'identité si elle existe
            if ($user->identity_card && Storage::exists('public/' . $user->identity_card)) {
                Storage::delete('public/' . $user->identity_card);
            }

            $fileName = $request->file('identity_card')->getClientOriginalName();
            $request->file('identity_card')->storeAs('public/uploads/'.$userData['email'], $fileName);
            $userData['identity_card'] = 'uploads/'.$userData['email'].'/'.$fileName;
        }

        // Gérer la mise à jour du mot de passe
        if ($request->has('password')) {
            $userData['password'] = Hash::make($request->input('password'));
        }

        $user->update($userData);

        return response()->json(['message' => 'Utilisateur mis à jour avec succès', 'user' => $user]);
    }

    // DELETE /api/users/{id} (Suppression d'un utilisateur)
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        // Supprimer les fichiers associés
        if ($user->profile_pic && Storage::exists('public/' . $user->profile_pic)) {
            Storage::delete('public/' . $user->profile_pic);
        }

        if ($user->identity_card && Storage::exists('public/' . $user->identity_card)) {
            Storage::delete('public/' . $user->identity_card);
        }

        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
