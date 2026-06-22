<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Signalement extends Model
{
    use HasFactory;

    protected $fillable = [
        'voyage_id',
        'chauffeur_id',
        'type',
        'description',
        'localisation',
        'gravite',
        'statut',
        'photo'
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }

    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }
}
