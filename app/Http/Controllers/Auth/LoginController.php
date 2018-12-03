<?php

namespace App\Http\Controllers\Auth;

use App\AdminTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
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
        return redirect('/');
    }
}
