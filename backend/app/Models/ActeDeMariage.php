<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActeDeMariage extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',
        'husband_full_name',
        'husband_id_card',
        'husband_certificat_naiss',
        'marry_full_name',
        'marry_id_card',
        'marry_certificat_naiss',
        'wedding_place',
        'wedding_date',
        'couple_leaving_proof',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
