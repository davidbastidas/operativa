<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function showLogin()
  {
    // show the form
    return view('home.login');
  }

  public function doLogin(Request $request)
  {
  // process the form
  }
}
