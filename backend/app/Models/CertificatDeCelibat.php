<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatDeCelibat extends Model
{
    use HasFactory;

    protected $table = 'certificat_de_celibat';

    protected $fillable = [
        'nom_complet_celibataire',
        'date_naissance',
        'lieu_naissance',
        'preuve_identite',
        'acte_naissance',
        'declaration_honneur',
        'demande_id'
    ];

    // Relation avec la table 'demande'
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
