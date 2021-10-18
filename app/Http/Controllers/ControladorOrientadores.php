<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorOrientadores extends Controller
{
    public function listarAdvisors(Request $req) {

        $advisors = DB::table('app_advisors as ad')
                    ->select('ad.id as id_advisor', 'au.*')
                    ->leftjoin('app_users as au', 'au.id', 'ad.id_user')
                    ->get();

        return response()->json(['data' => $advisors], 200);
    }
}
