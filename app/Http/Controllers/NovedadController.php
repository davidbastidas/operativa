<?php

namespace App\Http\Controllers;

use App\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NovedadController extends Controller

{


    public function saveNovedad(Request $request)
    {

        $novedad = new Novedad();

        $novedad->nombre = $request->nombre;
        $novedad->asunto = $request->asunto;
        $novedad->contenido = $request->contenido;
        $novedad->remitente = $request->remitente;
        $novedad->destinatario = "jsarmientop.inca@gmail.com";

        $novedad->save();

        $data = [];
        $collection = null;

        array_push($data, (object)array(
            'name' => $request->nombre,
            'mail' => $request->remitente,
            'asunto' => $request->asunto,
            'novedad' => $request->contenido,
        ));

        $collection = new Collection($data);

        $this->sendMail($request->nombre, $request->remitente, $request->asunto, $request->contenido, $collection->get(0));

        return "{\"status\":\"send\"}";

    }

    public function sendMail($nombre, $remitente, $asunto, $contenido, $collection)
    {
        Mail::send('emails.mensaje-enviado', [
            'name' => $nombre,
            'mail' => $remitente,
            'asunto' => $asunto,
            'novedad' => $contenido
        ], function ($message) use ($collection) {
            $noreply = "noreply@transitocurumani.com";
            $pqr = "pqr@ettcurumani.com";
            //$message->from($collection->mail, $collection->name);
            $message->from($noreply, 'Transito Curumaní');
            //tramites@ettcurumani.com

            $message->to($pqr)
                ->subject('Novedad ' . $collection->asunto);
        });
    }
}
