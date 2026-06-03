<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'vehicule_id',
        'type',
        'date_prevue',
        'statut',
        'compteur_km',
        'cout'
    ];

    protected $casts = [
        'date_prevue' => 'datetime',
        'cout' => 'decimal:2',
        'compteur_km' => 'integer',
    ];

    protected static function booted()
    {
        static::created(function ($maintenance) {
            if ($maintenance->vehicule) {
                $maintenance->vehicule->update(['statut' => 'maintenance']);
            }
        });

        static::updated(function ($maintenance) {
            if ($maintenance->wasChanged('statut') && $maintenance->statut === 'termine') {
                // Si la maintenance est terminée, on enregistre le kilométrage actuel du véhicule
                $maintenance->update(['compteur_km' => $maintenance->vehicule->kilometrage]);
                $maintenance->vehicule->update(['statut' => 'disponible']);
            }
        });
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}
