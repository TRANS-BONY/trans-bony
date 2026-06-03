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
        $id = $this->route('maintenance') ? $this->route('maintenance')->id : null;

        return [
            'vehicule_id' => 'required|exists:vehicules,id',
            'type'        => 'required|in:preventive,curative',
            'date_prevue' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($id) {
                    $vehiculeId = $this->input('vehicule_id');
                    if ($vehiculeId) {
                        $duplicate = \App\Models\Maintenance::where('vehicule_id', $vehiculeId)
                            ->whereDate('date_prevue', $value)
                            ->where('statut', '!=', 'annule')
                            ->when($id, function ($query) use ($id) {
                                return $query->where('id', '!=', $id);
                            })
                            ->first();

                        if ($duplicate) {
                            $fail("Ce véhicule a déjà une maintenance ({$duplicate->type}) enregistrée pour cette date (Statut: {$duplicate->statut}).");
                        }

                        // Vérifier si le véhicule est actuellement en mission
                        if ($this->input('statut') === 'en_cours') {
                            $vehicule = \App\Models\Vehicule::find($vehiculeId);
                            if ($vehicule && $vehicule->statut === 'mission') {
                                $fail("Impossible de démarrer une maintenance car le véhicule est actuellement en mission.");
                            }
                        }
                    }
                },
            ],
            'statut'      => 'required|in:planifie,en_cours,termine,annule',
            'compteur_km' => 'nullable|integer|min:0',
            'cout'        => 'required|numeric|min:0',
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
            'cout.required'        => 'Le coût est obligatoire.',
            'cout.numeric'         => 'Le coût doit être un nombre.',
            'cout.between'         => 'Le coût doit être compris entre 5 000 et 65 000 FCFA.',
        ];
    }
}
