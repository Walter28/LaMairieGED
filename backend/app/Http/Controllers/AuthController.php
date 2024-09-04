<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',  // Validation de l'email
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

        $token = $user->createToken('thisisthesimplewayiusetocreatemytoken')->plainTextToken;

        return response()->json(
            [
                'user' => $user,
                'token' => $token,
                'message' => 'Utilisateur enregistré avec succès'
            ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token, 
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out ...'
        ];
    }
}
