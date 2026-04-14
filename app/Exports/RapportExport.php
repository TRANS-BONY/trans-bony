<?php

namespace App\Exports;

use App\Models\Vehicule;
use App\Models\Voyage;
use App\Models\Recette;
use App\Models\RecetteMensuelle;
use Maatwebsite\Excel\Concerns\FromCollection;

class RapportExport implements FromCollection
{
    public function collection()
    {
        return collect([
            ['Véhicules', Vehicule::count()],
            ['Voyages', Voyage::count()],
            ['Recettes', RecetteMensuelle::sum('montant')],
        ]);
    }
}
