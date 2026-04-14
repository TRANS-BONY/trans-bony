<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecetteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicule_id' => 'required|exists:vehicules,id',
            'montant' => 'required|numeric|min:0|max:999999.99',
            'date' => 'required|date',
            'type' => 'required|string|max:50',
        ];
    }
}

