<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = [
        'voyage_id',
        'chauffeur_id',
        'vehicule_id',
        'role_chauffeur',
        'ordre',
        'km_depart_chauffeur',
        'km_fin_chauffeur'
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }

    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}
