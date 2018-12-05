<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Avisos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function getAvancePorGestor(Request $request){
    $agendas = Agenda::where('fecha', $request->fecha)->get();
    $avisosPendientes = Avisos::where('estado', 1)
        ->where('fecha_entrega', 'LIKE', DB::raw("'%$request->fecha%'"))
        ->count();

    $avisosRealizados = Avisos::where('estado', 2)
        ->where('fecha_entrega', 'LIKE', DB::raw("'%$request->fecha%'"))
        ->count();
    return response()->json([
        'pendientes' => $request->fecha
    ]);
  }
}
