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
        'cout'
    ];

    protected $casts = [
        'date_prevue' => 'datetime',
        'cout' => 'decimal:2',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}
