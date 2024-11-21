<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteIdentiteNationale extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_complet_citoyen',
        'date_de_naissance',
        'lieu_de_naissance',
        'adresse_actuelle',
        'photo_identite',
        'preuve_identite',
        'empreintes_digitales',
        'demande_id', // clé étrangère
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
