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
        
        $tcc = DB::table('app_tcc')->where('id_user', $req->id_user)->get();

        if (empty($tcc[0])) {

            return response()->json(['message' => 'Este usuário não possui TCC'], 400);

        } else {

            return response()->json(['data' => $tcc], 200);

        }
    }

    public function novoTcc(Request $req) {

        if (!isset($req->id_user)) {
            return response()->json(['message' => 'ID do usuário não enviado.'], 400);
        } else if (!isset($req->id_category)) {
            return response()->json(['message' => 'ID da categoria não enviado.'], 400);
        } else if (!isset($req->name)) {
            return response()->json(['message' => 'Nome do TCC não enviado.'], 400);
        } else if (!isset($req->area)) {
            return response()->json(['message' => 'Área do TCC não enviado.'], 400);
        } else if (!isset($req->description)) {
            return response()->json(['message' => 'Descrição do TCC não enviado.'], 400);
        } else if (!isset($req->logo)) {
            return response()->json(['message' => 'Logo do TCC não enviado.'], 400);
        } else if (!isset($req->id_advisor)) {
            return response()->json(['message' => 'Orientador do TCC não enviado.'], 400);
        }

        $user = ControladorTCC::getUserById($req->id_user);

        try {
            \DB::beginTransaction();

            \DB::table('app_tcc')->insert([
                'id_user' => $req->id_user,
                'id_advisor' => $req->id_advisor,
                'id_category' => $req->id_category,
                'name' => $req->name,
                'area' => $req->area,
                'description' => $req->description,
                'logo' => $req->logo,
                'user_add' => $user,
            ]);
            
            \DB::commit();

            return response()->json(['message' => 'TCC criado com sucesso!'], 201);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }

    public function updateTcc(Request $req) {

        if (!isset($req->id_user)) {
            return response()->json(['message' => 'ID do usuário não enviado.'], 400);
        } else if (!isset($req->id_category)) {
            return response()->json(['message' => 'ID da categoria não enviado.'], 400);
        } else if (!isset($req->name)) {
            return response()->json(['message' => 'Nome do TCC não enviado.'], 400);
        } else if (!isset($req->area)) {
            return response()->json(['message' => 'Área do TCC não enviado.'], 400);
        } else if (!isset($req->description)) {
            return response()->json(['message' => 'Descrição do TCC não enviado.'], 400);
        } else if (!isset($req->logo)) {
            return response()->json(['message' => 'Logo do TCC não enviado.'], 400);
        } else if (!isset($req->id_advisor)) {
            return response()->json(['message' => 'Orientador do TCC não enviado.'], 400);
        } else if (!isset($req->id)) {
            return response()->json(['message' => 'ID do TCC não enviado.'], 400);
        }

        $user = ControladorTCC::getUserById($req->id_user);

        $tcc = \DB::table('app_tcc')->where('id', $req->id)->get();

        if (empty($tcc[0])) {

            return response()->json(['message' => 'TCC não existe.'], 404);

        }

        try {
            \DB::beginTransaction();

            \DB::table('app_tcc')->where('id', $req->id)->update([
                'id_user' => $req->id_user,
                'id_advisor' => $req->id_advisor,
                'id_category' => $req->id_category,
                'name' => $req->name,
                'area' => $req->area,
                'description' => $req->description,
                'logo' => $req->logo,
                'user_update' => $user,
                'date_update' => now()
            ]);
            
            \DB::commit();

            return response()->json(['message' => 'TCC alterado com sucesso!'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }

    public function inactivateTcc(Request $req) {

        if (!isset($req->id_tcc)) {
            return response()->json(['message' => 'ID do TCC não enviado.'], 400);
        }

        $user = ControladorTCC::getUserById($req->id_user);

        $tcc = \DB::table('app_tcc')->where('id', $req->id_tcc)->get();

        if (empty($tcc[0])) {

            return response()->json(['message' => 'TCC não existe.'], 404);

        }

        try {
            \DB::beginTransaction();

            \DB::table('app_tcc')->where('id', $req->id_tcc)->update([
                'status' => 'I',
                'user_update' => $user,
                'date_update' => now()
            ]);
            
            \DB::commit();

            return response()->json(['message' => 'TCC desativado com sucesso!'], 200);
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
