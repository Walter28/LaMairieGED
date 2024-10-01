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
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CertificatDeDeceController;
use App\Http\Controllers\CertificatDeResidenceController;
use App\Http\Controllers\CarteIdentiteNationaleController;
use App\Http\Controllers\CertificatDeCelibatController;
use App\Http\Controllers\PermisDeConstruireController;

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
// Route pour récupérer les actes de naissance par demande_id
Route::get('/actes-de-naissance/demande/{demande_id}', [ActeDeNaissanceController::class, 'getByDemandeId']);


// Routes publiques Acte de mariage
Route::get('/actes-de-mariage', [ActeDeMariageController::class, 'index']);
Route::get('/actes-de-mariage/{acteDeMariage}', [ActeDeMariageController::class, 'show']);
// Route pour récupérer les actes de mariage par demande_id
Route::get('/actes-de-mariage/demande/{demande_id}', [ActeDeMariageController::class, 'getByDemandeId']);

// Routes publiques Certificat de décès
Route::get('/certificats-de-dece', [CertificatDeDeceController::class, 'index']);
Route::get('/certificats-de-dece/{id}', [CertificatDeDeceController::class, 'show']);
// Route pour récupérer les certificats de décès par demande_id
Route::get('/certificats-de-dece/demande/{demande_id}', [CertificatDeDeceController::class, 'getByDemandeId']);

// Routes publiques Certificat de résidence
Route::get('/certificats-de-residence', [CertificatDeResidenceController::class, 'index']); // Récupérer tous les certificats de résidence
Route::get('/certificats-de-residence/{id}', [CertificatDeResidenceController::class, 'show']); // Récupérer un certificat de résidence par ID
Route::get('/certificats-de-residence/demande/{demande_id}', [CertificatDeResidenceController::class, 'getByDemandeId']); // Récupé!!rer par demande_id

// Routes publiques pour Carte d'Identité Nationale
Route::get('/cartes-identite-nationale', [CarteIdentiteNationaleController::class, 'index']); // Récupérer toutes les cartes d'identité nationale
Route::get('/cartes-identite-nationale/{id}', [CarteIdentiteNationaleController::class, 'show']); // Récupérer une carte d'identité nationale par ID
Route::get('/cartes-identite-nationale/demande/{demande_id}', [CarteIdentiteNationaleController::class, 'getByDemandeId']); // Récupérer par demande_id

// Routes publiques Certificat de Célibat
Route::get('/certificats-de-celibat', [CertificatDeCelibatController::class, 'index']); // Récupérer tous les certificats de célibat
Route::get('/certificats-de-celibat/{id}', [CertificatDeCelibatController::class, 'show']); // Récupérer un certificat de célibat par ID
Route::get('/certificats-de-celibat/demande/{demande_id}', [CertificatDeCelibatController::class, 'getByDemandeId']); // Récupérer par demande_id

// Routes publiques pour Permis de Construire
Route::get('/permis-de-construire', [PermisDeConstruireController::class, 'index']); // Récupérer tous les permis de construire
Route::get('/permis-de-construire/{id}', [PermisDeConstruireController::class, 'show']); // Récupérer un permis de construire par ID
Route::get('/permis-de-construire/demande/{demande_id}', [PermisDeConstruireController::class, 'getByDemandeId']); // Récupérer par demande_id




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
    Route::put('/actes-de-mariage/{id}', [ActeDeMariageController::class, 'update']);
    Route::delete('/actes-de-mariage/{id}', [ActeDeMariageController::class, 'destroy']);

    // Certificat de décès routes privées
    Route::post('/certificats-de-dece', [CertificatDeDeceController::class, 'store']);
    Route::put('/certificats-de-dece/{id}', [CertificatDeDeceController::class, 'update']);
    Route::delete('/certificats-de-dece/{id}', [CertificatDeDeceController::class, 'destroy']);

    // Certificat de résidence routes privées
    Route::post('/certificats-de-residence', [CertificatDeResidenceController::class, 'store']); // Créer un nouveau certificat de résidence
    Route::put('/certificats-de-residence/{id}', [CertificatDeResidenceController::class, 'update']); // Mettre à jour un certificat de résidence existant
    Route::delete('/certificats-de-residence/{id}', [CertificatDeResidenceController::class, 'destroy']); // Supprimer un certificat de résidence

    // Routes privées pour Carte d'Identité Nationale
    Route::post('/cartes-identite-nationale', [CarteIdentiteNationaleController::class, 'store']); // Créer une nouvelle carte d'identité nationale
    Route::put('/cartes-identite-nationale/{id}', [CarteIdentiteNationaleController::class, 'update']); // Mettre à jour une carte d'identité nationale existante
    Route::delete('/cartes-identite-nationale/{id}', [CarteIdentiteNationaleController::class, 'destroy']); // Supprimer une carte d'identité nationale

    // Routes privées Certificat de Célibat
    Route::post('/certificats-de-celibat', [CertificatDeCelibatController::class, 'store']); // Créer un nouveau certificat de célibat
    Route::put('/certificats-de-celibat/{id}', [CertificatDeCelibatController::class, 'update']); // Mettre à jour un certificat de célibat existant
    Route::delete('/certificats-de-celibat/{id}', [CertificatDeCelibatController::class, 'destroy']); // Supprimer un certificat de célibat

    // Routes privées pour Permis de Construire
    Route::post('/permis-de-construire', [PermisDeConstruireController::class, 'store']); // Créer un nouveau permis de construire
    Route::put('/permis-de-construire/{id}', [PermisDeConstruireController::class, 'update']); // Mettre à jour un permis de construire existant
    Route::delete('/permis-de-construire/{id}', [PermisDeConstruireController::class, 'destroy']); // Supprimer un permis de construire



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
