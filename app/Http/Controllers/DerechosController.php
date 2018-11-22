<?php

namespace App\Http\Controllers;

use App\Coactivo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DerechosController extends Controller
{
    public function getDerechos(Request $request)
    {

        $coactivo = null;

        $placa_cedula = $request->placa_cedula;
        $array = [];
        $arrayFINAL = [];
        $collectionCoactivos = null;

        $totalFINAL = null;

        if (strlen($placa_cedula) <=6 ){
            $placa = $placa_cedula;

            $coactivo = Coactivo::where('placa', $placa)->get();

            foreach ($coactivo as $coa) {

                array_push($array, (object)array(
                    'ano' => $coa->ano,
                    'valor_dt' => number_format($coa->valor_dt, 0, ".", "."),
                    'intereses' => number_format($coa->intereses, 0, ".", "."),
                    'sistematizacion' => number_format($coa->sistematizacion, 0, ".", "."),
                    'honorarios' => number_format($coa->honorarios, 0, ".", "."),
                    'total' => number_format($coa->total, 0, ".", ".")
                ));
                $totalFINAL = $totalFINAL + $coa->total;
            }

            array_push($arrayFINAL, (object)array(
                'data' => $array,
                'totalFINAL' => number_format($totalFINAL, 0, ".", ".")
            ));

            $collectionCoactivos = new Collection($arrayFINAL);
        }

        if (strlen($placa_cedula) >6 ){
            $cedula = $request->placa_cedula;

            $coactivo = Coactivo::where('documento', $cedula)->get();

            foreach ($coactivo as $coa) {

                array_push($array, (object)array(
                    'ano' => $coa->ano,
                    'valor_dt' => number_format($coa->valor_dt, 0, ".", "."),
                    'intereses' => number_format($coa->intereses, 0, ".", "."),
                    'sistematizacion' => number_format($coa->sistematizacion, 0, ".", "."),
                    'honorarios' => number_format($coa->honorarios, 0, ".", "."),
                    'total' => number_format($coa->total, 0, ".", ".")
                ));
                $totalFINAL = $totalFINAL + $coa->total;
            }

            array_push($arrayFINAL, (object)array(
                'data' => $array,
                'totalFINAL' => number_format($totalFINAL, 0, ".", ".")
            ));

            $collectionCoactivos = new Collection($arrayFINAL);
        }

        return $collectionCoactivos;
    }
}
