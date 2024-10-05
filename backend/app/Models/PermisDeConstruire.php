<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisDeConstruire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_demandeur',
        'adresse_site_construction',
        'plans_construction',
        'permis_urbanisme',
        'preuve_propriete_terrain',
        'preuve_identite',
        'demande_id',
    ];

    // Relation avec le modèle Demande
    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
