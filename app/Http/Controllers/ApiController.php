<?php

namespace App\Http\Controllers;

use App\Avisos;
use App\Anomalias;
use App\Resultados;
use App\EntidadesPagos;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ApiController extends Controller
{
  public function login(Request $request)
  {
    
  }
  public function getAvisos(Request $request)
  {
    $arrayAvisos = [];
    $arrayAnomalias = [];
    $arrayResultados = [];
    $arrayEntidades = [];
    $arrayFINAL = [];
    $collection = null;

    $avisos = Avisos::where('gestor_id', '=', $request->user)->get();
    foreach ($avisos as $aviso) {
      array_push($arrayAvisos, (object) array(
        'id' => $aviso->id,
        'municipio' => $aviso->municipio,
        'localidad' => $aviso->localidad,
        'barrio' => $aviso->barrio,
        'direccion' => $aviso->direccion,
        'cliente' => $aviso->cliente,
        'deuda' => $aviso->deuda,
        'factura_vencida' => $aviso->factura_vencida,
        'nic' => $aviso->nic,
        'nis' => $aviso->nis,
        'medidor' => $aviso->medidor,
        'tarifa' => $aviso->tarifa,
        'fecha_limite_compromiso' => $aviso->compromiso
      ));
    }

    $anomalias = Anomalias::all();
    foreach ($anomalias as $anomalia) {
      array_push($arrayAnomalias, (object) array(
        'id' => $anomalia->id,
        'nombre' => $anomalia->nombre
      ));
    }

    $resultados = Resultados::all();
    foreach ($resultados as $resultado) {
      array_push($arrayResultados, (object) array(
        'id' => $resultado->id,
        'nombre' => $resultado->nombre
      ));
    }

    $entidades = EntidadesPagos::all();
    foreach ($entidades as $entidad) {
      array_push($arrayEntidades, (object) array(
        'id' => $entidad->id,
        'nombre' => $entidad->nombre
      ));
    }

    array_push($arrayFINAL, (object) array(
      'visitas' => $arrayAvisos,
      'anomalias' => $arrayAnomalias,
      'resultados' => $arrayResultados,
      'entidades' => $arrayEntidades
    ));
    $collection = new Collection($arrayFINAL);
    return $collection;
  }
}
