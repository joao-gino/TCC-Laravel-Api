<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorTasks extends Controller
{
    public function listarTasks(Request $req) {

        $tasks = DB::table('app_tasks')->where('id_etapa', $req->id_etapa)->get();

        return response()->json($tasks, 200);
    }

    public function getTask(Request $req) {

        $task = DB::table('app_tasks')->where('id_etapa', $req->id_etapa)->where('id', $req->id_task)->get();

        return response()->json($task, 200);
    }

    public function novaTask(Request $req) {

        if (!isset($req->id_etapa)) {
            return response()->json(['message' => 'ID da Etapa não enviado.'], 400);
        } else if (!isset($req->id_status)) {
            return response()->json(['message' => 'ID do Status não enviado.'], 400);
        } else if (!isset($req->nome)) {
            return response()->json(['message' => 'Nome da Task não enviado.'], 400);
        } else if (!isset($req->descricao)) {
            return response()->json(['message' => 'Descrição da Task não enviado.'], 400);
        }

        try {
            \DB::beginTransaction();

            \DB::table('app_tasks')->insert([
                'id_etapa' => $req->id_etapa,
                'id_status' => $req->id_status,
                'nome' => $req->nome,
                'descricao' => $req->descricao
            ]);
            
            \DB::commit();

            $id = \DB::table('app_tasks')->orderBy('id', 'DESC')->first();

            return response()->json(['id' => $id->id, 'message' => 'Task adicionada com sucesso!'], 201);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }

    public function updateTask(Request $req) {

        if (!isset($req->id_etapa)) {
            return response()->json(['message' => 'ID da Etapa não enviado.'], 400);
        } else if (!isset($req->id_status)) {
            return response()->json(['message' => 'ID do Status não enviado.'], 400);
        } else if (!isset($req->nome)) {
            return response()->json(['message' => 'Nome da Task não enviado.'], 400);
        } else if (!isset($req->descricao)) {
            return response()->json(['message' => 'Descrição da Task não enviado.'], 400);
        } else if (!isset($req->id)) {
            return response()->json(['message' => 'ID da Task não enviado.'], 400);
        }

        try {
            \DB::beginTransaction();

            \DB::table('app_tasks')->where('id', $req->id)->update([
                'id_etapa' => $req->id_etapa,
                'id_status' => $req->id_status,
                'nome' => $req->nome,
                'descricao' => $req->descricao
            ]);
            
            \DB::commit();

            return response()->json(['message' => 'Task alterada com sucesso!'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }

    public function deleteTask(Request $req) {

        if (!isset($req->id)) {
            return response()->json(['message' => 'ID da Task não enviado.'], 400);
        }

        try {
            \DB::beginTransaction();

            \DB::table('app_tasks')->where('id', $req->id)->delete();
            
            \DB::commit();

            return response()->json(['message' => 'Task excluída com sucesso!'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return $e;
        }

    }
}
