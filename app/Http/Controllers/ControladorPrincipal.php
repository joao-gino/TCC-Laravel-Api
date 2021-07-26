<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorPrincipal extends Controller
{
    public function index() {

        $teste = DB::table('app_users')->get();

        //$teste = json_encode($teste);

        //$teste = trim($teste, '[]');

        //var_dump($teste);

        return response()->json(['data' => $teste], 200);
    }
}
