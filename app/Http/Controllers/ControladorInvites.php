<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControladorInvites extends Controller
{
    public function listarInvites(Request $req) {

        $invites = DB::table('app_invites')->get();

        return response()->json(['data' => $invites], 200);

    }

    public function getInvites(Request $req, $id_user = 0) {

        $req['id_user_invited'] = $req->id_tcc;
        
        $rules = [
            'id_user_invited' => 'required'
        ];

        $msg = [
            'id_user_invited.required' => 'ID do usuário não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        }

        $invites = DB::table('app_invites')
                        ->where('id_user_invited', $req->id_user_invited)
                        ->get();

        return response()->json(['data' => $invites], 200);

    }

    public function novoInvite(Request $req) {

        $rules = [
            'id_tcc' => 'required',
            'id_user_invited' => 'required',
            'id_user_inviter' => 'required'
        ];

        $msg = [
            'id_tcc.required' => 'ID do TCC não enviado.',
            'id_user_invited.required' => 'ID do usuário não enviado.',
            'id_user_inviter.required' => 'ID do usuário que convida não enviado.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $invite = DB::table('app_invites')
                            ->where('id_user_invited', $req->id_user_invited)
                            ->get();

            if (count($invite) > 0) {
                return response()->json(['message' => 'Usuário já convidado por outro TCC, aguarde ele aceitar ou negar para enviar outro convite.'], 400);
            }

            $invite = DB::table('app_invites')->insert([
                'id_tcc' => $req->id_tcc,
                'id_user_invited' => $req->id_user_invited,
                'id_user_inviter' => $req->id_user_inviter
            ]);

            DB::commit();

            return response()->json(['message' => 'Convite enviado com sucesso.'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erro ao enviar convite.'], 400);
        }

    }

    public function updateInvite(Request $req) {
        
        $rules = [
            'id_invite' => 'required',
            'id_tcc' => 'required',
            'id_user_invited' => 'required',
            'id_user_inviter' => 'required',
            'approved' => 'required'
        ];

        $msg = [
            'id_invite.required' => 'ID do convite não enviado.',
            'id_tcc.required' => 'ID do TCC não enviado.',
            'id_user_invited.required' => 'ID do usuário não enviado.',
            'id_user_inviter.required' => 'ID do usuário que convida não enviado.',
            'approved.required' => 'Aprovação não enviada.'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        }

        try {
            DB::beginTransaction();

            DB::table('app_invites')
                ->where('id', $req->id_invite)
                ->update([
                    'id_tcc' => $req->id_tcc,
                    'id_user_invited' => $req->id_user_invited,
                    'id_user_inviter' => $req->id_user_inviter,
                    'approved' => $req->approved == true ? 1 : 0
                ]);

            DB::commit();

            return response()->json(['message' => 'Convite atualizado com sucesso.'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Erro ao atualizar convite.'], 400);
        }


    }

}
