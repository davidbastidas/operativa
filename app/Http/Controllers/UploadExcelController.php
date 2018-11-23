<?php

namespace App\Http\Controllers;

use App\Avisos;
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
            $avisoTMP = new Avisos();

            $avisoTMP->camapana = $row->camapana;
            $avisoTMP->campana = $row->campana;
            $avisoTMP->fecha_de_entraga = $row->fecha_de_entraga;
            $avisoTMP->tipo_de_visita = $row->tipo_de_visita;
            $avisoTMP->municipio = $row->municipio;
            $avisoTMP->localidad = $row->localidad;
            $avisoTMP->barrio = $row->barrio;
            $avisoTMP->direccion = $row->direccion;
            $avisoTMP->cliente_o_sgc = $row->cliente_o_sgc;
            $avisoTMP->deuda = $row->deuda;
            $avisoTMP->fact_venc = $row->fact_venc;
            $avisoTMP->nic = $row->nic;
            $avisoTMP->nis = $row->nis;
            $avisoTMP->medidor = $row->medidor;
            $avisoTMP->gestor_de_cobro = $row->gestor_de_cobro;
            $avisoTMP->supervisor = $row->supervisor;
            $avisoTMP->zona = $row->zona;
            $avisoTMP->tarifa = $row->tarifa;
            $avisoTMP->compromiso = $row->compromiso;
            $avisoTMP->avisos = $row->avisos;

            $avisoTMP->save();
        }
        return $rows;
    }

    public function download()
    {

        Excel::create('Avisos', function ($excel) {

            $avisos = Avisos::all();

            $excel->sheet('Avisos', function ($sheet) use ($avisos) {

                $sheet->fromArray($avisos);

            });

        })->export('xlsx');
    }
}
