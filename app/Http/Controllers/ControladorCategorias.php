<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorCategorias extends Controller
{
    public function listarCategories(Request $req) {

        $categories = DB::table('app_categories')->get();

        return response()->json(['data' => $categories], 200);
    }
}
