<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'immatriculation',
        'marque',
        'modele',
        'annee',
        'capacite',
        'kilometrage',
        'statut'
    ];

    protected $casts = [
        'annee' => 'integer',
        'capacite' => 'integer',
        'kilometrage' => 'integer',
    ];

    public function voyages()
    {
        return $this->hasMany(Voyage::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function recettes()
    {
        return $this->hasMany(RecetteMensuelle::class);
    }

    public function carburants()
    {
        return $this->hasMany(Carburant::class);
    }
}
