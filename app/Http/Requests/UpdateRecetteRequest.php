<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecetteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'voyage_id'   => 'required|exists:voyages,id',
            'vehicule_id' => 'required|exists:vehicules,id',
            'montant'     => 'required|numeric|min:7500',
            'date'        => 'required|date',
            'type'        => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric'  => 'Le montant doit être un nombre valide.',
            'montant.min'      => 'Le montant doit être d\'au moins 7 500 FCFA.',
        ];
    }
}

