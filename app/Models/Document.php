<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'vehicule_id',
        'type',
        'date_emission',
        'date_expiration',
        'fichier'
    ];

    protected $casts = [
        'date_emission' => 'datetime',
        'date_expiration' => 'datetime',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}
