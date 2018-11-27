<?php

namespace App\Http\Controllers;

use App\AdminTable;
use App\Avisos;
use App\Meses;
use App\Received;
use App\Sent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    //login
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $mail = trim($request->email);
            $pass = trim($request->password);

            $flag = $this->validateLogin($mail, $pass);
            if ($flag == 1) {
                $data = $this->getUserData($mail, $pass);
                Session::put('isLogged', 1);
                Session::put('adminId', $data->id);
                Session::put('adminSession', $data['email']);
                Session::put('adminName', $data['name']);
                return \Redirect::route('admin.dashboard', $data->id);
            } else {
                return view('admin.index', ['error' => 'Usuario o Contraseña Invalidos.', 'id' => '']);
            }

        }

        Session::put('isLogged', 0);
        return view('admin.index', ['id' => '']);
    }


    public function dashboard($id)
    {
        if (Session::has('isLogged')) {
            Session::remove('users');
            $data = $this->getUserDataById($id);

            $last50 = DB::table('avisos')
                ->select(DB::raw('usuarios.nombre, avisos.barrio, avisos.fecha_recibido_servidor, avisos.direccion'))
                ->leftJoin('usuarios', 'usuarios.id', '=', 'avisos.gestor_id')
                ->where('avisos.estado', 2)
                ->limit(50)
                ->orderByDesc('avisos.fecha_recibido_servidor')
                ->get();

            return view('admin.panel',
                [
                    'last50' => $last50,
                    'name' => $data->name,
                    'id' => $id,
                ]
            );
        }

        return back()
            ->withErrors(['email' => 'Debe iniciar sesion.'])
            ->withInput(request(['email']));

    }

    public function logout()
    {
        Session::flush();
        return view('admin.index', ['info' => 'Sesion Cerrada Correctamente!', 'id' => '']);
    }


    private function validateLogin($email, $pass)
    {
        $flag = 1;

        $admin = AdminTable::where('email', $email)
            ->where('password', $pass)
            ->get();


        if ($admin->isEmpty()) {
            $flag = 0;
        }

        return $flag;
    }

    private function getUserData($email, $pass)
    {
        $admin = AdminTable::where('email', $email)
            ->where('password', $pass)
            ->first();

        return $admin;
    }

    private function getUserDataById($id)
    {
        $idUser = trim($id);

        $admin = AdminTable::where('id', $idUser)
            ->first();

        return $admin;
    }
}
