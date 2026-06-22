<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'voyage_id', 'client_id', 'numero_billet',
        'nb_passagers', 'nb_colis', 'poids_colis_kg',
        'montant', 'mode_paiement', 'paye', 'paye_le',
        'statut', 'siege', 'bagage_kg', 'notes', 'created_by',
    ];

    protected $casts = [
        'paye'           => 'boolean',
        'paye_le'        => 'datetime',
        'montant'        => 'decimal:2',
        'poids_colis_kg' => 'decimal:2',
        'bagage_kg'      => 'decimal:2',
        'nb_passagers'   => 'integer',
        'nb_colis'       => 'integer',
    ];

    // ───────────────────────────────────────────────
    // RELATIONS
    // ───────────────────────────────────────────────
    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ───────────────────────────────────────────────
    // GÉNÉRATION AUTOMATIQUE DU NUMÉRO DE BILLET
    // ───────────────────────────────────────────────
    protected static function booted(): void
    {
        static::creating(function ($reservation) {
            if (empty($reservation->numero_billet)) {
                $reservation->numero_billet = self::generateNumeroBillet();
            }
        });
    }

    public static function generateNumeroBillet(): string
    {
        do {
            $year  = now()->format('Y');
            $seq   = str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
            $num   = "TB-{$year}-{$seq}";
        } while (self::where('numero_billet', $num)->exists());

        return $num;
    }

    // ───────────────────────────────────────────────
    // ACCESSEURS
    // ───────────────────────────────────────────────
    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'En attente',
            'confirmee'  => 'Confirmée',
            'embarquee'  => 'Embarquée',
            'annulee'    => 'Annulée',
            'termine'    => 'Terminée',
            default      => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'amber',
            'confirmee'  => 'blue',
            'embarquee'  => 'green',
            'annulee'    => 'red',
            'termine'    => 'gray',
            default      => 'gray',
        };
    }

    // ───────────────────────────────────────────────
    // DONNÉES QR CODE (JSON)
    // ───────────────────────────────────────────────
    public function getQrDataAttribute(): string
    {
        return json_encode([
            'billet'       => $this->numero_billet,
            'client'       => $this->client?->full_name,
            'voyage'       => $this->voyage?->destination,
            'date'         => $this->voyage?->date_depart?->format('d/m/Y H:i'),
            'passagers'    => $this->nb_passagers,
            'colis'        => $this->nb_colis,
            'statut'       => $this->statut,
        ], JSON_UNESCAPED_UNICODE);
    }
}
