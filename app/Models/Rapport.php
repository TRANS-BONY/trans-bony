<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rapport extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'type',
        'periode_debut',
        'periode_fin',
        'recettes_total',
        'nb_voyages',
        'nb_vehicules',
        'nb_chauffeurs',
        'notes',
        'statut',
        'user_id',
    ];

    protected $casts = [
        'periode_debut'  => 'date',
        'periode_fin'    => 'date',
        'recettes_total' => 'decimal:2',
        'nb_voyages'     => 'integer',
        'nb_vehicules'   => 'integer',
        'nb_chauffeurs'  => 'integer',
    ];

    /** Calcule et met à jour les statistiques du rapport selon la période */
    public function calculateStatistics(): self
    {
        $debut = \Carbon\Carbon::parse($this->periode_debut)->startOfDay();
        $fin   = \Carbon\Carbon::parse($this->periode_fin)->endOfDay();

        $this->recettes_total = RecetteMensuelle::whereBetween('date', [$debut, $fin])->sum('montant');
        $this->nb_voyages     = Voyage::whereBetween('date_depart', [$debut, $fin])->count();
        $this->nb_vehicules   = Vehicule::count();
        $this->nb_chauffeurs  = Chauffeur::count();

        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Durée en jours de la période */
    public function getDureeAttribute(): int
    {
        return $this->periode_debut->diffInDays($this->periode_fin) + 1;
    }

    /** Badge couleur selon statut */
    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'publié'    => 'emerald',
            'brouillon' => 'amber',
            default     => 'gray',
        };
    }
}
