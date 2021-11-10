<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorTCC extends Controller
{
    public function listarTcc(Request $req) {

        $tccs = DB::table('app_tcc')->get();

        return response()->json($tccs, 200);
    }

    public function getTccByUser(Request $req) {

        $rules = [
            'id_user' => 'required'
        ];

        $msg = [ 
            'id_user.required' => 'ID do usuário não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        }
        
        $tcc = DB::table('app_tcc')->where('id_user', $req->id_user)->get();

        if (empty($tcc[0])) {

            return response()->json(['message' => 'Este usuário não possui TCC'], 400);

        } else {

            return response()->json($tcc, 200);

        }
    }

    public function novoTcc(Request $req) {

        $rules = [
            'id_user' => 'required',
            'id_category' => 'required',
            'name' => 'required',
            'area' => 'required',
            'description' => 'required',
            'logo' => 'required',
            'id_advisor' => 'required'
        ];

        $msg = [ 
            'id_user.required' => 'ID do usuário não enviado.',
            'id_category.required' => 'ID da categoria não enviado.',
            'name.required' => 'Nome do TCC não enviado.',
            'area.required' => 'Área do TCC não enviado.',
            'description.required' => 'Descrição do TCC não enviado.',
            'logo.required' => 'Logo do TCC não enviado.',
            'id_advisor.required' => 'Orientador do TCC não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
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

        $rules = [
            'id_user' => 'required',
            'id_category' => 'required',
            'name' => 'required',
            'area' => 'required',
            'description' => 'required',
            'logo' => 'required',
            'id_advisor' => 'required',
            'id' => 'required'
        ];

        $msg = [ 
            'id_user.required' => 'ID do usuário não enviado.',
            'id_category.required' => 'ID da categoria não enviado.',
            'name.required' => 'Nome do TCC não enviado.',
            'area.required' => 'Área do TCC não enviado.',
            'description.required' => 'Descrição do TCC não enviado.',
            'logo.required' => 'Logo do TCC não enviado.',
            'id_advisor.required' => 'Orientador do TCC não enviado.',
            'id.required' => 'ID do TCC não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
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
