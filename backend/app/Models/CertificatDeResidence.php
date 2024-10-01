<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatDeResidence extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_complet_du_resident',
        'adresse_actuelle_de_la_residence',
        'preuve_de_residence',
        'carte_identite_du_resident',
        'declaration_sur_l_honneur',
        'demande_id',
    ];

    // Relation avec le modèle Demande
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}

