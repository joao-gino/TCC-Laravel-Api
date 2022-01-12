<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ControladorInvites;

class ControladorLogin extends Controller
{
    public function login(Request $req)
    {

        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $msg = [ 
            'username.required' => 'Usuário não enviado',
            'password.required' => 'Senha não enviada'
        ];

        $validation = \Validator::make($req->input(), $rules, $msg);

        if($validation->fails()){
            return response()->json(['message' => $validation->errors()], 400);
        }

        $username = $req->username;
        $password = sha1($req->password);

        $user = \DB::table('app_users')
                        ->leftjoin('app_invites', 'app_invites.id_user_invited', '=', 'app_users.id')
                        ->leftjoin('app_tcc', 'app_tcc.id', '=', 'app_invites.id_tcc')
                        ->select('app_users.*', 
                                    'app_invites.id as id_invite', 
                                    'app_invites.id_user_inviter', 
                                    'app_invites.id_tcc', 
                                    'app_invites.approved as invite_approved', 
                                    'app_tcc.name as invite_tcc_name', 
                                    'app_tcc.area as invite_tcc_area', 
                                    'app_tcc.description as invite_tcc_description')
                        ->where('app_users.username', $username)
                        ->where('app_users.access_key', $password)
                        ->get();

        if(!empty($user[0]->id_user_inviter)) {

            $user_inviter = \DB::table('app_users')->where('id', $user[0]->id_user_inviter)->get();

            $user[0]->inviter_first_name = $user_inviter[0]->first_name;
            $user[0]->inviter_last_name = $user_inviter[0]->last_name;
        }

        if (empty($user[0]))
        {
            return response()->json(['message' => 'Credenciais incorretas'], 400);
        } else {
            \DB::table('app_users')->where('username', $username)->update(['last_login' => now()]);
            return response()->json(['message' => 'Autenticado com sucesso!', 'info' => $user], 200);
        }
    }
}
