<?php

namespace App\Http\Controllers;

use App\Avisos;
use App\AvisosTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class AvisosController extends Controller
{
  public function subirAvisos(Request $request)
  {
    $archivo = $request->file;
    $results = Excel::load($archivo)->all()->toArray();
    foreach ($results as $row) {
      $base = [];
      $count = 0;
      foreach($row as $x => $x_value) {
        $base[$count] = $x_value;
        $count++;
      }
      $aviso = new AvisosTemp();
      $aviso->campana = $base[0];
      $aviso->campana2 = $base[1];
      $aviso->fecha_entrega = $base[2]->format('Y-m-d');
      $aviso->tipo_visita = $base[3] == null ? "" : $base[3];
      $aviso->municipio = $base[4];
      $aviso->localidad = $base[5];
      $aviso->barrio = $base[6];
      $aviso->direccion = $base[7];
      $aviso->cliente = $base[8];
      $aviso->deuda = $base[9];
      $aviso->factura_vencida = $base[10];
      $aviso->nic = $base[11];
      $aviso->nis = $base[12];
      $aviso->medidor = $base[13];
      $aviso->gestor = $base[14];
      $aviso->supervisor = $base[15];
      $aviso->tarifa = $base[17];
      $aviso->compromiso = $base[18]->format('Y-m-d');
      $aviso->avisos = $base[19];
      $aviso->admin_id = 1;
      $aviso->save();
    }
    return "";
  }
}
