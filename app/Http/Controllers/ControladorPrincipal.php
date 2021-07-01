<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorPrincipal extends Controller
{
    public function index() {

        $teste = DB::table('teste')->get();

        return view('principal')->with('teste', $teste);

    }
}
