<?php

namespace App\Http\Controllers;

use App\AdminTable;
use App\Agenda;
use App\Avisos;
use App\AvisosTemp;
use App\Delegacion;
use App\Usuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;


class AvisosController extends Controller
{

    public function index()
    {
        $id = Session::get('adminId');
        $name = Session::get('adminName');

        $totalAvisos = Avisos::all()->count();
        $delegaciones = Delegacion::all();

        $perPage = 10;
        $page = Input::get('page');
        $pageName = 'page';
        $page = Paginator::resolveCurrentPage($pageName);
        $offSet = ($page * $perPage) - $perPage;

        $agenda = new Agenda();

        $agendas = $agenda->offset($offSet)->limit($perPage)->orderByDesc('id')->get();

        $total_registros = Agenda::all()->count();
        $array = [];
        $agendaCollection = null;

        foreach ($agendas as $agenda) {

            $user = AdminTable::where('id', $agenda->admin_id)->first()->name;

            $pendientes = Avisos::where('estado', 1)->where('agenda_id', $agenda->id)->get()->count();
            $realizados = Avisos::where('estado', 2)->where('agenda_id', $agenda->id)->get()->count();

            array_push($array, (object)array(
                'id' => $agenda->id,
                'codigo' => $agenda->codigo,
                'fecha' => $agenda->fecha,
                'delegacion' => $agenda->delegacion_id,
                'usuario' => $user,
                'pendientes' => $pendientes,
                'realizados' => $realizados
            ));
        }

        $agendaCollection = new Collection($array);


        $posts = new LengthAwarePaginator($agendaCollection, $total_registros, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);

        return view('admin.agenda',
            [
                'id' => $id,
                'name' => $name,
                'totalAvisos' => $totalAvisos,
                'delegaciones' => $delegaciones,
                'agendas' => $posts
            ])->withPosts($posts);
    }

    public function saveAgenda(Request $request)
    {

        $agenda = new Agenda();
        $fechaFormat = Carbon::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d') . ' 00:00:00';
        $agenda->fecha = $fechaFormat;
        $agenda->delegacion_id = $request->delegacion;
        $agenda->admin_id = Session::get('adminId');

        $agenda->save();

        $anio = Carbon::now()->year;

        $agenda->codigo = "AGE-" . $agenda->id . "-" . $anio;

        $agenda->save();

        return redirect()->route('agenda');
    }

    public function subirAvisos(Request $request)
    {
        $archivo = $request->file;
        $agenda = $request->agenda;
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
            $aviso->admin_id = Session::get('adminId');
            $aviso->agenda_id = $agenda;
            $aviso->save();
        }
        return \Redirect::route('agenda');
    }

    //Asignar Avisos INDEX
    public function cargaAvisosIndex($agenda, $delegacion)
    {
        $id = Session::get('adminId');
        $name = Session::get('adminName');

        $gestores = AvisosTemp::select('gestor')->where('agenda_id', $agenda)->groupBy('gestor')->get();
        $usuarios = Usuarios::all();

        return view('admin.asignar', [
            'id' => $id,
            'name' => $name,
            'gestores' => $gestores,
            'usuarios' => $usuarios,
            'agenda' => $agenda,
            'delegacion' => $delegacion
        ]);
    }

    //Asignar Avisos
    public function cargarAvisos(Request $request)
    {
        $id = Session::get('adminId');
        $agenda = $request->agenda;
        $delegacion_id = $request->delegacion;
        $gestor = $request->gestor;
        $user = $request->user;

        $avisos = AvisosTemp::where('gestor', $gestor)->where('agenda_id', $agenda)->get();

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
            $av->agenda_id = $agenda;

            try {
                $av->save();
                $aviso->delete();
            } catch (\Exception $e) {
                return $e;
            }
        }

        return redirect()->route('asignar.avisos', ['agenda' => $agenda, 'delegacion' => $delegacion_id]);
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
        $avisos = AvisosTemp::where('admin_id', $id)->delete();

        $id = Session::get('adminId');
        $name = Session::get('adminName');

        return \Redirect::route('carga.avisos');
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
