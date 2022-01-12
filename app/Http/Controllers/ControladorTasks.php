<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorTasks extends Controller
{
    public function listarTasks(Request $req) {

        $req['id_etapa'] = $req->id_etapa;

        $rules = [
            'id_etapa' => 'required'
        ];

        $msg = [ 
            'id_etapa.required' => 'ID da Etapa não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        }

        $users = DB::table('app_etapas')
                    ->leftjoin('app_tcc', 'app_etapas.id_tcc', '=', 'app_tcc.id')
                    ->leftjoin('app_tcc_users', 'app_tcc.id', '=', 'app_tcc_users.id_tcc')
                    ->leftjoin('app_users', 'app_tcc_users.id_user', '=', 'app_users.id')
                    ->select('app_users.*')
                    ->where('app_etapas.id', $req->id_etapa)->get();

        $tasks = DB::table('app_tasks')->where('id_etapa', $req->id_etapa)->get();

        return response()->json(['tasks' => $tasks, 'users' => $users], 200);
    }

    public function getTask(Request $req) {

        $req['id_etapa'] = $req->id_etapa;
        $req['id_task'] = $req->id_task;

        $rules = [
            'id_etapa' => 'required',
            'id_task' => 'required'
        ];

        $msg = [ 
            'id_etapa.required' => 'ID da Etapa não enviado.',
            'id_task.required' => 'ID do Status não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        }

        $task = DB::table('app_tasks')->where('id_etapa', $req->id_etapa)->where('id', $req->id_task)->get();

        return response()->json($task, 200);
    }

    public function novaTask(Request $req) {

        $rules = [
            'id_etapa' => 'required',
            'id_status' => 'required',
            'nome' => 'required',
            'descricao' => 'required'
        ];

        $msg = [ 
            'id_etapa.required' => 'ID da Etapa não enviado.',
            'id_status.required' => 'ID do Status não enviado.',
            'nome.required' => 'Nome da Task não enviado.',
            'descricao.required' => 'Descrição da Task não enviado.',
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
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

        $rules = [
            'id_etapa' => 'required',
            'id_status' => 'required',
            'nome' => 'required',
            'descricao' => 'required',
            'id' => 'required'
        ];

        $msg = [ 
            'id_etapa.required' => 'ID da Etapa não enviado.',
            'id_status.required' => 'ID do Status não enviado.',
            'nome.required' => 'Nome da Task não enviado.',
            'descricao.required' => 'Descrição da Task não enviado.',
            'id.required' => 'Id da Task não enviado.',
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
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

        $rules = [
            'id' => 'required'
        ];

        $msg = [ 
            'id.required' => 'ID da Task não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
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
