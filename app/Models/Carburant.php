<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carburant extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicule_id',
        'date',
        'quantite',
        'montant',
        'compteur_km',
        'station'
    ];

    protected $casts = [
        'date' => 'date',
        'quantite' => 'decimal:2',
        'montant' => 'decimal:2',
        'compteur_km' => 'integer',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}
