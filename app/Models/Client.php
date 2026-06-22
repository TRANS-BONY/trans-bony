<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'telephone', 'email',
        'type', 'adresse', 'ville', 'numero_id', 'created_by',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
