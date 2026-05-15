<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'vehicule_id',
        'chauffeur_id',
        'date_depart',
        'destination',
        'nb_passagers',
        'type'
    ];

    protected $casts = [
        'date_depart' => 'datetime',
        'nb_passagers' => 'integer',
    ];

    protected static function booted()
    {
        static::created(function ($voyage) {
            if ($voyage->vehicule) {
                $status = $voyage->type === 'maintenance' ? 'maintenance' : 'mission';
                $voyage->vehicule->update(['statut' => $status]);
            }
        });

        static::deleted(function ($voyage) {
            if ($voyage->vehicule) {
                // If no more active voyages for this vehicle, set to disponible
                $activeVoyages = Voyage::where('vehicule_id', $voyage->vehicule_id)->count();
                if ($activeVoyages === 0) {
                    $voyage->vehicule->update(['statut' => 'disponible']);
                }
            }
        });
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }
}
