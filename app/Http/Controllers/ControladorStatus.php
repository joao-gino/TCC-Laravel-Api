<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorStatus extends Controller
{
    public function listarStatus(Request $req) {

        $status = DB::table('app_status_tasks')->get();

        return response()->json($status, 200);
    }
}
