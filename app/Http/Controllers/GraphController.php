<?php

namespace App\Http\Controllers;

use App\Festivos;
use App\Sent;
use App\TimeResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Sodium\add;

class GraphController extends Controller
{
    public function index()
    {
        $id = Session::get('adminId');
        $pendientes = Sent::where('estado', 'P')->count();

        return view('admin.graph', [
            'id' => $id,
            'pendientes' => $pendientes,
        ]);
    }

    public function getTotalesDashboard()
    {
        Carbon::setLocale('co');
        $date = Carbon::now();

        $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
            'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $mes = $meses[$date->month - 1];

        $arrayPrincipal = [];
        $datasets = [];

        $optimos = TimeResponse::where(DB::raw('BINARY response_time'), '=', DB::raw("BINARY " . "'Optimo'"))
            ->count();

        $buenos = TimeResponse::where(DB::raw('BINARY response_time'), '=', DB::raw("BINARY " . "'Bueno'"))
            ->count();

        $pesimos = TimeResponse::where(DB::raw('BINARY response_time'), '=', DB::raw("BINARY " . "'Pesimo'"))
            ->count();


        array_push($datasets, (object)array(
            "fillColor" => "rgb(195,59,35)",
            "data" => [
                "$optimos"
            ],
            "highlightStroke" => "rgb(195,59,35)",
            "label" => "Optimo",
            "strokeColor" => "rgb(195,59,35)",
            "highlightFill" => "rgb(195,59,35)"
        ));

        array_push($datasets, (object)array(
            "fillColor" => "rgb(195,59,35)",
            "data" => [
                "$buenos"
            ],
            "highlightStroke" => "rgb(195,59,35)",
            "label" => "Bueno",
            "strokeColor" => "rgb(195,59,35)",
            "highlightFill" => "rgb(195,59,35)"
        ));

        array_push($datasets, (object)array(
            "fillColor" => "rgb(195,59,35)",
            "data" => [
                "$pesimos"
            ],
            "highlightStroke" => "rgb(195,59,35)",
            "label" => "Pesimo",
            "strokeColor" => "rgb(195,59,35)",
            "highlightFill" => "rgb(195,59,35)"
        ));


        array_push($arrayPrincipal, (object)array(
            'datasets' => $datasets,
            "labels" => [$mes]
        ));

        return $arrayPrincipal;
    }


    public function getCiudades()
    {
        $array = [];
        $datasets = [];

        $sents = Sent::select(
            DB::raw('ciudad'),
            DB::raw('count(0) AS total')
        )
            ->from('sents')
            ->groupBy('ciudad')
            ->orderByDesc('total')
            ->get();

        foreach ($sents as $sent) {
            array_push($array, (object)array(
                "fillColor" => "rgb(195,59,35)",
                "data" => [
                    "$sent->total"
                ],
                "highlightStroke" => "rgb(195,59,35)",
                "label" => "$sent->ciudad",
                "strokeColor" => "rgb(195,59,35)",
                "highlightFill" => "rgb(195,59,35)"
            ));
        }

        array_push($datasets, (object)array(
            "datasets" => $array,
            "sents" => $sents
        ));

        return $datasets;
    }

    public function getFiveDays($fecha, $numDias)
    {
        $festivos = Festivos::all();
        $fechaCarbon = Carbon::createFromFormat('Y-m-d', $fecha);
        $fechaCarbon2 = Carbon::createFromFormat('Y-m-d', $fecha);

        $dias = $this->getDaysHabiles($fechaCarbon, $festivos, $numDias);

        $dateFinal = $this->calcularFechaHabilLaboral($festivos, $fechaCarbon2->addDays($numDias + $dias));;

        $fechaOriginal = explode('-', $fecha)['2'];
        $fechaFinal = explode('-', explode(' ', $dateFinal."")['0'])['2'];
        $operacion = null;

        if ($fechaOriginal > $fechaFinal){
            $operacion = $fechaOriginal - $fechaFinal;
        }else{
            $operacion = $fechaFinal - $fechaOriginal;
        }
        return $operacion;
    }

    public function getDaysHabiles($fechaCarbon, $festivos, $numDias)
    {
        $contF = null;
        $contS = null;
        $contD = null;

        for ($i = 0; $i < $numDias; $i++) {
            $date = $fechaCarbon->addDays(1);

            foreach ($festivos as $festivo) {
                $diaF = $festivo->dia;
                $diaC = $date->day;
                $mesF = $festivo->mes;
                $mesC = $date->month;
                $anoF = $festivo->anio;
                $anoC = $date->year;

                if ($diaF == $diaC && $mesF == $mesC && $anoF == $anoC) {
                    $contF++;
                    break;
                } else if ($fechaCarbon->shortEnglishDayOfWeek == 'Sat') {
                    $contS++;
                    break;
                } else if ($fechaCarbon->shortEnglishDayOfWeek == 'Sun') {
                    $contD++;
                    break;
                }
            }

        }

        $countF = $contF + $contS + $contD;

        return $countF;
    }

    public function calcularFechaHabilLaboral($festivos, $fechaCarbon)
    {
        foreach ($festivos as $festivo) {
            if ($festivo->dia == $fechaCarbon->day && $festivo->mes == $fechaCarbon->month && $festivo->anio == $fechaCarbon->year) {
                $fechaCarbon = $fechaCarbon->addDays(1);
                $fechaCarbon = $this->calcularFechaHabilLaboral($festivos, $fechaCarbon);
                break;
            } else if ($fechaCarbon->shortEnglishDayOfWeek == 'Sat') {
                $fechaCarbon = $fechaCarbon->addDays(2);
                $fechaCarbon = $this->calcularFechaHabilLaboral($festivos, $fechaCarbon);
                break;
            } else if ($fechaCarbon->shortEnglishDayOfWeek == 'Sun') {
                $fechaCarbon = $fechaCarbon->addDays(1);
                $fechaCarbon = $this->calcularFechaHabilLaboral($festivos, $fechaCarbon);
                break;
            }
        }
        return $fechaCarbon;
    }

}


