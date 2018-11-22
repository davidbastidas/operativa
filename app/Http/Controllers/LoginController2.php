<?php

namespace App\Http\Controllers;

use App\User;
use App\Usuario;
use Illuminate\Http\Request;

class LoginController2 extends Controller
{
    function getData()
    {
        header('Access-Control-Allow-Credentials', 'true');
        header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
        header('Access-Control-Allow-Origin', '*');
        return " {\"id\": \"Find\", \"label\": \"Find\"}";
    }

    function login(Request $request)
    {
        $usario = Usuario::all();

        $mail = $request->get('email');
        $pass = $request->get('password');

        $array = [
            'mail' => $mail,
            'pass' => $pass
        ];
        $json = json_encode($array);

        return $usario;
    }
}
