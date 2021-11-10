<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $user = \DB::table('app_users')->where('username', $username)->where('access_key', $password)->get();

        if (empty($user[0]))
        {
            return response()->json(['message' => 'Credenciais incorretas'], 400);
        } else {
            \DB::table('app_users')->where('username', $username)->update(['last_login' => now()]);
            return response()->json(['message' => 'Autenticado com sucesso!', 'info' => $user], 200);
        }
    }
}
