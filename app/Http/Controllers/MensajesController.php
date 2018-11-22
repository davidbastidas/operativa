<?php

namespace App\Http\Controllers;

use App\Received;
use App\Sent;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class MensajesController extends Controller
{
    public function sendMensajeToServer(Request $request)
    {
        $pais = null;
        $depa = null;
        $ciudad = null;
        $dir = null;

        if ($request->userlocation != ""){
            $location = explode(',', $request->userlocation);
            $pais = $location[0];
            $depa = $location[1];
            $ciudad = $location[2];
            $dir = $location[3];
        }

        $sent = new Sent();

        $sent->id_user = $request->idUser;
        $sent->nombre = $request->nombre;
        $sent->asunto = $request->asunto;
        $sent->contenido = $request->contenido;
        $sent->remitente = $request->remitente;
        $sent->pais = $pais;
        $sent->departamento = $depa;
        $sent->ciudad = $ciudad;
        $sent->direccion = $dir;
        $sent->estado = 'P';

        $sent->save();
    }

    public function sendMensajeToClient(Request $request)
    {
        $id = Session::get('adminId');

        $received = new Received();
        $received->id_user = $request->idUser;
        $received->usuario = $request->nombre;
        $received->asunto = $request->asunto;
        $received->pregunta = $request->pregunta;
        $received->contenido = $request->contenido;
        $received->destinatario = $request->destinatario;
        $received->id_sent = $request->idSent;
        $received->user_response = $id;
        $received->estado = 'P';

        $received->save();

        $sent = Sent::find($request->idSent);

        $sent->estado = 'R';
        $sent->save();


        return \Redirect::route('admin.dashboard', $id);
    }

    public function getMensajes(Request $request)
    {
        $receiveds = Received::where('estado', 'P')
            ->where('id_user', $request->idUser)
            ->get();

        $arrayMsg = [];
        $collection = null;
        $count = 0;

        foreach ($receiveds as $received) {
            array_push($arrayMsg, (object)array(
                'id' => $received->id,
                'asunto' => $received->asunto,
                'pregunta' => $received->pregunta,
                'contenido' => $received->contenido,
                'id_sent' => $received->id_sent
            ));
            $count++;
        }

        $array = array(
            'totalMsg' => $count,
            'mensajes' => $arrayMsg
        );


        $collection = new Collection($array);
        return $collection;
    }

    public function setViewItem(Request $request){
        $received = Received::where('id', $request->id)->first();
        $received->estado = "R";
        $received->save();

        return $received;
    }
}
