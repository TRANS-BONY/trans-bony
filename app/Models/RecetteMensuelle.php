<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetteMensuelle extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'vehicule_id',
        'montant',
        'date',
        'type'
    ];

    protected $casts = [
        'date' => 'datetime',
        'montant' => 'decimal:2',
    ];

    public function getMoisAttribute(): ?string
    {
        return $this->date?->format('Y-m');
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
