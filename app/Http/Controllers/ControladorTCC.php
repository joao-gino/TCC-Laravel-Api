<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorTCC extends Controller
{
    public function listarTcc(Request $req) {

        $tccs = DB::table('app_tcc')->get();

        return response()->json(['data' => $tccs], 200);
    }

    public function getTccByUser(Request $req) {
        
        $tcc = DB::table('app_tcc')->where('id_user1', $req->id_user)->whereNotNull('id_user1')->get();

        if (empty($tcc[0])) {
            $tcc = DB::table('app_tcc')->where('id_user2', $req->id_user)->whereNotNull('id_user2')->get();
            if (empty($tcc[0])) {
                $tcc = DB::table('app_tcc')->where('id_user3', $req->id_user)->whereNotNull('id_user3')->get();
                if (empty($tcc[0])) {
                    return response()->json(['message' => 'Usuário não possui TCC', 'data' => $tcc], 200);
                } else {
                    return response()->json(['data' => $tcc], 200);
                }
            } else {
                return response()->json(['data' => $tcc], 200);
            }
        } else {
            return response()->json(['data' => $tcc], 200);
        }
    }

    public function novoTcc(Request $req) {

        if (!isset($req->id_user1)) {
            return response()->json(['message' => 'ID do usuário não enviado.'], 400);
        } else if (!isset($req->id_category)) {
            return response()->json(['message' => 'ID da categoria não enviado.'], 400);
        } else if (!isset($req->name)) {
            return response()->json(['message' => 'Nome do TCC não enviado.'], 400);
        }

        $user = ControladorTCC::getUserById($req->id_user1);

        try {
            \DB::beginTransaction();

            \DB::table('app_tcc')->insert([
                'id_user1' => $req->id_user1,
                'id_category' => $req->id_category,
                'name' => $req->name,
                'user_add' => $user,
            ]);

            \DB::commit();

            return response()->json(['message' => 'TCC criado com sucesso!'], 201);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }

    private function getUserById($id) {

        $user = DB::table('app_users')->select('username')->where('id', $id)->get();

        return $user[0]->username;
    }
}
