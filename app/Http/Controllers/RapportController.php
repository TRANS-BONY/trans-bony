<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Models\Voyage;
use App\Models\Recette;
use App\Models\Chauffeur;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RapportExport;
use App\Models\RecetteMensuelle;
use Maatwebsite\Excel\Facades\Excel;

class RapportController extends Controller
{
    public function index()
{
    return view('admin.rapport.index', [
        'vehicules' => Vehicule::count(),
        'voyages' => Voyage::count(),
        'chauffeurs' => Chauffeur::count(),
        'recettes' => RecetteMensuelle::sum('montant'),
    ]);
}

    // 📄 PDF
    public function exportPDF()
    {
        // Check permission
        if (! auth('web')->user()->hasPermissionTo('voir rapports')) {
            abort(403, 'Permission refusée');
        }

        $data = [
            'vehicules' => Vehicule::count(),
            'voyages' => Voyage::count(),
            'recettes' => RecetteMensuelle::sum('montant'),
        ];

        $pdf = Pdf::loadView('admin.rapport.pdf', $data);

        return $pdf->download('rapport.pdf');
    }

    //  EXCEL
    public function exportExcel()
    {
        return Excel::download(new RapportExport, 'rapport.xlsx');
    }

    public function create()
{
    return view('rapport.create');
}

public function edit($id)
{
    return view('rapport.edit');
}
}
