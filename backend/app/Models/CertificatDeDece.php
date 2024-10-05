<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificatDeDece extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_complet_defunt',
        'date_de_deces',
        'lieu_de_deces',
        'certificat_medical_deces',
        'preuve_identite_defunt',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
