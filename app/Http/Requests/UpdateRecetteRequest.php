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
            'vehicule_id' => 'sometimes|exists:vehicules,id',
            'montant' => 'required|integer|min:7500',
            'date' => 'required|date',
            'type' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.integer'  => 'Le montant doit être un nombre entier (pas de virgule).',
            'montant.min'      => 'Le montant doit être d\'au moins 7 500 FCFA.',
        ];
    }
}

