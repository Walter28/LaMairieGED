<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_document_id',
        'status',
        'submitting_date',
        'traitement_date',
    ];

    /**
     * Get the user that owns the demande.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the type of document associated with the demande.
     */
    public function typeDocument()
    {
        return $this->belongsTo(TypeDocument::class);
    }

    public function acteDeNaissance()
    {
        return $this->hasOne(ActeDeNaissance::class);
    }

    public function acteDeMariage()
    {
        return $this->hasOne(ActeDeMariage::class);
    }
}
