<?php

namespace App\Http\Controllers;

use App\AdminTable;
use App\Agenda;
use App\Anomalias;
use App\Avisos;
use App\AvisosTemp;
use App\Delegacion;
use App\EntidadesPagos;
use App\ObservacionesRapidas;
use App\Resultados;
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

            $pendientes = Avisos::where('estado', 1)->where('agenda_id', $agenda->id)->count();
            $realizados = Avisos::where('estado', 2)->where('agenda_id', $agenda->id)->count();
            $cargasPendientes = AvisosTemp::where('agenda_id', $agenda->id)->count();

            $flag = false;

            if ($pendientes > 0){
                $flag = true;
            }

            array_push($array, (object)array(
                'id' => $agenda->id,
                'codigo' => $agenda->codigo,
                'fecha' => $agenda->fecha,
                'delegacion' => $agenda->delegacion_id,
                'usuario' => $user,
                'pendientes' => $pendientes,
                'realizados' => $realizados,
                'cargasPendientes' => $cargasPendientes,
                'flag' => $flag
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
        $agenda->fecha = $request->fecha;
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
            foreach ($row as $x => $x_value) {
            	$base = [];
            	$count = 0;
            	foreach ($x_value as $y => $y_value) {
	                $base[$count] = $y_value;
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
        }
        return \Redirect::route('agenda');
    }

    //Asignar Avisos INDEX
    public function listaAvisosIndex($agenda)
    {
        $id = Session::get('adminId');
        $name = Session::get('adminName');

        $gestores = AvisosTemp::select('gestor')->where('agenda_id', $agenda)->groupBy('gestor')->get();
        $usuarios = Usuarios::all();
        $agendaModel = Agenda::find($agenda);

        $perPage = 10;
        $page = Input::get('page');
        $pageName = 'page';
        $page = Paginator::resolveCurrentPage($pageName);
        $offSet = ($page * $perPage) - $perPage;

        $avisos = Avisos::where('agenda_id', $agenda)->offset($offSet)->limit($perPage)->orderByDesc('gestor_id')->get();

        $total_registros = Avisos::where('agenda_id', $agenda)->count();

        $posts = new LengthAwarePaginator($avisos, $total_registros, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);

        return view('admin.asignar', [
            'id' => $id,
            'name' => $name,
            'gestores' => $gestores,
            'usuarios' => $usuarios,
            'agenda' => $agenda,
            'agendaModel' => $agendaModel,
            'avisos' => $posts
        ]);
    }

    //Asignar Avisos
    public function cargarAvisos(Request $request)
    {
        $id = Session::get('adminId');
        $agenda = Agenda::find($request->agenda);
        $gestor = $request->gestor;
        $user = $request->user;

        $avisos = AvisosTemp::where('gestor', $gestor)->where('agenda_id', $agenda->id)->get();

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
            $av->delegacion_id = $agenda->delegacion_id;
            $av->orden_realizado = 0;
            $av->estado = 1;
            $av->gestor_id = $user;
            $av->admin_id = $id;
            $av->agenda_id = $agenda->id;

            try {
                $av->save();
                $aviso->delete();
            } catch (\Exception $e) {
                return $e;
            }
        }

        return redirect()->route('asignar.avisos', ['agenda' => $agenda]);
    }

    //Asignar todos los avisos
    public function asignarAllAvisos(Request $request)
    {
        $id = Session::get('adminId');
        $agenda = Agenda::find($request->agenda);
        $gestoresTemp = AvisosTemp::select('gestor')->where('agenda_id', $agenda->id)->groupBy('gestor')->get();
        foreach ($gestoresTemp as $ges) {
          $gestor = explode(" ", $ges->gestor);
          $cedula = trim($gestor[0]);
          $avisosTemp = AvisosTemp::where('gestor', $ges->gestor)->where('agenda_id', $agenda->id)->get();
          $usuario = Usuarios::where('nickname', $cedula)->first();
          foreach ($avisosTemp as $aviso) {
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
            $av->delegacion_id = $agenda->delegacion_id;
            $av->orden_realizado = 0;
            $av->estado = 1;
            $av->gestor_id = $usuario->id;
            $av->admin_id = $id;
            $av->agenda_id = $agenda->id;

            try {
                $av->save();
            } catch (\Exception $e) {
              return $e;
            } finally {
              $avisoExiste = Avisos::where('id', $aviso->id)->first();
              if(isset($avisoExiste->id)){
                $aviso->delete();
              }
            }
          }
        }
        return redirect()->route('asignar.avisos', ['agenda' => $agenda]);
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
        $avisos = AvisosTemp::where('admin_id', $id)->where('agenda_id', $request->agenda)->delete();

        $id = Session::get('adminId');
        $name = Session::get('adminName');

        return redirect()->route('asignar.avisos', ['agenda' => $request->agenda]);
    }

    public function deleteAgenda($agenga)
    {
        Agenda::where('id', $agenga)->delete();
        return \Redirect::route('agenda');
    }

    public function editarAviso($id){
        $aviso = Avisos::where('id', $id)->first();
        $resultados = Resultados::all();
        $anomalias = Anomalias::all();
        $recaudos = EntidadesPagos::all();
        $observaciones = ObservacionesRapidas::all();

        $filename = $aviso->id . ".png";

        $path = config('myconfig.public_fotos')  . $filename;

        $id = Session::get('adminId');
        $name = Session::get('adminName');

        return view('admin.editar', [
            'aviso' => $aviso,
            'id' => $id,
            'name' => $name,
            'resultados' => $resultados,
            'anomalias' => $anomalias,
            'recaudos' => $recaudos,
            'observaciones' => $observaciones,
            'path' => $path
        ]);
    }

    public function saveAviso(Request $request){

        $aviso = Avisos::where('id', $request->aviso_id)->first();

        $aviso->resultado_id = $request->resultado;
        $aviso->anomalia_id = $request->anomalia;
        $aviso->entidad_recaudo_id = $request->recaudo;
        $aviso->fecha_pago = $request->fecha_pago;
        $aviso->persona_contacto = $request->atiende;
        $aviso->cedula = $request->cedula;
        $aviso->titular_pago = $request->titular;
        $aviso->telefono = $request->telefono;
        $aviso->correo_electronico = $request->correo_electronico;
        $aviso->lectura = $request->lectura;
        $aviso->observacion_rapida = $request->observacion;
        $aviso->observacion_analisis = $request->observacion_analisis;
        $aviso->estado = 3;

        $aviso->update();

        return redirect()->route('asignar.avisos', ['id' => $aviso->agenda_id]);
    }


    public function deleteAviso($aviso){

        $agenda_id = Avisos::where('id', $aviso)->first()->agenda_id;

        Avisos::where('id', $aviso)->where('estado', 1)->delete();

        return redirect()->route('asignar.avisos', ['id' => $agenda_id]);
    }

    public function visitaMapa() {
        $id = Session::get('adminId');
        $name = Session::get('adminName');

        $usuarios = Usuarios::orderBy('nombre')->get();

        return view('admin.mapas', [
            'id' => $id,
            'name' => $name,
            'usuarios' => $usuarios
        ]);
    }

    public function getPointMapVisita(Request $request){
      $agendas = Agenda::where('fecha', 'LIKE', DB::raw("'%$request->fecha%'"))->get();
      $arrayAgendas = [];
      $count = 0;
      $stringIn = '';
      foreach ($agendas as $agenda) {
        $arrayAgendas[] = $agenda->id;
        if($count == 0){
          $stringIn = $agenda->id;
          $count++;
        } else {
          $stringIn .= ',' . $agenda->id;
        }
      }

      $puntos = [];
      if(count($arrayAgendas) > 0){
        $puntos = Avisos::whereIn('agenda_id', $arrayAgendas)
                          ->where('gestor_id', $request->gestor_id)
                          ->where('estado', '>', 1)
                          ->where('latitud', '!=', '0.0')
                          ->orderBy('orden_realizado')->get();
      }

      return response()->json([
        'puntos' => $puntos
      ]);
    }
}
