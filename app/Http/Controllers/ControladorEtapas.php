<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorEtapas extends Controller
{
    public function listarEtapas(Request $req) {

        $etapas = DB::table('app_etapas')->select('id', 'nome')->where('id_tcc', $req->id_tcc)->get();

        return response()->json(['data' => $etapas], 200);
    }

    public function novaEtapa(Request $req) {

        if (!isset($req->id_tcc)) {
            return response()->json(['message' => 'ID do TCC não enviado.'], 400);
        } else if (!isset($req->nome)) {
            return response()->json(['message' => 'Nome da etapa não enviado.'], 400);
        }

        try {
            \DB::beginTransaction();

            \DB::table('app_etapas')->insert([
                'id_tcc' => $req->id_tcc,
                'nome' => $req->nome
            ]);
            
            \DB::commit();

            return response()->json(['message' => 'Etapa adicionada com sucesso!'], 201);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }

    public function updateEtapa(Request $req) {

        if (!isset($req->id)) {
            return response()->json(['message' => 'ID da Etapa não enviado.'], 400);
        } else if (!isset($req->nome)) {
            return response()->json(['message' => 'Nome da etapa não enviado.'], 400);
        }

        try {
            \DB::beginTransaction();

            \DB::table('app_etapas')->where('id', $req->id)->update([
                'nome' => $req->nome
            ]);
            
            \DB::commit();

            return response()->json(['message' => 'Etapa alterada com sucesso!'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }

    public function deleteEtapa(Request $req) {

        if (!isset($req->id)) {
            return response()->json(['message' => 'ID da Etapa não enviado.'], 400);
        }

        try {
            \DB::beginTransaction();

            \DB::table('app_etapas')->where('id', $req->id)->delete();
            
            \DB::commit();

            return response()->json(['message' => 'Etapa excluída com sucesso!'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }
}
