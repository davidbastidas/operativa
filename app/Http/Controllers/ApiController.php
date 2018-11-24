<?php

namespace App\Http\Controllers;

use App\Avisos;
use App\Anomalias;
use App\Resultados;
use App\EntidadesPagos;
use App\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class ApiController extends Controller
{
  public function login(Request $request)
  {
    $response = null;
    $usuarios = Usuarios::where('nickname', '=', $request->user)->where('contrasena', '=', $request->password)->first();
    if(isset($usuarios->id)){
      $response = array(
        'estado' => true,
        'nombre' => $usuarios->nombre,
        'nickname' => $usuarios->nickname,
        'tipo' => $usuarios->tipo_id,
        'fk_delegacion' => $usuarios->delegacion_id,
        'fk_id' => $usuarios->id
      );
    } else {
      $response = array(
        'estado' => false
      );
    }

    return $response;
  }
  public function getAvisos(Request $request)
  {
    $arrayAvisos = [];
    $arrayAnomalias = [];
    $arrayResultados = [];
    $arrayEntidades = [];
    $arrayFINAL = [];
    $collection = null;

    $avisos = Avisos::where('gestor_id', '=', $request->user)->where('estado', '=', '1')->get();
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

  public function actualizarAviso(Request $request)
  {
    $response = null;
    if($request->user){
      $aviso = Avisos::where('id', '=', $request->id)->where('estado', '=', '1')->first();
      if(isset($aviso->id)){
        $aviso->resultado_id = $request->resultado;
        $aviso->anomalia_id = $request->anomalia;
        $aviso->entidad_recaudo_id = $request->entidad_recaudo;
        $aviso->fecha_pago = $request->fecha_pago;
        $aviso->fecha_compromiso = $request->fecha_compromiso;
        $aviso->persona_contacto = $request->persona_contacto;
        $aviso->cedula = $request->cedula;
        $aviso->titular_pago = $request->titular_pago;
        $aviso->telefono = $request->telefono;
        $aviso->correo_electronico = $request->correo_electronico;
        $aviso->observacion_rapida = $request->observacion_rapida;
        $aviso->lectura = $request->lectura;
        $aviso->observacion_analisis = $request->observacion_analisis;
        $aviso->latitud = $request->latitud;
        $aviso->longitud = $request->longitud;
        $aviso->fecha_recibido = Carbon::now();
        $aviso->estado = 2;
        $aviso->orden_realizado = $request->orden_realizado;

        $aviso->save();

        $response = array(
          'estado' => true
        );
      } else {
        $response = array(
          'estado' => false
        );
      }
    } else {
      $response = array(
        'estado' => false
      );
    }

    return $response;
  }
}
