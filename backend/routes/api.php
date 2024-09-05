<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeDocumentController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ActeDeNaissanceController;
use App\Http\Controllers\ActeDeMariageController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route pour récupérer tous les documents (publique)
Route::get('type_documents', [TypeDocumentController::class, 'index']);
// Route pour récupérer un document par ID (publique)
Route::get('type_documents/{id}', [TypeDocumentController::class, 'show']);


// Demandes Routes publiques
Route::get('/demandes', [DemandeController::class, 'index']);
Route::get('/demandes/{demande}', [DemandeController::class, 'show']);


// Routes publiques Acte de naissance
Route::get('/actes-de-naissance', [ActeDeNaissanceController::class, 'index']);
Route::get('/actes-de-naissance/{id}', [ActeDeNaissanceController::class, 'show']);


// Routes publiques Acte de mariage
Route::get('/actes-de-mariage', [ActeDeMariageController::class, 'index']);
Route::get('/actes-de-mariage/{acteDeMariage}', [ActeDeMariageController::class, 'show']);


//users routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/login', [AuthController::class, 'login']);




// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    // Route pour créer un nouveau document (authentifiée)
    Route::post('type_documents', [TypeDocumentController::class, 'store']);
    // Route pour mettre à jour un document existant (authentifiée)
    Route::put('type_documents/{id}', [TypeDocumentController::class, 'update']);
    // Route pour supprimer un document (authentifiée)
    Route::delete('type_documents/{id}', [TypeDocumentController::class, 'destroy']);
    

    // Demandes privates routes
    Route::post('/demandes', [DemandeController::class, 'store']);
    Route::put('/demandes/{demande}', [DemandeController::class, 'update']);
    Route::delete('/demandes/{demande}', [DemandeController::class, 'destroy']);

    //Acte de naissance privates routes
    Route::post('/actes-de-naissance', [ActeDeNaissanceController::class, 'store']);
    Route::put('/actes-de-naissance/{id}', [ActeDeNaissanceController::class, 'update']);
    Route::delete('/actes-de-naissance/{id}', [ActeDeNaissanceController::class, 'destroy']);

    //Acte de mariage private routes
    Route::post('/actes-de-mariage', [ActeDeMariageController::class, 'store']);
    Route::put('/actes-de-mariage/{acteDeMariage}', [ActeDeMariageController::class, 'update']);
    Route::delete('/actes-de-mariage/{acteDeMariage}', [ActeDeMariageController::class, 'destroy']);

    //Will keep all notifications privates coz notifications need a user to be connected first
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/{notification}', [NotificationController::class, 'show']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::put('/notifications/{notification}', [NotificationController::class, 'update']);
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy']);


    // Will keep all chat privates to authenticated users
    Route::get('/chats', [ChatController::class, 'index']);
    Route::get('/chats/{chat}', [ChatController::class, 'show']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::put('/chats/{chat}', [ChatController::class, 'update']);
    Route::delete('/chats/{chat}', [ChatController::class, 'destroy']);


    //users routes
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes privées pour User
    Route::get('/users', [UserController::class, 'index']); // Récupérer tous les utilisateurs
    Route::get('/users/{id}', [UserController::class, 'show']); // Récupérer un utilisateur par ID
    Route::post('/users', [UserController::class, 'store']); // Créer un nouvel utilisateur
    Route::put('/users/{id}', [UserController::class, 'update']); // Mettre à jour un utilisateur existant
    Route::delete('/users/{id}', [UserController::class, 'destroy']); // Supprimer un utilisateur

    
    
});
//this help you to grap all routes, get all route based on deafut api method created in controllers by default
//to check those route type > php artisan route:list
// Route::resource('documents', DocumentController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
