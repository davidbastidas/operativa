<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Avisos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function getAvancePorGestor(Request $request){
    $agendas = Agenda::where('fecha', 'LIKE', DB::raw("'%$request->fecha%'"))->get();
    $arrayAgendas = [];
    $count = 0;
    $stringIn = '';
    foreach ($agendas as $agenda) {
      $arrayAgendas[] = $agenda->id;
      if($count == 0){
        $stringIn = $agenda->id;
        $count++;
      } else {
        $stringIn .= ',' . $agenda->id;
      }
    }

    $gestores = [];
    if(count($arrayAgendas) > 0){
      $gestores = Avisos::select(
              DB::raw("u.nombre"),
              DB::raw("(select count(1) from avisos ar where a.gestor_id = ar.gestor_id and ar.estado = 2 and ar.agenda_id in ($stringIn)) as realizados"),
              DB::raw("(select count(1) from avisos ar where a.gestor_id = ar.gestor_id and ar.estado = 1 and ar.agenda_id in ($stringIn)) as pendientes")
          )
          ->from(DB::raw('avisos a'))
          ->join('usuarios as u', 'u.id', '=', 'a.gestor_id')
          ->whereIn('a.agenda_id', $arrayAgendas)
          ->groupBy('u.nombre', 'realizados', 'pendientes')
          ->orderBy('u.nombre')->get();
    }

    return response()->json([
        'gestores' => $gestores
    ]);
  }

  public function getAvanceDiario(Request $request){
    $agendas = Agenda::where('fecha', 'LIKE', DB::raw("'%$request->fecha%'"))->get();
    $arrayAgendas = [];
    foreach ($agendas as $agenda) {
      $arrayAgendas[] = $agenda->id;
    }

    $pendientes = 0;
    $resueltos = 0;
    if(count($arrayAgendas) > 0){
      $pendientes = Avisos::where('estado','1')->whereIn('agenda_id', $arrayAgendas)->count();
      $resueltos = Avisos::where('estado','2')->whereIn('agenda_id', $arrayAgendas)->count();
    }

    return response()->json([
        'pendientes' => $pendientes,
        'resueltos' => $resueltos
    ]);
  }

  public function getPointMapGestores(Request $request){
    $agendas = Agenda::where('fecha', 'LIKE', DB::raw("'%$request->fecha%'"))->get();
    $arrayAgendas = [];
    $count = 0;
    $stringIn = '';
    foreach ($agendas as $agenda) {
      $arrayAgendas[] = $agenda->id;
      if($count == 0){
        $stringIn = $agenda->id;
        $count++;
      } else {
        $stringIn .= ',' . $agenda->id;
      }
    }

    $gestores = [];
    if(count($arrayAgendas) > 0){
      $gestores = Avisos::select(
              DB::raw("u.nombre"),
              DB::raw("(select ar.latitud from avisos ar where a.gestor_id = ar.gestor_id and ar.agenda_id in ($stringIn) order by ar.orden_realizado desc limit 1) as lat"),
              DB::raw("(select ar.longitud from avisos ar where a.gestor_id = ar.gestor_id and ar.agenda_id in ($stringIn) order by ar.orden_realizado desc limit 1) as lon")
          )
          ->from(DB::raw('avisos a'))
          ->join('usuarios as u', 'u.id', '=', 'a.gestor_id')
          ->whereIn('a.agenda_id', $arrayAgendas)
          ->groupBy('u.nombre', 'lat', 'lon')->get();
    }

    return response()->json([
      'gestores' => $gestores
    ]);
  }
}
