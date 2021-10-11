<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorUsuarios extends Controller
{
    public function listarUsers(Request $req) {

        $users = DB::table('app_users')->get();

        return response()->json(['data' => $users], 200);
    }
}
