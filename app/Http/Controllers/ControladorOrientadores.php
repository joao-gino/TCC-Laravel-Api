<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorOrientadores extends Controller
{
    public function listarAdvisors(Request $req) {

        $advisors = DB::table('app_advisors')->leftjoin('app_users', 'app_users.id', 'app_advisors.id_user')->get();

        return response()->json(['data' => $advisors], 200);
    }
}
