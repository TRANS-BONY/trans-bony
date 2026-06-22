<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use Illuminate\Http\Request;

class ColisController extends Controller
{
    /**
     * Affiche la liste des colis.
     */
    public function index()
    {
        $colis = Colis::latest()->paginate(10);
        return view('admin.colis.index', compact('colis'));
    }
}
