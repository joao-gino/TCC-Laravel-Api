<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorEtapas extends Controller
{
    public function listarEtapas(Request $req) {

        $etapas = DB::table('app_etapas')->select('id', 'nome')->get();

        return response()->json(['data' => $etapas], 200);
    }

    public function getEtapas(Request $req) {

        $req['id_tcc'] = $req->id_tcc;
        
        $rules = [
            'id_tcc' => 'required'
        ];

        $msg = [ 
            'id_tcc.required' => 'ID do TCC não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        }

        $etapas = DB::table('app_etapas')->select('id', 'nome')->where('id_tcc', $req->id_tcc)->get();

        return response()->json(['data' => $etapas], 200);
    }

    public function novaEtapa(Request $req) {

        $rules = [
            'id_tcc' => 'required',
            'nome' => 'required'
        ];

        $msg = [ 
            'id_tcc.required' => 'ID do TCC não enviado.',
            'nome.required' => 'Nome da etapa não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
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

        $rules = [
            'id' => 'required',
            'id_tcc' => 'required',
            'nome' => 'required'
        ];

        $msg = [ 
            'id.required' => 'ID da Etapa não enviado',
            'id_tcc.required' => 'ID do TCC não enviado.',
            'nome.required' => 'Nome da etapa não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
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

        $rules = [
            'id' => 'required'
        ];

        $msg = [ 
            'id.required' => 'ID da Etapa não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
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
