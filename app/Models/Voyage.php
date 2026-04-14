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

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }
}
