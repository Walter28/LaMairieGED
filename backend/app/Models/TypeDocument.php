<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description'];

    /**
     * Get the demandes for the type of document.
     */
    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
