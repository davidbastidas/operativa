<?php

namespace App\Http\Controllers;

use App\AdminTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['only' => 'login']);
    }

    public function login()
    {
        $credentials = $this->validate(request(),
            [
                'email' => 'email|required|string',
                'password' => 'required|string'
            ]
        );

        $user = AdminTable::where('email', $credentials['email'])->first();

        if (Auth::attempt($credentials)) {
            Session::put('isLogged', 1);
            Session::put('adminId', $user->id);
            Session::put('adminSession', $user->email);
            Session::put('adminName', $user->name);
            return redirect()->route('admin.dashboard', $user->id);
        }

        return back()
            ->withErrors(['email' => 'Estas credenciales no concuerdan con nuestros registros.'])
            ->withInput(request(['email']));
    }

    public function logout()
    {
        Session::flush();
        Session::remove('isLogged');
        Session::remove('adminId');
        Session::remove('adminSession');
        Session::remove('adminName');
        return redirect('/');
    }
}
