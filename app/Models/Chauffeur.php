<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'permis',
        'telephone',
        'photo',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function voyages()
    {
        return $this->hasMany(Voyage::class);
    }
}
