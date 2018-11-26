<?php

namespace App\Http\Controllers;

use App\Avisos;
use App\AvisosTemp;
use App\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            foreach ($row as $x => $x_value) {
                $base[$count] = $x_value;
                $count++;
            }
            $aviso = new AvisosTemp();
            $aviso->campana = $base[0];
            $aviso->campana2 = $base[1];
            $aviso->fecha_entrega = $base[2]->format('Y-m-d');
            $aviso->tipo_visita = $base[3];
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

    public function cargaAvisosIndex()
    {
        $id = Session::get('adminId');
        $name = Session::get('adminName');

        $gestores = AvisosTemp::select('gestor')->groupBy('gestor')->get();
        $usuarios = Usuarios::all();

        return view('admin.carga', [
            'id' => $id,
            'name' => $name,
            'gestores' => $gestores,
            'usuarios' => $usuarios
        ]);
    }

    public function cargarAvisos(Request $request)
    {
        $id = Session::get('adminId');
        $gestor = $request->gestor;
        $user = $request->user;

        $avisos = AvisosTemp::where('gestor', $gestor)->get();
        $delegacion_id = Usuarios::where('id', $user)->first()->delegacion_id;

        foreach ($avisos as $aviso) {
            $av = new Avisos();
            $av->id = $aviso->id;
            $av->campana = $aviso->campana;
            $av->campana2 = $aviso->campana2;
            $av->fecha_entrega = $aviso->fecha_entrega;
            $av->tipo_visita = $aviso->tipo_visita;
            $av->municipio = $aviso->municipio;
            $av->localidad = $aviso->localidad;
            $av->barrio = $aviso->barrio;
            $av->direccion = $aviso->direccion;
            $av->cliente = $aviso->cliente;
            $av->deuda = $aviso->deuda;
            $av->factura_vencida = $aviso->factura_vencida;
            $av->nic = $aviso->nic;
            $av->nis = $aviso->nis;
            $av->medidor = $aviso->medidor;
            $av->gestor = $aviso->gestor;
            $av->supervisor = $aviso->supervisor;
            $av->tarifa = $aviso->tarifa;
            $av->compromiso = $aviso->compromiso;
            $av->avisos = $aviso->avisos;
            $av->delegacion_id = $delegacion_id;
            $av->orden_realizado = 0;
            $av->estado = 1;
            $av->gestor_id = $user;
            $av->admin_id = $id;

            try {
                $av->save();
                $aviso->delete();
            } catch (\Exception $e) {
                return $e;
            }
        }

        $name = Session::get('adminName');

        $gestores = AvisosTemp::select('gestor')->groupBy('gestor')->get();
        $usuarios = Usuarios::all();

        return view('admin.carga', [
            'success' => 'Gestores Asignados Correctamente!',
            'id' => $id,
            'name' => $name,
            'gestores' => $gestores,
            'usuarios' => $usuarios
        ]);
    }

    public function getAvisos()
    {
        $id = Session::get('adminId');

        $avisos = AvisosTemp::where('admin_id', DB::raw($id))->get();

        return response()->json([
            'data' => $avisos
        ]);
    }

    public function vaciarCarga(Request $request)
    {
        $id = Session::get('adminId');
        $avisos = AvisosTemp::where('admin_id', $id)->get();

        $avisos->delete();

        $id = Session::get('adminId');
        $name = Session::get('adminName');

        return view('admin.vaciarcarga', [
            'success' => 'Carga Vaciada Completamente!',
            'id' => $id,
            'name' => $name
        ]);
    }

    public function getIndicadores(Request $request)
    {
        $avisosPendientes = Avisos::where('estado', 1)
            ->where('fecha_entrega', 'LIKE', DB::raw("'%$request->fecha%'"))
            ->count();

        $avisosRealizados = Avisos::where('estado', 2)
            ->where('fecha_entrega', 'LIKE', DB::raw("'%$request->fecha%'"))
            ->count();

        return response()->json([
            'pendientes' => $avisosPendientes,
            'realizados' => $avisosRealizados
        ]);
    }
}
