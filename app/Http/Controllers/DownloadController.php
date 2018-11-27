<?php

namespace App\Http\Controllers;

use App\Avisos;
use App\Delegacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    public $avisos = null;

    public function index()
    {
        $id = Session::get('adminId');
        $name = Session::get('adminName');

        $delegacion = Delegacion::all();

        return view('admin.download', ['id' => $id, 'name' => $name, 'delegaciones' => $delegacion]);
    }

    public function download(Request $request)
    {
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;
        $delegacion = $request->delegacion;

        $model = new Avisos();
        $avisos = $model->hydrate(
            DB::select(
                "call download_avisos('$fecha1', '$fecha2', $delegacion)"
            )
        );

        $this->avisos = $avisos;

        if ($avisos == "[]") {
            $id = Session::get('adminId');
            $name = Session::get('adminName');

            $delegacion = Delegacion::all();

            $info = 'No Hay Datos en este rango de fechas.';

            return view('admin.download', [
                'id' => $id, 'name' => $name,
                'delegaciones' => $delegacion,
                'info' => $info
            ]);

        } else {
            Excel::create('Avisos', function ($excel) {

                $avisos = $this->avisos;

                $excel->sheet('Avisos', function ($sheet) use ($avisos) {

                    $sheet->fromArray($avisos);

                });

            })->export('xlsx');
        }
    }
}
