<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadExcelController extends Controller
{
    public function index()
    {
        $id = Session::get('adminId');
        $name = Session::get('adminName');

        return view('admin.upload', ['id' => $id, 'name' => $name]);
    }

    public function upload(Request $request)
    {
       $archivo = $request->file;
       $rows = Excel::load($archivo)->get();

       foreach ($rows as $row) {
            $modelo->camapana = $row->camapana;
            $modelo->campana = $row->campana;
            $modelo->fecha_de_entraga = $row->fecha_de_entraga;
            $modelo->tipo_de_visita = $row->tipo_de_visita;
            $modelo->municipio = $row->municipio;
            $modelo->localidad = $row->localidad;
            $modelo->barrio = $row->barrio;
            $modelo->direccion = $row->direccion;
            $modelo->cliente_o_sgc = $row->cliente_o_sgc;
            $modelo->deuda = $row->deuda;
            $modelo->fact_venc = $row->fact_venc;
            $modelo->nic = $row->nic;
            $modelo->nis = $row->nis;
            $modelo->medidor = $row->medidor;
            $modelo->gestor_de_cobro = $row->gestor_de_cobro;
            $modelo->supervisor = $row->supervisor;
            $modelo->zona = $row->zona;
            $modelo->tarifa = $row->tarifa;
            $modelo->compromiso = $row->compromiso;
            $modelo->avisos = $row->avisos;
       }
       return $rows;
    }
}
