<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Assign; // Make sure to import your Assign model
use Illuminate\Support\Facades\Auth;

class AssignDetailsController extends Controller
{
    public function view($id)
    {
        $assign = Assign::findOrFail($id);
        $currentUser = Auth::user();
        $pdf = Pdf::loadView('assign-details', compact('assign', 'currentUser'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        return $pdf->stream('undertaking_form.pdf');
    }

}
