<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorOrientadores extends Controller
{
    public function listarAdvisors(Request $req) {

        $advisors = DB::table('app_advisors')->get();

        return response()->json(['data' => $advisors], 200);
    }
}
