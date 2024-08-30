<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'action',
    ];

    // Relationship with Document model
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
