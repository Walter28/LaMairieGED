<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Pour les fichiers, accepter le  cros
Route::get('/file/{path}', function ($path) {
    try {
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            return response()->json(['error' => 'Fichier non trouvé'], 404);
        }

        $headers = [
            'Content-Type' => mime_content_type($fullPath),
            'Access-Control-Allow-Origin' => 'http://localhost:5173/',
        ];

        return response()->file($fullPath, $headers);
    } catch (\Exception $e) {
        // Log l'erreur pour des diagnostics
        \Log::error('Erreur lors de la récupération du fichier : ' . $e->getMessage());

        return response()->json(['error' => 'Erreur serveur'], 500);
    }
})->where('path', '.*');
