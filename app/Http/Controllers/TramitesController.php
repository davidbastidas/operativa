<?php

namespace App\Http\Controllers;

use App\TramitesDocumentos;
use Illuminate\Http\Request;

class TramitesController extends Controller
{
    public function index()
    {

    }

    public function getRequisitos(Request $request)
    {
        $requisitos = TramitesDocumentos::where('id_tramite', $request->id)
            ->orderBy('id')
            ->get();

        $array = [];

        foreach ($requisitos as $item) {
            array_push($array, (object)array(
                'nombre' => $item->documento->nombre
            ));
        }


        return $array;
    }
}
