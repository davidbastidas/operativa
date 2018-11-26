<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Faker\Provider\File;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request){

        $this->validate($request,
            [
                'email' => 'email|required|string',
                'password' => 'required|string'
            ]
        );
    }
}
