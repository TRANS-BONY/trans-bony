<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicule_id' => 'required|exists:vehicules,id',
            'type'        => 'required|in:preventive,curative',
            'date_prevue' => 'required|date',
            'statut'      => 'required|in:planifiee,en cours,terminee',
            'cout'        => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'vehicule_id.required' => 'Le véhicule est obligatoire.',
            'vehicule_id.exists'   => 'Le véhicule sélectionné est invalide.',
            'type.required'        => 'Le type de maintenance est obligatoire.',
            'type.in'              => 'Le type doit être preventive ou curative.',
            'date_prevue.required' => 'La date prévue est obligatoire.',
            'date_prevue.date'     => 'La date prévue doit être une date valide.',
            'statut.required'      => 'Le statut est obligatoire.',
            'statut.in'            => 'Le statut est invalide.',
            'cout.numeric'         => 'Le coût doit être un nombre.',
            'cout.min'             => 'Le coût ne peut pas être négatif.',
        ];
    }
}
