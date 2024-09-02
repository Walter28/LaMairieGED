<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActeDeNaissance extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',
        'kid_full_name',
        'kid_birth_date',
        'kid_birth_place',
        'kid_certificat_medical',
        'dad_full_name',
        'dad_id_card',
        'mum_full_name',
        'mum_id_card',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
